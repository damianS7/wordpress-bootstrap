<?php
namespace Xtube\Frontend\Models;

class Tag {
    public static function get_tags() {
        global $wpdb;
        $query = "SELECT * FROM XTB_TAGS";
        return $wpdb->get_results($query);
    }

    public static function get_popular_tags() {
        global $wpdb;
        $query = "SELECT name FROM XTB_TAGS 
        INNER JOIN XTB_VIDEO_TAGS AS tvt
        ON id = tvt.tag_id
        LIMIT 10";
        return $wpdb->get_results($query);
    }
}