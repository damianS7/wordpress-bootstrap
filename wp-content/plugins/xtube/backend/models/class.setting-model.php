<?php
namespace Xtube\Backend\Models;

class Setting {
    public static function get_settings() {
        global $wpdb;
        $query = "SELECT * FROM XTB_SETTINGS";
        return $wpdb->get_results($query);
    }

    public static function get_setting($setting_name) {
        global $wpdb;
        $query = "SELECT value FROM XTB_SETTINGS WHERE name = '{$setting_name}'";
        return $wpdb->get_row($query)->value;
    }

    // Este metodo actualiza el valor de una opcion
    public static function update_setting($name, $value) {
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