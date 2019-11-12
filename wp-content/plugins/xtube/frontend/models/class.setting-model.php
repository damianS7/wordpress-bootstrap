<?php
namespace Xtube\Frontend\Models;

class Setting {
    public static function get_setting($setting_name) {
        global $wpdb;
        $query = "SELECT value FROM XTB_SETTINGS WHERE name = '{$setting_name}'";
        return $wpdb->get_row($query)->value;
    }
}