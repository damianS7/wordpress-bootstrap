<?php
namespace Xtube\Backend\Models;

class Tag {
    public static function get_tags() {
        global $wpdb;
        $query = "SELECT * FROM XTB_TAGS";
        return $wpdb->get_results($query);
    }

    public static function get_tag_id($tag) {
        global $wpdb;
        $query = "SELECT id FROM XTB_TAGS WHERE name = '{$tag}'";
        return $wpdb->get_var($query);
    }

    public static function add_tag_ignore($name) {
        global $wpdb;
        $wpdb->query("INSERT IGNORE XTB_TAGS (name) VALUES('{$name}')");
    }

    public static function add_tag($name) {
        global $wpdb;
        $data = array(
            'name' => $name
        );

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('XTB_TAGS', $data, array('%s'))) {
            return null;
        }

        return $wpdb->insert_id;
        //return true;
    }

    public static function add_tag_to_video($video_id, $tag_id) {
        global $wpdb;
        $data = array(
            'video_id' => $video_id,
            'tag_id' => $tag_id
        );

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('XTB_VIDEO_TAGS', $data, array('%s'))) {
            return false;
        }

        return $wpdb->insert_id;
        //return true;
    }

    // Este metodo borra un foros
    public static function delete_tag($tag_id) {
        global $wpdb;
        $where = array(
            'id' => $tag_id
        );
        // Si no se borra nada
        if (!$wpdb->delete('XTB_TAGS', $where)) {
            return false;
        }
        return true;
    }
}