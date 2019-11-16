<?php
namespace Xtube\Backend;

use Xtube\Backend\Controllers\VideoImportController;
use Xtube\Backend\Controllers\ReportedVideosController;
use Xtube\Backend\Controllers\SettingsController;
use Xtube\Backend\Controllers\TagsController;
use Xtube\Backend\Controllers\VideoController;

require_once(PLUGIN_DIR . 'backend/controllers/settings-controller.class.php');
require_once(PLUGIN_DIR . 'backend/controllers/tags-controller.class.php');
require_once(PLUGIN_DIR . 'backend/controllers/video-controller.class.php');
require_once(PLUGIN_DIR . 'backend/controllers/import-videos-controller.class.php');
require_once(PLUGIN_DIR . 'backend/controllers/reported-videos-controller.class.php');
require_once(PLUGIN_DIR . 'backend/controllers/cron-controller.class.php');
require_once(PLUGIN_DIR . 'backend/includes/video-parser/xvideos.class.php');
require_once(PLUGIN_DIR . 'backend/includes/video-parser/pornhub.class.php');
require_once(PLUGIN_DIR . 'backend/includes/video-parser/youtube.class.php');
require_once(PLUGIN_DIR . 'backend/includes/video.class.php');
require_once(PLUGIN_DIR . 'backend/models/tag-model.class.php');
require_once(PLUGIN_DIR . 'backend/models/setting-model.class.php');
require_once(PLUGIN_DIR . 'backend/models/video-model.class.php');
require_once(PLUGIN_DIR . 'backend/models/reported-video-model.class.php');

class XtubeBackend {
    private $settings_controller;
    private $video_controller;
    private $tags_controller;
    private $imports_controller;
    private $reported_videos_controller;

    public function __construct() {
        $this->tags_controller = new TagsController();
        $this->video_controller = new VideoController();
        $this->settings_controller = new SettingsController();
        $this->imports_controller = new VideoImportController();
        $this->reported_videos_controller = new ReportedVideosController();
    }
    
    // Opciones del menu del plugin
    public function plugin_menu() {
        add_menu_page('Xtube Settings', 'Xtube', 'manage_options', 'xtube-menu', array($this->settings_controller, 'render'));
        add_submenu_page('xtube-menu', 'Xtube settings', 'Settings', 'manage_options', 'xtube-settings', array($this->settings_controller, 'render'));
        add_submenu_page('xtube-menu', 'Manage posts', 'Add video', 'manage_options', 'xtube-posts', array($this->video_controller, 'render'));
        add_submenu_page('xtube-menu', 'Manage tags', 'Manage tags', 'manage_options', 'xtube-tags', array($this->tags_controller, 'render'));
        add_submenu_page('xtube-menu', 'Xtube import', 'Import videos', 'manage_options', 'xtube-import', array($this->imports_controller, 'render'));
        add_submenu_page('xtube-menu', 'Reported videos', 'Reported videos', 'manage_options', 'xtube-repored-videos', array($this->reported_videos_controller, 'render'));
        add_submenu_page('xtube-menu', 'Cron Video Import', 'Cron Import', 'manage_options', 'xtube-cron', array($this->settings_controller, 'render'));
    }

    // Muestra una vista
    public static function view($view, $data) {
        include_once(PLUGIN_DIR . 'backend/views/template.php');
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

    // Scripts y estilos del backend
    public function xtube_queue() {
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js');
        wp_enqueue_script('jquery');
        
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
        
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
    }

    // Hooks del backend
    public function init() {
        add_filter('query_vars', array( $this, 'add_custom_query_var'));
        add_action('admin_enqueue_scripts', array($this, 'xtube_queue'), 1000);
        add_action('admin_menu', array( $this, 'plugin_menu' ));

        add_action('admin_post_imports_controller', array($this->imports_controller, 'handle_forms'));
        add_action('admin_post_tags_controller', array($this->tags_controller, 'handle_forms'));
        add_action('admin_post_video_controller', array($this->video_controller, 'handle_forms'));
        add_action('admin_post_settings_controller', array($this->settings_controller, 'handle_forms'));
        add_action('admin_post_reported_videos_controller', array($this->reported_videos_controller, 'handle_forms'));
    }
}