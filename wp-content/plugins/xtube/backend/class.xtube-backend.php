<?php
namespace Xtube\Backend;

use Xtube\Backend\Controllers\SettingsController;
use Xtube\Backend\Controllers\TagsController;

require_once(PLUGIN_DIR . 'backend/controllers/class.settings-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.tags-controller.php');

require_once(PLUGIN_DIR . 'backend/models/class.tags-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.settings-model.php');

class XtubeBackend {
    private $settings_controller;
    private $tags_controller;

    public function __construct() {
        $this->settings_controller = new SettingsController();
        $this->tags_controller = new TagsController();
    }

    public function plugin_menu() {
        add_menu_page('Xtube Settings', 'Xtube', 'manage_options', 'xtube-menu', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Xtube settings', 'Settings', 'manage_options', 'xtube-settings', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Xtube import', 'Import', 'manage_options', 'xtube-import', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Add post', 'Add post', 'manage_options', 'xtube-posts-add', array($this->settings_controller, 'view_settings'));
        add_submenu_page('xtube-menu', 'Manage Posts', 'Manage Posts', 'manage_options', 'xtube-posts-list', array($this->settings_controller, 'view_settings'));
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