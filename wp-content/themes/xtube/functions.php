<?php
function xtb_enqueue_scripts() {
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js');
    wp_enqueue_script('jquery');
    wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
    wp_enqueue_script('prefix_bootstrap');

    wp_register_script('prefix_myjs', esc_url(get_template_directory_uri()) . '/js/events.js');
    wp_enqueue_script('prefix_myjs');

    wp_localize_script('prefix_myjs', 'ajax_var', array(
        'url'    => admin_url('admin-ajax.php'),
        'nonce'  => wp_create_nonce('my-ajax-nonce'),
        'action' => 'video_vote'
    ));
}

function xtb_enqueue_styles() {
    wp_register_style('theme_style_css', esc_url(get_template_directory_uri()) . '/style.css');
    wp_enqueue_style('theme_style_css');

    wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');

    wp_register_style('prefix_fontawesome', esc_url(get_template_directory_uri()) . '/css/all.css');
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


function add_link_atts($atts) {
    $atts['class'] = "nav-link";
    return $atts;
}

// Register and load the widget
function wpb_load_widget() {
    require_once('widget_top10.php');
    $widget = new Widget_TOP10();
    //register_widget(array( $widget, 'widget_top10_videos'));
    //register_widget('Widget_TOP10');
    register_widget($widget);
}

function my_register_sidebars() {
    /* Register the 'cartwidgets' sidebar. */
    register_sidebar(
        array(
        'id' => 'widget_video_right',
        'name' => __('Widget Video Right'),
        'description' => __('It shows the widget when you open a video to view'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    )
    );
}


add_action('widgets_init', 'wpb_load_widget');
add_action('widgets_init', 'my_register_sidebars');
add_filter('nav_menu_link_attributes', 'add_link_atts');
add_action('init', 'register_my_menus');
add_action('wp_enqueue_scripts', 'xtb_enqueue_styles');
add_action('wp_enqueue_scripts', 'xtb_enqueue_scripts');