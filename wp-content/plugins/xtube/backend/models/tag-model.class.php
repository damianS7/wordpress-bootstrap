<?php
namespace Xtube\Backend\Models;

// Este metodo interactua con la tabla XTB_TAGS
class Tag {

    // Obtiene todos los tags existentes
    public static function get_tags() {
        global $wpdb;
        $query = "SELECT * FROM XTB_TAGS";
        return $wpdb->get_results($query);
    }

    // Obtiene el id del tag indicado
    public static function get_tag_id($tag_name) {
        global $wpdb;
        $query = "SELECT id FROM XTB_TAGS WHERE name = '{$tag_name}'";
        return $wpdb->get_var($query);
    }

    // Agrega un tag a la DB usando insert ignore
    public static function add_tag_ignore($name) {
        global $wpdb;
        $wpdb->query("INSERT IGNORE XTB_TAGS (name) VALUES('{$name}')");
    }

    // Agrega un tag a la db
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

    // Inserta en la tabla VIDEO_TAGS. Esta tabla contiene los tags
    // pertenecientes a cada video
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

    // Este metodo elimina un tag
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