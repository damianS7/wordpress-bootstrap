<?php
namespace Xtube\Backend\Models;

// Esta clase interactua con la tabla XTB_VIDEOS_REPORT
class ReportedVideo {
    public static function get_reports() {
        global $wpdb;
        $query = "SELECT t_videos.id, t_videos.url, t_reports.id AS report_id, t_reports.reason 
        FROM XTB_VIDEO_REPORTS AS t_reports
        INNER JOIN XTB_VIDEOS AS t_videos
        ON t_reports.video_id = t_videos.id";
        return $wpdb->get_results($query);
    }

    // Este metodo borra un foros
    public static function delete_report($report_id) {
        global $wpdb;
        $where = array(
            'id' => $report_id
        );
        // Si no se borra nada
        if (!$wpdb->delete('XTB_VIDEO_REPORTS', $where)) {
            return false;
        }
        return true;
    }
}