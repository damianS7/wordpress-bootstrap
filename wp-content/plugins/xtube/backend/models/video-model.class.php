<?php
namespace Xtube\Backend\Models;

// Esta clase interactua con la tabla XTB_VIDEOS
class Video {
    public static function add_video_ignore($url, $title, $img_src, $duration, $upvotes, $downvotes, $views, $iframe) {
        global $wpdb;
        $wpdb->query($wpdb->prepare(
            "
        INSERT IGNORE XTB_VIDEOS
            (url, iframe, title, img_src, duration, views, upvotes, downvotes )
            VALUES (%s, %s, %s, %s, %d, %d, %d, %d )",
            $url,
            $iframe,
            $title,
            $img_src,
            $duration,
            $views,
            $upvotes,
            $downvotes
        ));
        return $wpdb->insert_id;
    }

    public static function add_video_ignore2($url, $title, $img_src, $duration, $upvotes, $downvotes, $views, $iframe) {
        global $wpdb;
        $wpdb->query($wpdb->prepare(
            "
        INSERT INTO XTB_VIDEOS
            (url, iframe, title, img_src, duration, views, upvotes, downvotes )
            VALUES (%s, %s, %s, %d, %d, %d, %d, %s )
            ON DUPLICATE KEY UPDATE url=url;",
            $url,
            $iframe,
            $title,
            $img_src,
            $duration,
            $views,
            $upvotes,
            $downvotes
        ));
    }

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