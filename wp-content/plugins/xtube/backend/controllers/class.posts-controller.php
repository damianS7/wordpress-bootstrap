<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Video;
use Xtube\Backend\Models\Post;

class PostsController {

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['create_post'])) {
            $title = sanitize_text_field($_POST['title']);
            $content = sanitize_text_field($_POST['content']);
            $video_url = sanitize_text_field($_POST['video_url']);
            $img_src = sanitize_text_field($_POST['img_src']);
            $tags = sanitize_text_field($_POST['tags']);

            $video_id = Video::add_video($video_url, $img_src);
            if (Post::add_post($title, $content, $tags, $video_id)) {
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
        $data['posts'] = Post::get_posts();
        $view_data = get_transient('posts_view_data');
        if (!empty($view_data)) {
            delete_transient('posts_view_data');
            $data = array_merge($view_data, $data);
        }

        return XtubeBackend::view('posts.php', $data);
    }
}