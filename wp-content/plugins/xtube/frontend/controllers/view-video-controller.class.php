<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\XtubeFrontend;
use Xtube\Frontend\Models\Setting;
use Xtube\Frontend\Models\Video;
use Xtube\Frontend\Models\Tag;
use Xtube\Common\Paginator;

class ViewVideoController {
    // Metodo para renderizar la vista.
    public static function render() {
        $video_id = XtubeFrontend::get_query_var('xtb_video');

        // El video no existe
        if (!Video::video_id_exists($video_id)) {
            return;
        }

        $video = Video::get_video($video_id);
        $tags = Tag::get_tags_from_video($video_id);

        $data['video'] = $video;
        $data['tags'] = $tags;
        return XtubeFrontend::view('view-video', $data);
    }
    
    // Metodo para contar las vistas
    public static function video_views_check() {
        if (XtubeFrontend::get_view() != 'video') {
            return;
        }

        $video_id = XtubeFrontend::get_video_id();

        // Si el video no existe ...
        if (!Video::video_id_exists($video_id)) {
            return;
        }

        $ip = XtubeFrontend::get_ip();

        if (Video::get_ip_from_video_views($video_id, $ip) == 0) {
            // Agregar view
            Video::video_views_update($video_id);
            Video::add_ip_to_video_views($video_id, $ip);
        }
    }
}