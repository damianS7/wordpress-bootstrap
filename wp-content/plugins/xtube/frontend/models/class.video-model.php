<?php
namespace Xtube\Frontend\Models;

class Video {
    public static function get_videos() {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos";
        return $wpdb->get_results($query);
    }

    public static function get_video($video_id) {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEOS WHERE id = '{$video_id}'";
        return $wpdb->get_row($query);
    }

    public static function get_videos_by_tag($tag_name) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos WHERE tags LIKE '%{$tag_name}%'";
        return $wpdb->get_results($query);
    }

    public static function get_videos_search($term) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos WHERE title LIKE '%{$term}%'";
        return $wpdb->get_results($query);
    }
}