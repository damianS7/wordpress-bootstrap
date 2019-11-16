<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\XtubeFrontend;
use Xtube\Frontend\Models\Setting;
use Xtube\Frontend\Models\Video;
use Xtube\Common\Paginator;

// Este es el controlador por defecto para la vista home (aunque se usa como videos)
class HomeVideosController {

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {
        if (wp_redirect($_SERVER['HTTP_REFERER'])) {
            exit;
        }
    }

    // Metodo para renderizar la vista.
    public static function render() {
        // Videos a mostrar por pagina
        $videos_per_page = Setting::get_setting('videos_per_page');
        
        // Numero de videos existentes
        $total_videos = Video::count_videos();
        
        // Numero de paginas disponibles
        $pages = ceil($total_videos / $videos_per_page);
        
        // Pagina actual
        $page = XtubeFrontend::get_query_var('xtb_pagination');
        
        $page = filter_var(
            $page,
            FILTER_VALIDATE_INT,
            array('options' => array('default'   => 1, 'min_range' => 1, 'max_range' => $pages))
        );
        
        // Offset desde que empezamos a leer resultados de la tabla
        $offset = ($page - 1) * $videos_per_page;
                
        // Videos de la vista
        $data['videos'] = Video::get_videos_paginate($videos_per_page, $offset);

        // Datos de paginacion
        $data['pagination'] = Paginator::get_pagination($pages, $page);
        return XtubeFrontend::view('home-videos', $data);
    }
}