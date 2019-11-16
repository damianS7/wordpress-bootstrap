<?php
namespace Xtube\Backend\Models;

// Esta clase interactua con la tabla XTB_VIDEOS_REPORT
class ReportedVideo {
    public static function get_reports() {
        global $wpdb;
        $query = "SELECT * FROM XTB_VIDEOS_REPORT";
        return $wpdb->get_results($query);
    }

    // Este metodo borra un foros
    public static function delete_report($report_id) {
        global $wpdb;
        $where = array(
            'id' => $report_id
        );
        // Si no se borra nada
        if (!$wpdb->delete('XTB_VIDEOS_REPORT', $where)) {
            return false;
        }
        return true;
    }
}