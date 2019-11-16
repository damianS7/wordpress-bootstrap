<?php
namespace Xtube\Frontend\Models;

class Tag {
    public static function get_tags() {
        global $wpdb;
        $query = "SELECT * FROM XTB_TAGS";
        return $wpdb->get_results($query);
    }

    public static function get_tags_from_video($video_id) {
        global $wpdb;
        $query = "SELECT name FROM XTB_TAGS AS t_tags
        JOIN XTB_VIDEO_TAGS AS t_vtag ON t_tags.id = t_vtag.tag_id
        WHERE t_vtag.video_id = '{$video_id}'";
        return $wpdb->get_results($query);
    }

    public static function get_popular_tags() {
    }
}