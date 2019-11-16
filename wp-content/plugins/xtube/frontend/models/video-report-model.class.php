<?php
namespace Xtube\Frontend\Models;

class VideoReport {
    public static function add_report($video_id, $reason) {
        global $wpdb;
        $data = array(
            'video_id' => $video_id,
            'reason' => $reason
        );

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('XTB_VIDEO_REPORTS', $data, array('%d', '%s'))) {
            return false;
        }

        //return $wpdb->insert_id;
        return true;
    }
}