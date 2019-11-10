<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Importers\XVideos;
use Xtube\Backend\Importers\Pornhub;
use Xtube\Backend\Models\ReportedComment;

class CommentsController {
    public function __construct() {
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['delete_reported_comment_submit'])) {
            $report_id = sanitize_text_field($_POST['repored_comment_id']);
            ReportedComment::delete_report($report_id);
            $data['success'] = 'report deleted.';
            set_transient('view_data', $data, 10);
        }
        
        wp_redirect($_SERVER['HTTP_REFERER']);
        exit;
    }

    // Metodo para renderizar la vista.
    public function render() {
        $data = get_transient('view_data');
        if (!empty($data)) {
            delete_transient('view_data');
        }
        
        $data['reported_comments'] = ReportedComment::get_reports();
        return XtubeBackend::view('comments.php', $data);
    }
}