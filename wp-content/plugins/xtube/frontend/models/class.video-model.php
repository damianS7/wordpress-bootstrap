<?php
namespace Xtube\Frontend\Models;

class Video {
    public static function get_videos() {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos";
        return $wpdb->get_results($query);
    }

    public static function count_videos_from_tag($tag) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos AS t_videos
        JOIN XTB_VIDEO_TAGS AS t_vtag ON t_videos.id = t_vtag.video_id
        JOIN XTB_TAGS AS t_tags ON t_vtag.tag_id = t_tags.id
        WHERE name = '{$tag}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    public static function count_videos() {
        global $wpdb;
        $query = "SELECT id FROM XTB_VIDEOS";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    public static function get_videos_paginate($limit, $offset) {
        global $wpdb;
        $query = "SELECT *
            FROM XTB_VIDEOS
            LIMIT {$limit}
            OFFSET {$offset}";
        return $wpdb->get_results($query);
    }

    public static function get_video($video_id) {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEOS WHERE id = '{$video_id}'";
        return $wpdb->get_row($query);
    }

    public static function get_videos_by_tag($tag_name) {
        global $wpdb;
        $query = "SELECT t_videos.* FROM xtb_videos AS t_videos
        JOIN XTB_VIDEO_TAGS AS t_vtag ON t_videos.id = t_vtag.video_id
        JOIN XTB_TAGS AS t_tags ON t_vtag.tag_id = t_tags.id
        WHERE name = '{$tag_name}'";
        return $wpdb->get_results($query);
    }

    public static function get_paginated_videos_by_tag($tag_name, $limit, $offset) {
        global $wpdb;
        $query = "SELECT t_videos.* FROM xtb_videos AS t_videos
        JOIN XTB_VIDEO_TAGS AS t_vtag ON t_videos.id = t_vtag.video_id
        JOIN XTB_TAGS AS t_tags ON t_vtag.tag_id = t_tags.id
        WHERE name = '{$tag_name}'
        LIMIT {$limit}
        OFFSET {$offset}";
        return $wpdb->get_results($query);
    }

    public static function get_tags_from_video($video_id) {
    }

    public static function get_videos_search($term) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos WHERE title LIKE '%{$term}%'";
        return $wpdb->get_results($query);
    }
}