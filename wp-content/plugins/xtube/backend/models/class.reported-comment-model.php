<?php
namespace Xtube\Backend\Models;

class ReportedComment {
    public static function get_reports() {
        global $wpdb;
        $query = "SELECT * FROM XTB_REPORTED_COMMENTS";
        return $wpdb->get_results($query);
    }

    // Este metodo borra un foros
    public static function delete_report($report_id) {
        global $wpdb;
        $where = array(
            'id' => $report_id
        );
        // Si no se borra nada
        if (!$wpdb->delete('XTB_REPORTED_COMMENTS', $where)) {
            return false;
        }
        return true;
    }
}