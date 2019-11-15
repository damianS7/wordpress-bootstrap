<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Xtube
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="<?php echo home_url();?>">
                HOME
                <img class="img-fluid" src="<?php ?>" alt="" />
            </a>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <form action="<?php echo admin_url('admin-post.php'); ?>" class="form-inline my-2 my-lg-0"
                    method="post">
                    <input type="hidden" name="action" value="search_videos_redirect">
                    <input class="form-control mr-sm-2" name="keyword" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
                <?php wp_nav_menu(array('container' => '', 'menu_class' => 'navbar-nav mr-auto', 'theme_location'  => 'header-nav')); ?>
            </div>
        </nav>
    </header>