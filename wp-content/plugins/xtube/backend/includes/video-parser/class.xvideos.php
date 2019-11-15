<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Importers\Video;

class XVideos {
    private static $domain = 'xvideos.com';

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
        return self::get_var_from_url($url, 'p');
    }

    // Reconstruye la url del video
    public static function build_video_url($href) {
        return 'https://www.' . self::$domain . $href;
    }

    // Metodo para obtener el iframe de pornhub a partir del codigo del video
    public static function get_iframe($video_code) {
        return "<iframe src=\"https://www.xvideos.com/embedframe/$video_code\" frameborder=0 width=510 height=400 scrolling=no allowfullscreen=allowfullscreen></iframe>";
    }

    // Construye y devuelve la url de la busqueda
    public static function get_search_url($keyword, $page) {
        $url = 'https://' . self::$domain . '/';
        $url .= '?k=' . $keyword . '&p=' . $page;
        return $url;
    }

    // Metodo para crear las url de paginacion
    public static function build_pagination_url($page) {
        $href = get_admin_url() .'admin.php?page=' . $_GET['page'] . '&xtb_server=xvideos';
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
        $video_nodes = $xpath->query("//div[@class='mozaique']/div");

        // Iteracion sobre los nodos encontrados
        foreach ($video_nodes as $node) {
            // Solo necesitamos los nodos li
            if ($node->tagName == 'div') {
                // Creamos una instancia de Video con los parametros por defecto
                $video = new Video();
                
                // ID del video
                $video->id = $node->getAttribute('data-id');
            
                // Titulo del video
                $link_node = $xpath->query("div[@class='thumb-under']/p[@class='title']/a", $node);
                $video->title = self::encodeToUtf8($link_node->item(0)->nodeValue);
            
                // Video url
                $video->url = self::build_video_url($link_node->item(0)->getAttribute('href'));

                // Duracion
                $dur_node = $xpath->query("div[@class='thumb-under']/p[@class='metadata']//span[@class='duration']", $node);
                $video->duration = $dur_node->item(0)->nodeValue;

                // Video thumb
                $thumb_node = $xpath->query("div[@class='thumb-inside']//img", $node);
                $video->img_src = $thumb_node->item(0)->getAttribute('data-src') ;
                $video->iframe = self::get_iframe($video->id);
                
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
        $pagination = $xpath->query("//div[@id='content']/div[@class='pagination ']/ul/li");
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
                $link_node = $node->childNodes->item(0);
                
                // Si el primer child de $node es un link ...
                if ($link_node->tagName == 'a') {
                    // Extraemos el hhref
                    $href = $link_node->getAttribute('href');
                    
                    // Si href no esta vacio ..
                    if (!empty($href) && $href != '#') {
                        // Obtenemos el numero de pagina
                        $page = self::get_page_url($href);
                        
                        // Si el numero de pagina no se pudo extraer
                        if (empty($page)) {
                            // Ponemos 0 por defecto
                            $page = '0';
                        }
                        // Y agregamos la url del enlace
                        $link_data['href'] = self::build_pagination_url($page);
                    }
                    
                    // Si el href esta vacio o no es un enlace a una pagina
                    if (empty($href) || $href == '#') {
                        // Quiere decir que estamos ante un enlace no navegable
                        // Por lo que lo definimos como un tag span
                        $link_data['tag'] = 'span';
                        
                        // Si este enlace no navegable, es un numero, es la pagina actual
                        if (is_numeric($link_node->nodeValue)) {
                            $link_data['li-class'] = 'page-item active';
                        } else {
                            $link_data['li-class'] = 'page-item disabled';
                        }
                    }

                    // Valor del enlace
                    $link_data['value'] = $link_node->nodeValue;
                    $links[] = $link_data;
                }
            }
        }

        return $links;
    }
}