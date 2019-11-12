<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\XtubeFrontend;
use Xtube\Frontend\Models\Setting;
use Xtube\Frontend\Models\Video;
use Xtube\Common\Paginator;

class TagController {
    public static function get_videos() {
        $tag_name = XtubeFrontend::get_tag();

        // Posts por pagina
        $videos_per_page = Setting::get_setting('posts_per_page');
        
        // Numero de posts del topic
        $total_videos = Video::count_videos_from_tag($tag_name);
        
        // Paginas en las que se divide el topic
        $pages = ceil($total_videos / $videos_per_page);
        
        // Pagina actual
        $page = XtubeFrontend::get_query_var('xtb_pagination');
        
        $page = filter_var($page, FILTER_VALIDATE_INT, array(
            'options' => array(
                            'default'   => 1,
                            'min_range' => 1,
                            'max_range' => $pages)
        ));
        
        // Offset desde que empezamos a leer resultados de la tabla
        $offset = ($page - 1) * $videos_per_page;
                
        // Posts del topic
        return Video::get_paginated_videos_by_tag($tag_name, $videos_per_page, $offset);
    }

    public static function print_pagination() {
        $tag_name = XtubeFrontend::get_tag();

        $page = XtubeFrontend::get_query_var('xtb_pagination');
        $videos_per_page = Setting::get_setting('posts_per_page');
        
        // Numero de posts del topic
        $total_videos = Video::count_videos_from_tag($tag_name);
        
        // Paginas en las que se divide el topic
        $pages = ceil($total_videos / $videos_per_page);

        $data['pagination'] = Paginator::get_pagination($pages, $page);
        include(PLUGIN_DIR . 'frontend/views/pagination.php');
    }
}