<?php
namespace Xtube\Frontend;

require_once(PLUGIN_DIR . 'frontend/controllers/class.video-controller.php');
require_once(PLUGIN_DIR . 'includes/class.paginator.php');
require_once(PLUGIN_DIR . 'frontend/controllers/class.tag-controller.php');
require_once(PLUGIN_DIR . 'frontend/models/class.tag-model.php');
require_once(PLUGIN_DIR . 'frontend/models/class.video-model.php');
require_once(PLUGIN_DIR . 'frontend/models/class.setting-model.php');

// Front-end
class XtubeFrontend {
    public static function get_query_var($var, $default = 1) {
        global $wp_query;
        return $wp_query->get($var, $default);
    }

    public static function get_view_name() {
        $view = XtubeFrontend::get_query_var('xtb_view');
        switch ($view) {
            case 'tag': return $view;
            case 'videos': return $view;
            case 'video': return $view;
            case 'search': return $view;
            default: return 'videos';
        }
    }

    public static function get_view() {
        return XtubeFrontend::get_query_var('xtb_view', 'videos');
    }

    public static function get_page() {
        return XtubeFrontend::get_query_var('xtb_pagination', '1');
    }

    public static function get_tag() {
        $rawtag = XtubeFrontend::get_query_var('xtb_tag', null);
        return sanitize_text_field(urldecode($rawtag));
    }

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
            $page = XtubeFrontend::get_query_var('xtb_pagination', '1');
        }
        
        return $view_url . '/' . $page;
    }

    public function add_custom_query_var($vars) {
        $vars[] = 'plugin_view';
        $vars[] = 'xtb_tag';
        $vars[] = 'xtb_pagination';
        $vars[] = 'xtb_video';
        $vars[] = 'xtb_view';
        $vars[] = 'xtb_keyword';
        return $vars;
    }

    public function rewrite_rules() {
        add_rewrite_rule(
            '^search/([^/]*)/?',
            'index.php?xtb_keyword=$matches[1]&xtb_view=search',
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

    public function init() {
        add_action('init', array( $this, 'rewrite_rules' ), 9999);
        add_filter('query_vars', array( $this, 'add_custom_query_var'));
        //add_shortcode('myshortcode', array($this, 'view_controller'));
    }
}