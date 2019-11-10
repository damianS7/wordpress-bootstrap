<?php
namespace Xtube\Backend\Models;

class Tag {
    public static function get_tags() {
        global $wpdb;
        $query = "SELECT * FROM XTB_TAGS";
        return $wpdb->get_results($query);
    }

    public static function add_tag($name, $description) {
        global $wpdb;
        $data = array(
            'name' => $name,
            'description' => $description
        );
        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('XTB_TAGS', $data, array('%s', '%s'))) {
            return false;
        }
        return true;
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