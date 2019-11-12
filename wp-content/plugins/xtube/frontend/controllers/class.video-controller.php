<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\XtubeFrontend;
use Xtube\Frontend\Models\Setting;
use Xtube\Frontend\Models\Video;
use Xtube\Common\Paginator;

class VideoController {
    public static function get_videos() {
        // Posts por pagina
        $videos_per_page = Setting::get_setting('posts_per_page');
        
        // Numero de posts del topic
        $total_videos = Video::count_videos();
        
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
        return Video::get_videos_paginate($videos_per_page, $offset);
    }

    public static function print_pagination() {
        $page = XtubeFrontend::get_query_var('xtb_pagination');
        $videos_per_page = Setting::get_setting('posts_per_page');
        // Numero de posts del topic
        $total_videos = Video::count_videos();
        
        // Paginas en las que se divide el topic
        $pages = ceil($total_videos / $videos_per_page);

        $data['pagination'] = Paginator::get_pagination($pages, $page);
        include(PLUGIN_DIR . 'frontend/views/pagination.php');
    }
}