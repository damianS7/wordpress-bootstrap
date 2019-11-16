<?php
namespace Xtube\Frontend;

use Xtube\Frontend\Models\Video;
use Xtube\Frontend\Controllers\VideoController;
use Xtube\Frontend\Controllers\VideoReportController;

require_once(PLUGIN_DIR . 'frontend/controllers/home-videos-controller.class.php');
require_once(PLUGIN_DIR . 'frontend/controllers/view-video-controller.class.php');
require_once(PLUGIN_DIR . 'frontend/controllers/search-videos-controller.class.php');
require_once(PLUGIN_DIR . 'frontend/controllers/report-video-controller.class.php');
require_once(PLUGIN_DIR . 'frontend/controllers/vote-video-controller.class.php');
require_once(PLUGIN_DIR . 'frontend/controllers/tag-videos-controller.class.php');
require_once(PLUGIN_DIR . 'includes/paginator.class.php');
require_once(PLUGIN_DIR . 'frontend/models/tag-model.class.php');
require_once(PLUGIN_DIR . 'frontend/models/video-model.class.php');
require_once(PLUGIN_DIR . 'frontend/models/video-report-model.class.php');
require_once(PLUGIN_DIR . 'frontend/models/setting-model.class.php');
// Front-end
class XtubeFrontend {

    // Muestra una vista
    public static function view($view, $data) {
        include_once(PLUGIN_DIR . 'frontend/views/' . $view . '.php');
    }
    
    // Obtiene el valor de una variable GET
    public static function get_query_var($var, $default = 1) {
        global $wp_query;
        return $wp_query->get($var, $default);
    }

    public static function get_ip() {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function get_video_id() {
        return XtubeFrontend::get_query_var('xtb_video', null);
    }

    // Devuelve el nombre de la vista actual, por defecto siempre mostrar el home(videos)
    public static function get_view() {
        return XtubeFrontend::get_query_var('xtb_view', 'videos');
    }

    // Devuelve la paginacion actual, 1 por defecto
    public static function get_page() {
        return XtubeFrontend::get_query_var('xtb_pagination', '1');
    }

    // Devuelve el tag de la pagina o null
    public static function get_tag() {
        $rawtag = XtubeFrontend::get_query_var('xtb_tag', null);
        return sanitize_text_field(urldecode($rawtag));
    }

    // Devuelve la palabra que se esta usando en la busqueda
    public static function get_keyword() {
        return XtubeFrontend::get_query_var('xtb_keyword', null);
    }

    // Metodo que devuelve la url completa de una vista incluyendo el id
    public static function view_url($view, $id = '') {
        // Si no se especifica la vista, se lee desde la url
        if (empty($view)) {
            $view = XtubeFrontend::get_view('xtb_view');
        }

        if (empty($id) && XtubeFrontend::get_view() == 'tag') {
            $id = XtubeFrontend::get_tag();
        }

        if (empty($id) && XtubeFrontend::get_view() == 'search') {
            $id = XtubeFrontend::get_keyword();
        }

        if (!empty($id)) {
            $id = '/' . $id;
        }
        
        // Construccion de la url
        return home_url() . '/' . $view . $id;
    }

    // Metodo que genera una URL apta para el paginador
    public static function pagination_url($view, $id, $page) {
        $view_url = XtubeFrontend::view_url($view, $id);
    
        // Si no se indica una pagina, la pagina por defecto sera la de la url
        if (empty($page)) {
            $page = XtubeFrontend::get_page();
        }
        
        return $view_url . '/' . $page;
    }

    // Variables permitidas en el plugin
    public function add_custom_query_var($vars) {
        $vars[] = 'plugin_view';
        $vars[] = 'xtb_tag';
        $vars[] = 'xtb_pagination';
        $vars[] = 'xtb_video';
        $vars[] = 'xtb_view';
        $vars[] = 'xtb_keyword';
        $vars[] = 'xtb_id';
        return $vars;
    }

    // Reglas para la URL
    public function rewrite_rules() {
        add_rewrite_rule(
            '^search/([^/]*)/([^/]*)/?',
            'index.php?xtb_view=search&xtb_keyword=$matches[1]&xtb_pagination=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            '^search/([^/]*)/?',
            'index.php?xtb_view=search&xtb_keyword=$matches[1]&xtb_pagination=1',
            'top'
        );

        add_rewrite_rule(
            '^tag/([^/]*)/([^/]*)/?',
            'index.php?xtb_view=tag&xtb_tag=$matches[1]&xtb_pagination=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            '^tag/([^/]*)/?',
            'index.php?xtb_view=tag&xtb_tag=$matches[1]&xtb_pagination=1',
            'top'
        );

        add_rewrite_rule(
            '^videos/([^/]*)/?',
            'index.php?xtb_pagination=$matches[1]&xtb_view=videos',
            'top'
        );

        add_rewrite_rule(
            '^video/([^/]*)/?',
            'index.php?xtb_video=$matches[1]&xtb_view=video',
            'top'
        );
        
        flush_rewrite_rules();
    }


    // --------------- sin debug

    public function search_redirect() {
        if (wp_redirect(XtubeFrontend::pagination_url('search', $_POST['keyword'], 1))) {
            exit;
        }
    }

    public function init() {
        add_action('init', array( $this, 'rewrite_rules' ), 9999);
        add_filter('query_vars', array( $this, 'add_custom_query_var'));
        add_action('wp_ajax_video_vote', 'Xtube\Frontend\Controllers\VoteVideoController::vote');
        add_action('wp_ajax_nopriv_video_vote', 'Xtube\Frontend\Controllers\VoteVideoController::vote');
        
        add_action('wp_ajax_video_report', 'Xtube\Frontend\Controllers\ReportVideoController::report');
        add_action('wp_ajax_nopriv_video_report', 'Xtube\Frontend\Controllers\ReportVideoController::report');
        add_action('admin_post_search_videos_redirect', array($this, 'search_redirect'));
     
        // Actualizar contador de vistas
        add_action('wp', 'Xtube\Frontend\Controllers\ViewVideoController::video_views_check');
    }
}