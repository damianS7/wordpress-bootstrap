<?php
namespace Xtube\Backend\Models;

// Esta clase interactua con la tabla XTB_VIDEOS
class Video {

    // Este metodo se usa para insertar videos en la DB
    public static function add_video($url, $title, $img_src, $duration, $upvotes, $downvotes, $views, $iframe) {
        global $wpdb;
        $table = 'XTB_VIDEOS';
        $data = array(
            'url' => $url,
            'title' => $title,
            'img_src' => $img_src,
            'duration' => $duration,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'views' => $views,
            'iframe' => $iframe
        );
        $format = array('%s');
        
        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return null;
        }
        
        // Devolvemos el ultimo id insertado, que es el id de la cuenta
        return $wpdb->insert_id;
        //return true;
    }

    // Este metodo se usa para eliminar videos de la DB
    public static function delete_video($video_id) {
        global $wpdb;
        $where = array(
            'id' => $video_id
        );
        // Si no se borra nada
        if (!$wpdb->delete('XTB_VIDEOS', $where)) {
            return false;
        }
        return true;
    }
}