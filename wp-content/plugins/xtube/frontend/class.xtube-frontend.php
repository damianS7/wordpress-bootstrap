<?php
namespace Xtube\Frontend;

require_once(PLUGIN_DIR . 'frontend/controllers/class.tag-controller.php');
require_once(PLUGIN_DIR . 'frontend/models/class.tag-model.php');
require_once(PLUGIN_DIR . 'frontend/models/class.video-model.php');

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
            case 'video': return $view;
            case 'search': return $view;
            default: return 'home';
        }
    }

    public static function get_tag() {
        return XtubeFrontend::get_query_var('xtb_tag', null);
    }

    public static function get_keyword() {
        return XtubeFrontend::get_query_var('xtb_keyword', null);
    }

    public function add_custom_query_var($vars) {
        $vars[] = 'plugin_view';
        $vars[] = 'xtb_tag';
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
            '^tag/([^/]*)/?',
            'index.php?xtb_tag=$matches[1]&xtb_view=tag',
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