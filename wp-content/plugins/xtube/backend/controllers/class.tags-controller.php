<?php
namespace Xtube\Backend\Controllers;

use Xtube\Backend\XtubeBackend;
use Xtube\Backend\Models\Tag;

class TagsController {
    public function view_tags() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }
        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        if (isset($_POST['create_tag'])) {
            $tag_name = sanitize_text_field($_POST['name']);
            $tag_description = sanitize_text_field($_POST['description']);
            if (Tag::add_tag($tag_name, $tag_description)) {
                return array('success' => 'The tag has been created.');
            } else {
                return array('error' => 'Something went wrong, tag not created.');
            }
        }

        if (isset($_POST['delete_tag'])) {
            $tag_id = sanitize_text_field($_POST['tag_id']);
            if (Tag::delete_tag($tag_id)) {
                return array('success' => 'The tag has been deleted.');
            } else {
                return array('error' => 'Something went wrong, tag not deleted.');
            }
        }
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        $data['tags'] = Tag::get_tags();
        return XtubeBackend::view('tags.php', $data);
    }
}