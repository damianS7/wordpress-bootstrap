<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Importers\XVideos;
use Xtube\Backend\Importers\Pornhub;
use Xtube\Backend\Models\ReportedVideo;
use Xtube\Backend\Models\Video;

class ReportedVideosController {

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        $report_id = sanitize_text_field($_POST['report_id']);
        $video_id = sanitize_text_field($_POST['video_id']);
        
        if (isset($_POST['delete_report'])) {
            ReportedVideo::delete_report($report_id);
            $data['success'] = 'report deleted.';
            set_transient('view_data', $data, 10);
        }
            
        if (isset($_POST['delete_video'])) {
            ReportedVideo::delete_report($report_id);
            Video::delete_video($video_id);
            $data['success'] = 'report & video deleted.';
            set_transient('view_data', $data, 10);
        }
        
        if (wp_redirect($_SERVER['HTTP_REFERER'])) {
            exit;
        }
    }

    // Metodo para renderizar la vista.
    public function render() {
        $data = get_transient('view_data');
        if (!empty($data)) {
            delete_transient('view_data');
        }
        
        $data['reported_videos'] = ReportedVideo::get_reports();
        return XtubeBackend::view('reported-videos.php', $data);
    }
}