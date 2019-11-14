<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Importers\Video;

class Youtube {
    private static $domain = 'youtube.com';

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

    public static function search($keyword, $page) {
        $url = self::build_url($keyword, $page);
        $doc = new \DOMDocument;
        @$doc->loadHTMLFile($url);
        $xpath = new \DOMXpath($doc);

        $data['videos'] = self::parse_videos($xpath);
        $data['pagination'] = self::parse_pagination($xpath);
        return $data;
    }

    public static function parse_videos($xpath) {
        $videos = array();
        $video_elements = $xpath->query("//div[@id='results']//ol[@class='item-section']/li");
        foreach ($video_elements as $index => $li_node) {
            $video = new Video();
            $hrefs = $xpath->query(".//div[contains(@class, 'yt-lockup-thumbnail')]/a/@href", $li_node);
            $href = $hrefs->item(0)->nodeValue;
            $video_url = self::build_video_url($href);

            // ID del video
            $video->id = self::get_video_code($video_url);

            // Video url
            $video->url = $video_url;

            // Video thumb
            $images = $xpath->query(
                ".//div[contains(@class, 'yt-lockup-thumbnail')]//span[@class='yt-thumb-simple']/img",
                $li_node
            );
            $video->img_src = $images->item(0)->getAttribute('data-thumb');

            // Si no encontramos la image en data-thumb
            if (empty($video->img_src)) {
                // Probamos en src
                $video->img_src = $images->item(0)->getAttribute('src');
            }

            // Duracion
            $span = $xpath->query(".//div[contains(@class, 'yt-lockup-thumbnail')]//span[@class='video-time']", $li_node);
            $video->duration = $span->item(0)->nodeValue;

            // Titulo del video
            $titles = $xpath->query(".//div[contains(@class, 'yt-lockup-content')]/h3/a/@title", $li_node);
            $video->title = $titles->item(0)->nodeValue;

            // Iframe
            $video->iframe = self::build_iframe($video->id);
            $videos[] = $video;
        }
        return $videos;
    }

    public static function parse_pagination($xpath) {
        $pagination = $xpath->query("//div[contains(@class, 'search-pager')]/*");
        $links = array();

        foreach ($pagination as $index => $node) {
            //echo $node->tagName;
            $link_data = array(
                'li-class' => 'page-item',
                'link-class' => 'page-link',
                'href' => '',
                'value' => $node->nodeValue
            );

            // Si el tag es un boton significa que es la pagina actual
            if ($node->tagName == 'button') {
                $link_data['li-class'] = 'page-item active';
                $link_data['link-class'] = 'page-link btn disabled';
            }

            if ($node->tagName == 'a') {
                // Extraemos el hfref
                $href = $node->getAttribute('href');
                $span = $node->getElementsByTagName('span')->item(0);
                $span_page = $span->nodeValue;

                // Ignorar botones de atras/adelante
                if (intval($span_page) == 0) {
                    continue;
                }

                $link_data['href'] = self::build_pagination_url($href, $span_page);

                // if contains class active ...
                $link_data['li-class'] = 'page-item';
            }

            $links[] = $link_data;
        }
        return $links;
    }
}