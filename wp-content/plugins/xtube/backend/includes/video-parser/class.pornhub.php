<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Importers\Video;

class Pornhub {
    private static $domain = 'pornhub.com';

    // Codifica el texto a utf8
    public static function encodeToUtf8($string) {
        return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }

    // Este metodo extrae el valor de una variable de una url
    public static function get_var_from_url($url, $var_name) {
        $parsed_url = parse_url($url);
        $parsed_str = parse_str($parsed_url['query'], $output);

        if (!isset($output[$var_name])) {
            return null;
        }

        return $output[$var_name];
    }

    // Extrae el codigo del video de la url
    public static function get_video_code($url) {
        return self::get_var_from_url($url, 'viewkey');
    }

    // Devuelve el numero de pagina buscando en la url
    public static function get_page_url($url) {
        return self::get_var_from_url($url, 'page');
    }

    // Reconstruye la url del video
    public static function build_video_url($href) {
        return 'https://www.' . self::$domain . $href;
    }

    // Metodo para obtener el iframe de pornhub a partir del codigo del video
    public static function get_iframe($video_code) {
        return "<iframe src=\"https://es.pornhub.com/embed/$video_code\" frameborder=\"0\" width=\"560\" height=\"315\"
            scrolling=\"no\" allowfullscreen></iframe>";
    }

    // Construye y devuelve la url de la busqueda
    public static function get_search_url($keyword, $page) {
        $url = 'https://' . self::$domain . '/';
        $url .= 'video/search?search=' . $keyword . '&page=' . $page;
        return $url;
    }

    // Metodo para crear las url de paginacion
    public static function build_pagination_url($page) {
        $href = get_admin_url() .'admin.php?page=' . $_GET['page'] . '&xtb_server=pornhub';
        $href .= '&xtb_keyword=' . $_GET['xtb_keyword'] . '&xtb_pagination=' . $page;
        return $href;
    }

    // Metodo principal de busqueda
    public static function search($keyword, $page) {
        $url = self::get_search_url($keyword, $page);
        $doc = new \DOMDocument;
        
        $opts = array(
            "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0\r\n")
        );

        $context = stream_context_create($opts);
        libxml_set_streams_context($context);
        
        @$doc->loadHTMLFile($url);
        
        $xpath = new \DOMXpath($doc);
        $data['videos'] = self::parse_videos($xpath);
        $data['pagination'] = self::parse_pagination($xpath);
        return $data;
    }
    
    // Este metodo extrae los videos y sus datos de la pagina de busqueda
    public static function parse_videos($xpath) {
        // Array con los videos a retornar
        $videos = array();

        // Xpath donde buscar los videos
        $video_nodes = $xpath->query("//ul[@id='videoSearchResult']//li[contains(@class, 'videoblock')]");

        // Iteracion sobre los nodos encontrados
        foreach ($video_nodes as $node) {

            // Solo necesitamos los nodos li
            if ($node->tagName == 'li') {
                // Creamos una instancia de Video con los parametros por defecto
                $video = new Video();
                
                // ID del video
                $video->id = $node->getAttribute('_vkey');

                // Video title
                $link_node = $xpath->query("./div[@class='wrap']/div//div[contains(@class, 'videoPreviewBg')]/a", $node);
                $video->title = self::encodeToUtf8(utf8_decode($link_node->item(0)->getAttribute('title')));

                // Video url
                $video->url = self::build_video_url($link_node->item(0)->getAttribute('href'));

                // Duracion
                $dur_node = $xpath->query("./div[@class='wrap']/div//div[contains(@class, 'videoPreviewBg')]/div/var", $node);
                $video->duration = $dur_node->item(0)->nodeValue;

                // Image url
                $img_node = $xpath->query("./div[@class='wrap']/div//div[contains(@class, 'videoPreviewBg')]/a/img", $node);
                $video->img_src = $img_node->item(0)->getAttribute('data-thumb_url');

                $video_code = self::get_video_code($video->url);
                $video->iframe = self::get_iframe($video_code);

                // Agregamos el video al array
                $videos[] = $video;
            }
        }

        return $videos;
    }

    // Este metodo extrae la paginacion de la pagina
    public static function parse_pagination($xpath) {
        // Enlaces de la paginacion
        $links = array();

        // Nodes de paginacion
        $pagination = $xpath->query("//div[@class='nf-wrapper']/div[@class='pagination3']/ul/li");

        // Iteracion sobre los nodos de paginacion
        foreach ($pagination as $node) {
            // Datos por defecto del enlace
            $link_data = array(
                'li-class' => 'page-item',
                'link-class' => 'page-link',
                'href' => '',
                'tag' => '',
                'value' => ''
            );

            // Solo necesitamos los nodos li
            if ($node->tagName == 'li') {
                // Obtenemos los enlaces dentro del elemento li
                $child_node = $node->childNodes->item(0);
                
                // Enlace de paginacion no navegable
                if ($child_node->tagName == 'span') {
                    $link_data['tag'] = 'span';
                    $link_data['li-class'] = 'page-item disabled';
                    
                    // Si es un numero, es la pagina actual
                    if (is_numeric($child_node->nodeValue)) {
                        $link_data['li-class'] = 'page-item active';
                    }
                }
                
                // Si es un enlace ...
                if ($child_node->tagName == 'a') {
                    // Extraemos el numero de la pagina
                    $page = self::get_page_url($child_node->getAttribute('href'));

                    // Creamos la direccion url que llevara el enlace
                    $link_data['href'] = self::build_pagination_url($page);
                }
                
                $link_data['value'] = $child_node->nodeValue;
                $links[] = $link_data;
            }
        }

        return $links;
    }
}