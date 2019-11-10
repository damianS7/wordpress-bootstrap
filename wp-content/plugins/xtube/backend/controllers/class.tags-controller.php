<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Tag;

class TagsController {

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['create_tag'])) {
            $tag_name = sanitize_text_field($_POST['name']);
            $tag_description = sanitize_text_field($_POST['description']);
            if (Tag::add_tag($tag_name, $tag_description)) {
                $data['success'] = 'The tag has been created.';
                set_transient('tags_view_data', $data, 60*60);
            } else {
                $data['error'] = 'Something went wrong, tag not created.';
                set_transient('tags_view_data', $data, 60*60);
            }
        }

        if (isset($_POST['delete_tag'])) {
            $tag_id = sanitize_text_field($_POST['tag_id']);
            if (Tag::delete_tag($tag_id)) {
                $data['success'] = 'The tag has been deleted.';
                set_transient('tags_view_data', $data, 60*60);
            } else {
                $data['error'] = 'Something went wrong, tag not deleted.';
                set_transient('tags_view_data', $data, 60*60);
            }
        }

        if (wp_redirect($_SERVER['HTTP_REFERER'])) {
            exit;
        }
    }

    // Metodo para renderizar la vista.
    public function render() {
        $data = get_transient('tags_view_data');
        delete_transient('tags_view_data');
        $data['tags'] = Tag::get_tags();
        return XtubeBackend::view('tags.php', $data);
    }
}