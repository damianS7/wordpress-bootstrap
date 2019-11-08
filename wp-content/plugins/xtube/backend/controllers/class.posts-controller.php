<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Video;
use Xtube\Backend\Models\Post;

class PostsController {
    public function view_posts() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }
        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['create_post'])) {
            $title = sanitize_text_field($_POST['title']);
            $content = sanitize_text_field($_POST['content']);
            $video_url = sanitize_text_field($_POST['video_url']);
            $tags = sanitize_text_field($_POST['tags']);

            $video_id = Video::add_video($video_url);
            if (Post::add_post($title, $content, $tags, $video_id)) {
                return array('success' => 'Video added.');
            }
        }
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        $data['posts'] = Post::get_posts();
        return XtubeBackend::view('posts.php', $data);
    }
}