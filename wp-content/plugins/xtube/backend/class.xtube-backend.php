<?php
namespace Xtube\Backend;

use Xtube\Backend\Controllers\ImportsController;
use Xtube\Backend\Controllers\SettingsController;
use Xtube\Backend\Controllers\TagsController;
use Xtube\Backend\Controllers\VideoController;
use Xtube\Backend\Controllers\CommentsController;

require_once(PLUGIN_DIR . 'backend/controllers/class.setting-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.tag-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.video-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.import-controller.php');
require_once(PLUGIN_DIR . 'backend/controllers/class.reported-comment-controller.php');
require_once(PLUGIN_DIR . 'backend/includes/video-parser/class.xvideos.php');
require_once(PLUGIN_DIR . 'backend/includes/video-parser/class.pornhub.php');
require_once(PLUGIN_DIR . 'backend/includes/class.video.php');
require_once(PLUGIN_DIR . 'backend/models/class.tag-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.setting-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.video-model.php');
require_once(PLUGIN_DIR . 'backend/models/class.reported-comment-model.php');

class XtubeBackend {
    private $settings_controller;
    private $video_controller;
    private $tags_controller;
    private $imports_controller;
    private $reported_comments_controller;

    public function __construct() {
        $this->tags_controller = new TagsController();
        $this->video_controller = new VideoController();
        $this->settings_controller = new SettingsController();
        $this->imports_controller = new ImportsController();
        $this->reported_comments_controller = new CommentsController();
    }
    
    public function plugin_menu() {
        add_menu_page('Xtube Settings', 'Xtube', 'manage_options', 'xtube-menu', array($this->settings_controller, 'render'));
        add_submenu_page('xtube-menu', 'Xtube settings', 'Settings', 'manage_options', 'xtube-settings', array($this->settings_controller, 'render'));
        add_submenu_page('xtube-menu', 'Manage posts', 'Add video', 'manage_options', 'xtube-posts', array($this->video_controller, 'render'));
        add_submenu_page('xtube-menu', 'Manage tags', 'Manage tags', 'manage_options', 'xtube-tags', array($this->tags_controller, 'render'));
        add_submenu_page('xtube-menu', 'Xtube import', 'Import videos', 'manage_options', 'xtube-import', array($this->imports_controller, 'render'));
        add_submenu_page('xtube-menu', 'Reported comments', 'Reported comments', 'manage_options', 'xtube-comments', array($this->reported_comments_controller, 'render'));
        add_submenu_page('xtube-menu', 'Reported videos', 'Reported videos', 'manage_options', 'xtube-reports', array($this->settings_controller, 'render'));
    }

    public static function view($view, $data) {
        include_once(PLUGIN_DIR . 'backend/includes/template.php');
    }

    public function add_custom_query_var($vars) {
        $vars[] = 'xtb_pagination';
        $vars[] = 'xtb_keyword';
        $vars[] = 'xtb_import_server';
        $vars[] = 'xtb_server';
        $vars[] = 'page';
        return $vars;
    }

    // Forma segura de obtener valores de $_GET
    public static function get_query_var($var, $default = '') {
        if (isset($_GET[$var])) {
            if (!empty($_GET[$var])) {
                return $_GET[$var];
            }
        }

        return $default;
    }

    public function xtube_queue() {
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js');
        wp_enqueue_script('jquery');
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
        
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
    }

    public function init() {
        add_filter('query_vars', array( $this, 'add_custom_query_var'));
        add_action('admin_enqueue_scripts', array($this, 'xtube_queue'), 1000);
        add_action('admin_menu', array( $this, 'plugin_menu' ));

        add_action('admin_post_reported_comments', array($this->reported_comments_controller, 'handle_forms'));
        add_action('admin_post_imports_controller', array($this->imports_controller, 'handle_forms'));
        add_action('admin_post_tags_controller', array($this->tags_controller, 'handle_forms'));
        add_action('admin_post_video_controller', array($this->video_controller, 'handle_forms'));
        add_action('admin_post_settings_controller', array($this->settings_controller, 'handle_forms'));
    }
}