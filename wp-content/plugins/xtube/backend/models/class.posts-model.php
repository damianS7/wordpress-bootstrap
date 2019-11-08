<?php
namespace Xtube\Backend\Models;

class Post {
    public static function add_post($title, $post, $tags, $video_id) {
        global $wpdb;
        $table = 'XTB_POSTS';
        $data = array(
            'title' => $title,
            'post' => $post,
            'tags' => $tags,
            'video_id' => $video_id
        );
        $format = array('%s', '%s', '%s', '%d');
        
        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return false;
        }
        
        // Devolvemos el ultimo id insertado, que es el id de la cuenta
        return $wpdb->insert_id;
    }
    
    public static function get_posts() {
        global $wpdb;
        $query = "SELECT * FROM XTB_POSTS";
        return $wpdb->get_results($query);
    }

    public static function get_post($post_id) {
        global $wpdb;
        $query = "SELECT value FROM XTB_SETTINGS WHERE name = '{$setting_name}'";
        return $wpdb->get_row($query)->value;
    }

    // Este metodo actualiza el valor de una opcion
    public static function update_post($name, $value) {
        global $wpdb;
        
        $data = array(
            'value' => $value
        );
        
        $where = array(
            'name' => $name
        );
        
        if (!$wpdb->update('XTB_SETTINGS', $data, $where)) {
            return false;
        }
        return true;
    }
}