<?php
namespace Xtube\Backend\Models;

// Esta clase interactua con la tab la XTB_SETTINGS
class Setting {
    // Este metodo devuelve todas las filas de la tabla XTB_SETTINGS
    public static function get_settings() {
        global $wpdb;
        $query = "SELECT * FROM XTB_SETTINGS";
        return $wpdb->get_results($query);
    }

    // Este metodo devuelve el valor de la opcion indicada.
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