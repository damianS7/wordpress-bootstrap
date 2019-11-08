<?php
namespace Xtube\Backend;

use Xtube\Backend\Controllers\ImportsController;
use Xtube\Backend\Controllers\SettingsController;
use Xtube\Backend\Controllers\TagsController;
use Xtube\Backend\Controllers\PostsController;

require_once(PLUGIN_DIR . 'backend/controllers/class.settings-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.tags-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.posts-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.imports-controller.php');
require_once(PLUGIN_DIR . 'backend/includes/importers/class.xvideos.php');
require_once(PLUGIN_DIR . 'backend/includes/importers/class.video.php');
require_once(PLUGIN_DIR . 'backend/models/class.tags-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.settings-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.posts-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.videos-model.php');

class XtubeBackend {
    private $settings_controller;
    private $posts_controller;
    private $tags_controller;
    private $imports_controller;

    public function __construct() {
        $this->tags_controller = new TagsController();
        $this->posts_controller = new PostsController();
        $this->settings_controller = new SettingsController();
        $this->imports_controller = new ImportsController();
    }
    
    public function plugin_menu() {
        add_menu_page('Xtube Settings', 'Xtube', 'manage_options', 'xtube-menu', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Xtube settings', 'Settings', 'manage_options', 'xtube-settings', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Xtube import', 'Import', 'manage_options', 'xtube-import', array($this->imports_controller, 'view_imports'));
        add_submenu_page('xtube-menu', 'Manage Posts', 'Posts', 'manage_options', 'xtube-posts', array($this->posts_controller, 'view_posts'));
        add_submenu_page('xtube-menu', 'Moderation comments', 'Moderation comments', 'manage_options', 'xtube-reports', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Reported posts', 'Reported posts', 'manage_options', 'xtube-reports', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Tags', 'Tags', 'manage_options', 'xtube-tags', array($this->tags_controller, 'view_tags'));
    }

    public static function view($view, $data) {
        include_once(PLUGIN_DIR . 'backend/includes/template.php');
    }

    public function init() {
        add_action('admin_menu', array( $this, 'plugin_menu' ));
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
    }
}