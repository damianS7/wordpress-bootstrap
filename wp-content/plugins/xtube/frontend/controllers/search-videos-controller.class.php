<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\XtubeFrontend;
use Xtube\Frontend\Models\Setting;
use Xtube\Frontend\Models\Video;
use Xtube\Common\Paginator;

class SearchVideosController {
    public static function redirect() {
        if (wp_redirect(XtubeFrontend::pagination_url('search', $_POST['keyword'], 1))) {
            exit;
        }
    }
    
    // Metodo para renderizar la vista.
    public static function render() {
        $keyword = XtubeFrontend::get_keyword();
        // Posts por pagina
        $videos_per_page = Setting::get_setting('videos_per_page');
        
        // Numero de posts del topic
        $total_videos = Video::count_videos_with_keyword($keyword);
        
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
                
        // Videos de la vista
        $data['videos'] = Video::get_paginated_videos_search($keyword, $videos_per_page, $offset);

        // Datos de paginacion
        $data['pagination'] = Paginator::get_pagination($pages, $page);
        return XtubeFrontend::view('search-videos', $data);
    }
}