<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\XtubeFrontend;
use Xtube\Frontend\Models\Setting;
use Xtube\Frontend\Models\Video;
use Xtube\Frontend\Models\Tag;
use Xtube\Common\Paginator;

class VoteVideoController {
    public static function vote() {
        // Comprobacion de seguridad ajax
        check_ajax_referer('my-ajax-nonce', 'nonce');

        // Sanitize
        $vote = sanitize_text_field($_POST['vote']);
        $video_id = sanitize_text_field($_POST['video_id']);
        $ip = XtubeFrontend::get_ip();

        
        // El id debe ser un numero
        if (!is_numeric($video_id)) {
            exit;
        }
        
        // Si no encontramos ninguna fila, el usuario no voto en este video
        if (Video::get_ip_from_video_votes($video_id, $ip) == 0) {
            // +1
            $vote_value = 1;
            
            // Si el voto es negativo cambiamos a-1
            if ($vote == 'n') {
                $vote_value = -1;
            }
            
            // Insertamos el voto
            Video::video_vote($video_id, $vote_value);

            // Impedimos que vuelva a votar el mismo video
            Video::add_ip_to_video_votes($video_id, $ip);
        }
    }
}