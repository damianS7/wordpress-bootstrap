<?php
namespace Xtube\Backend\Models;

class Video {
    public static function add_video($video_url, $img_src) {
        global $wpdb;
        $table = 'XTB_VIDEOS';
        $data = array(
            'url' => $video_url,
            'img_src' => $img_src
        );
        $format = array('%s', '%s');
        
        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return false;
        }
        
        // Devolvemos el ultimo id insertado, que es el id de la cuenta
        return $wpdb->insert_id;
    }
}