<?php
function xtb_enqueue_scripts() {
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js');
    wp_enqueue_script('jquery');
    wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
    wp_enqueue_script('prefix_bootstrap');
}

function xtb_enqueue_styles() {
    wp_register_style('theme_style_css', esc_url(get_template_directory_uri()) . '/style.css');
    wp_enqueue_style('theme_style_css');

    wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');
    
    wp_register_style('prefix_fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('prefix_fontawesome');
}

// Registro de posiciones del menu
function register_my_menus() {
    register_nav_menus(
        array(
            'header-nav' => __('Header Navigation'),
            'header-nav-drop' => __('Header Navigation Dropwdown'),
            'footer-nav-1' => __('Footer Navigation 1'),
            'footer-nav-2' => __('Footer Navigation 2'),
            'footer-nav-social' => __('Social Navigation footer')
            )
    );
}

add_action('init', 'register_my_menus');
add_action('wp_enqueue_scripts', 'xtb_enqueue_styles');
add_action('wp_enqueue_scripts', 'xtb_enqueue_scripts');