<?php
namespace Xtube\Frontend\Controllers;

use Xtube\Frontend\Models\VideoReport;

class ReportVideoController {
    public static function report() {
        // Comprobacion de seguridad ajax
        check_ajax_referer('my-ajax-nonce', 'nonce');
        
        // Sanitize
        $video_id = sanitize_text_field($_POST['video_id']);
        $reason = sanitize_text_field($_POST['reason']);
        
        // El id debe ser un numero y debe haber texto
        if (!is_numeric($video_id) || empty($reason)) {
            exit;
        }

        if (VideoReport::add_report($video_id, $reason)) {
            echo 'Video reported';
        }
    }
}