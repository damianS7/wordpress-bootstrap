<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Importers\Video;

class Pornhub {
    private static $url = 'https://pornhub.com';
    
    public static function get_videos($term = 'teen', $page = '0') {
        $url = 'https://pornhub.com/video/search?search=' . $term . '&page=' . $page;
        echo $url;
        $opts = array(
            "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0\r\n")
        );

        $context = stream_context_create($opts);
        libxml_set_streams_context($context);
        
        $doc = new \DOMDocument;
        $doc->preserveWhiteSpace = false;
        $doc->validateOnParse = true;
        @$doc->loadHTMLFile($url);
        
        $xpath = new \DOMXpath($doc);
        $elements = $xpath->query("//ul[@id='videoSearchResult']//li[contains(@class, 'videoblock')]");
        
        $videos = array();
        foreach ($elements as $element) {
            $video = new Video();
            // ID del video
            $video->id = $element->getAttribute('_vkey');
            
            // Video title
            $node = $xpath->query("div[@class='wrap']/div//div[contains(@class, 'videoPreviewBg')]/a", $element);
            $video->title = $node->item(0)->getAttribute('title');

            // Video url
            $node = $xpath->query("div[@class='wrap']/div//div[contains(@class, 'videoPreviewBg')]/a", $element);
            $video->url = Pornhub::$url . $node->item(0)->getAttribute('href');

            // Image url
            $node = $xpath->query("div[@class='wrap']/div//div[contains(@class, 'videoPreviewBg')]/a/img", $element);
            $video->img_src = $node->item(0)->getAttribute('data-thumb_url');

            $videos[] = $video;
        }
        
        $nodes = $xpath->query("//div[@class='nf-wrapper']/div[@class='pagination3']/ul/li");
        foreach ($nodes as $node) {
            $link = $node->getElementsByTagName('a')->item(0);
            if ($link === null) {
                $node->getElementsByTagName('span')->item(0)->setAttribute('class', 'page-link');
                $node->setAttribute('class', 'page-item');
                $link = $node;
                $link->setAttribute('href', $url);
            }

            $images = $link->getElementsByTagName('img');
            foreach ($images as $image) {
                $link->removeChild($image);
            }
            
            // Pagina
            $parsed_url = parse_url($link->getAttribute('href'));
            $parsed_str = parse_str($parsed_url['query'], $output);
            $page = $output['page'];
            
            $link->setAttribute('class', 'page-link');
            //echo '<br>page: ' . $page . ' vs ' . $_GET['xtb_pagination'] . '<br>';
            if ($page == $_GET['xtb_pagination']) {
                $node->setAttribute('class', 'page-item active');
            } else {
                $node->setAttribute('class', 'page-item');
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