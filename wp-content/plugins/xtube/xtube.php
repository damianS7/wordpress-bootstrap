<?php
/**
 * Plugin Name: Xtube
 * Plugin URI:
 * Description: Xtube implementation for Wordpress
 * Version: 0.1
 * Author: damianS7
 * Author URI:
 * Text Domain: xtube
 */

// Impedimos el acceso si se intenta acceder directamente al plugin
if (!function_exists('add_action')) {
    exit;
}

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

// BACKEND (WP-ADMIN)
if (is_admin()) {
    require_once(PLUGIN_DIR . 'backend/xtube-backend.class.php');
    require_once(PLUGIN_DIR . 'install.php');
    $install = new XtubeInstall();
    register_activation_hook(__FILE__, array( $install, 'plugin_activation' ));
    register_deactivation_hook(__FILE__, array( $install, 'plugin_deactivation' ));

    $backend = new Xtube\Backend\XtubeBackend();
    add_action('init', array($backend, 'init'));
}

// FRONTEND
require_once(PLUGIN_DIR . 'frontend/class.xtube-frontend.php');
$frontend = new Xtube\Frontend\XtubeFrontend();
add_action('init', array( $frontend, 'init' ));