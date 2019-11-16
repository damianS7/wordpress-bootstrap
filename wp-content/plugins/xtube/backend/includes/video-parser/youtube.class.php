<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Importers\Video;

class Youtube {
    private static $domain = 'youtube.com';

    public static function encodeToUtf8($string) {
        $string = htmlentities($string);
        return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }

    public static function build_url($keyword, $page) {
        $url = 'https://www.' . self::$domain;
        $url .= '/results?search_query=';
        $url .= $keyword . '&page=' . $page;
        $url .= '&disable_polymer=true&sp=EgIQAQ%253D%253D';
        return  $url;
    }

    public static function build_video_url($href) {
        return 'https://www.' . self::$domain . $href;
    }

    public static function build_pagination_url($href, $page) {
        $href = get_admin_url() .'admin.php?page=' . $_GET['page'] . '&xtb_server=' . $_GET['xtb_server'];
        $href .= '&xtb_keyword=' . $_GET['xtb_keyword'] . '&xtb_pagination=' . $page;
        return $href;
    }

    public static function get_video_code($url) {
        $parsed_url = parse_url($url);
        $parsed_str = parse_str($parsed_url['query'], $output);
        return $output['v'];
    }

    public static function build_iframe($video_code) {
        return "<iframe src=\"https://www.youtube.com/embed/$video_code\" allow=\"accelerometer; encrypted-media; gyroscope; picture-in-picture\" frameborder=0 width=510 height=400 scrolling=no allowfullscreen></iframe>";
    }

    // Metodo principal de busqueda
    public static function search($keyword, $page) {
        $url = self::build_url($keyword, $page);
        $doc = new \DOMDocument;
        @$doc->loadHTMLFile($url);
        $xpath = new \DOMXpath($doc);

        $data['videos'] = self::parse_videos($xpath);
        $data['pagination'] = self::parse_pagination($xpath);
        return $data;
    }

    // Este metodo extrae los videos y sus datos de la pagina de busqueda
    public static function parse_videos($xpath) {
        // Array que contendra los videos
        $videos = array();

        // Nodos li extraidos
        $video_elements = $xpath->query("//div[@id='results']//ol[@class='item-section']/li");

        // Iteracion sobre cada nodo li
        foreach ($video_elements as $index => $li_node) {
            $class_div = $li_node->childNodes->item(0)->getAttribute('class');
            if (strpos($class_div, 'ads-container') !== false) {
                continue;
            }

            // Creamos una instancia de Video con los parametros por defecto
            $video = new Video();

            // Buscamos el enlace del video
            $hrefs = $xpath->query(".//div[contains(@class, 'yt-lockup-thumbnail')]/a/@href", $li_node);
            $href = $hrefs->item(0)->nodeValue;

            // El enlace del video no utiliza la ruta absoluta sino relativa por lo que
            // renconstruimos la url agregandole los parametros que faltan.
            $video->url = self::build_video_url($href);

            // ID del video que obtenemos desde la url
            $video->id = self::get_video_code($video->url);

            // Video thumb
            $images = $xpath->query(".//div[contains(@class, 'yt-lockup-thumbnail')]//span[@class='yt-thumb-simple']/img", $li_node);
            $video->img_src = $images->item(0)->getAttribute('data-thumb');

            // Es posible que la imagen no se encuentre en el atributo data-thumb
            // Si no encontramos la image en data-thumb, buscamos en src
            if (empty($video->img_src)) {
                $video->img_src = $images->item(0)->getAttribute('src');
            }

            // Duracion
            $span = $xpath->query(".//div[contains(@class, 'yt-lockup-thumbnail')]//span[@class='video-time']", $li_node);
            
            // Si no se encontro el texto con la duracion, es un stream en directo
            if (count($span) == 0) {
                continue;
            }
            
            $video->duration = $span->item(0)->nodeValue;

            // Titulo del video
            $titles = $xpath->query(".//div[contains(@class, 'yt-lockup-content')]/h3/a/@title", $li_node);
            $video->title = self::encodeToUtf8(utf8_decode($titles->item(0)->nodeValue));

            // Iframe
            $video->iframe = self::build_iframe($video->id);
            $videos[] = $video;
        }
        return $videos;
    }

    // Este metodo extrae la paginacion de la pagina
    public static function parse_pagination($xpath) {
        // Enlaces de la paginacion
        $links = array();
        
        // Xpath donde se encuentra la paginacion
        $pagination = $xpath->query("//div[contains(@class, 'search-pager')]/*");

        // Iteramos sobre los nodos
        foreach ($pagination as $index => $node) {
            // Datos por defecto del enlace
            $link_data = array(
                'li-class' => 'page-item',
                'link-class' => 'page-link',
                'href' => '',
                'tag' => '',
                'value' => $node->nodeValue
            );

            // Si el tag es un boton significa que es la pagina actual
            if ($node->tagName == 'button') {
                $link_data['tag'] = 'span';
                $link_data['li-class'] = 'page-item active';
            }

            // Si el nodo es un enlace (a), entonces podemos navegar sobre el.
            if ($node->tagName == 'a') {
                // Extraemos el hfref
                $href = $node->getAttribute('href');
                $span = $node->getElementsByTagName('span')->item(0);
                $span_page = $span->nodeValue;

                // Ignorar botones de atras/adelante, solo si contiene un numero
                // Interpretamos el boton.
                if (!is_numeric($span_page)) {
                    continue;
                }

                // Creamos la direccion url que llevara el enlace
                $link_data['href'] = self::build_pagination_url($href, $span_page);

                // if contains class active ...
                $link_data['li-class'] = 'page-item';
            }

            $links[] = $link_data;
        }
        return $links;
    }
}