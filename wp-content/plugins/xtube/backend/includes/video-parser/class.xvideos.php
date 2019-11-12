<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Importers\Video;

class XVideos {
    private static $url = 'https://xvideos.com';

    public static function get_video_code($url) {
        $parsed_url = parse_url($url);
        $parsed_str = parse_str($parsed_url['query'], $output);
        return $output['viewkey'];
    }

    public static function get_iframe($video_code) {
        return "<iframe src=\"https://www.xvideos.com/embedframe/$video_code\" frameborder=0 width=510 height=400 scrolling=no allowfullscreen=allowfullscreen></iframe>";
    }
    
    public static function get_videos($term = 'teen', $page = '0') {
        $url = 'https://www.xvideos.com/?k=' . $term . '&p=' . $page;
        echo $url;
        $doc = new \DOMDocument;
        $doc->preserveWhiteSpace = false;
        @$doc->loadHTMLFile($url);
        $xpath = new \DOMXpath($doc);
        $elements = $xpath->query("//div[@class='mozaique']/div");
        
        $videos = array();
        foreach ($elements as $index => $element) {
            $video = new Video();
            
            // ID del video
            $video->id = $element->getAttribute('data-id');
            
            // Titulo del video
            $node = $xpath->query("div[@class='thumb-under']/p[@class='title']/a", $element);
            $video->title = $node->item(0)->nodeValue; // get the first node in the list which is a DOMAttr
            
            // Video url
            $video->url = XVideos::$url . $node->item(0)->getAttribute('href');

            // Duracion
            $node = $xpath->query("div[@class='thumb-under']/p[@class='metadata']//span[@class='duration']", $element);
            $video->duration = $node->item(0)->nodeValue; // get the first node in the list which is a DOMAttr

            // Video thumb
            $node = $xpath->query("div[@class='thumb-inside']//img", $element);
            $video->img_src = $node->item(0)->getAttribute('data-src') ;

            $video->iframe = Xvideos::get_iframe($video->id);

            $videos[] = $video;
        }
        
        $nodes = $xpath->query("//div[@id='content']/div[@class='pagination ']/ul/li");
        foreach ($nodes as $index => $node) {
            $link = $node->getElementsByTagName('a')->item(0);
            if ($link === null) {
                continue;
            }

            if (empty($link->getAttribute('href'))) {
                $link->setAttribute('href', $url);
            }

            // Pagina
            if ($link->nodeValue != '...') {
                $parsed_url = parse_url($link->getAttribute('href'));
                $parsed_str = parse_str($parsed_url['query'], $output);
                $page = $output['p'];
            }

            if (empty($page)) {
                $page = 0;
            }

            $link->setAttribute('class', 'page-link');
            if ($page == $_GET['xtb_pagination']) {
                $node->setAttribute('class', 'page-item active');
            } else {
                $node->setAttribute('class', 'page-item');
            }

            if ($link->nodeValue == '...') {
                $node->setAttribute('class', 'page-item disabled');
            }

            // Construccion de la url
            $href = home_url() .'/wp-admin/admin.php?page=' . $_GET['page'] . '&xtb_server=' . $_GET['xtb_server'];
            $href .= '&xtb_keyword=' . $_GET['xtb_keyword'] . '&xtb_pagination=' . $page;
            $link->setAttribute('href', $href);
        }


        $newdoc = new \DOMDocument;
        $newdoc->formatOutput = true;
        $nodeUL = $newdoc->createElement('ul');
        $nodeUL->setAttribute('class', 'pagination');
        
        foreach ($nodes as $node) {
            $x = $newdoc->importNode($node, true);
            $nodeUL->appendChild($x);
        }
        
        $newdoc->appendChild($nodeUL);
        $html = $newdoc->saveHTML();
        $data['videos'] = $videos;
        $data['pagination'] = $html;
        return $data;
    }
}