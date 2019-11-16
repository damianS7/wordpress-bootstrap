<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Video;

class VideoController {

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['create_video'])) {
            $title = sanitize_text_field($_POST['title']);
            $duration = sanitize_text_field($_POST['duration']);
            $url = sanitize_text_field($_POST['video_url']);
            $img = sanitize_text_field($_POST['img_src']);
            $tags = sanitize_text_field($_POST['tags']);

            //$url, $title, $img_src, $duration, $tags, $upvotes, $downvotes, $views
            if (Video::add_video($url, $title, $img, $duration, $tags, 0, 0, 0)) {
                $data['success'] = 'Video added.';
                set_transient('posts_view_data', $data, 60*60*2);
            }
        }

        if (wp_redirect($_SERVER['HTTP_REFERER'])) {
            exit;
        }
    }

    // Metodo para renderizar la vista.
    public function render() {
        $data['posts'] = array();
        $view_data = get_transient('posts_view_data');
        if (!empty($view_data)) {
            delete_transient('posts_view_data');
            $data = array_merge($view_data, $data);
        }

        return XtubeBackend::view('videos.php', $data);
    }
}