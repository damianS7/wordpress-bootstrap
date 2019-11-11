<?php
namespace Xtube\Frontend\Models;

class Tag {
    public static function get_tags() {
        global $wpdb;
        $query = "SELECT * FROM XTB_TAGS";
        return $wpdb->get_results($query);
    }
}