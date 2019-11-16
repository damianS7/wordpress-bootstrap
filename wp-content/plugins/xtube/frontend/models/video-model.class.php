<?php
namespace Xtube\Frontend\Models;

class Video {

    // Este metodo devuelve la informacion sobre un video
    public static function get_video($video_id) {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEOS WHERE id = '{$video_id}'";
        return $wpdb->get_row($query);
    }
    
    // Devuelve todos los videos disponibles sin paginar
    public static function get_videos() {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos ORDER BY posted_at DESC";
        return $wpdb->get_results($query);
    }

    // Devuelve los videos usando paginacion
    public static function get_paginated_videos($limit, $offset) {
        global $wpdb;
        $query = "SELECT *
            FROM XTB_VIDEOS ORDER BY posted_at DESC
            LIMIT {$limit}
            OFFSET {$offset}";
        return $wpdb->get_results($query);
    }

    // Devuelve los videos paginados bajo un tag
    public static function get_paginated_videos_by_tag($tag_name, $limit, $offset) {
        global $wpdb;
        $query = "SELECT t_videos.* FROM xtb_videos AS t_videos
        JOIN XTB_VIDEO_TAGS AS t_vtag ON t_videos.id = t_vtag.video_id
        JOIN XTB_TAGS AS t_tags ON t_vtag.tag_id = t_tags.id
        WHERE name = '{$tag_name}' ORDER BY t_videos.posted_at DESC
        LIMIT {$limit}
        OFFSET {$offset}";
        return $wpdb->get_results($query);
    }

    // Devuelve los videos paginados que con tienen el keyword determinado
    public static function get_paginated_videos_search($keyword, $limit, $offset) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos
        WHERE title LIKE '%{$keyword}%'
        LIMIT {$limit}
        OFFSET {$offset}";
        return $wpdb->get_results($query);
    }

    // Metodo para actualizar el numero de votos del video
    public static function video_vote($video_id, $vote) {
        global $wpdb;
        $query = "UPDATE xtb_videos SET votes = votes + ({$vote}) WHERE id = '{$video_id}'";
        $wpdb->query($query);
    }

    // Metodo para actualizar el numero de visualizaciones de un video
    public static function video_views_update($video_id) {
        global $wpdb;
        $query = "UPDATE xtb_videos SET views = views + 1 WHERE id = '{$video_id}'";
        $wpdb->query($query);
    }

    // Metodo para comprobar si un video con el id determinado existe
    public static function video_id_exists($video_id) {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEOS WHERE id = '{$video_id}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Cuenta el numero total de videos
    public static function count_videos() {
        global $wpdb;
        $query = "SELECT id FROM XTB_VIDEOS";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Cuenta el numero de videos que existen bajo un tag
    public static function count_videos_with_tag($tag) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos AS t_videos
        JOIN XTB_VIDEO_TAGS AS t_vtag ON t_videos.id = t_vtag.video_id
        JOIN XTB_TAGS AS t_tags ON t_vtag.tag_id = t_tags.id
        WHERE name = '{$tag}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Cuenta el numero de videos con un keyword
    public static function count_videos_with_keyword($keyword) {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos
        WHERE title LIKE '%{$keyword}%'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Devuelve el TOP 10 de los videos mas vistos
    public static function get_top_videos() {
        global $wpdb;
        $query = "SELECT * FROM xtb_videos ORDER BY views DESC LIMIT 10";
        return $wpdb->get_results($query);
    }
    
    // Relaciona una IP con un video para que no vuelva a contar la vista
    public static function add_ip_to_video_views($video_id, $ip) {
        global $wpdb;
        $data = array(
            'video_id' => $video_id,
            'ip' => $ip
        );

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('XTB_VIDEO_VIEWS_IP', $data, array('%d', '%s'))) {
            return false;
        }

        return true;
    }

    // Relaciona una ip con un video para que solo se pueda votar un video por ip
    public static function add_ip_to_video_votes($video_id, $ip) {
        global $wpdb;
        $data = array(
            'video_id' => $video_id,
            'ip' => $ip
        );

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('XTB_VIDEO_VOTES_IP', $data, array('%d', '%s'))) {
            return false;
        }

        return true;
    }

    // Este metodo se usa para comprobar si una IP ha sido contada como vista
    // para un video determinado
    public static function get_ip_from_video_views($video_id, $ip) {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEO_VIEWS_IP WHERE video_id = '{$video_id}'
        AND ip ='{$ip}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Este metodo se usa para comprobar si una IP ha sido contada como votos
    // para un video determinado
    public static function get_ip_from_video_votes($video_id, $ip) {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEO_VOTES_IP WHERE video_id = '{$video_id}'
        AND ip ='{$ip}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }
}