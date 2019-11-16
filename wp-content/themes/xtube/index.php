<?php
/**
 * @package WordPress
 * @subpackage Xtube
 * @since 1.0
 * @version 1.0
 */
?>
<?php get_header(); ?>

<?php include_once('tag-cloud.php'); ?>
<hr>
<?php if (Xtube\Frontend\XtubeFrontend::get_view() == 'tag'): ?>
<?php Xtube\Frontend\Controllers\TagVideosController::render(); ?>
<?php elseif (Xtube\Frontend\XtubeFrontend::get_view() == 'search'): ?>
<?php Xtube\Frontend\Controllers\SearchVideosController::render(); ?>
<?php elseif (Xtube\Frontend\XtubeFrontend::get_view() == 'video'): ?>
<?php Xtube\Frontend\Controllers\ViewVideoController::render(); ?>
<?php else: // Vista por defecto?>
<?php Xtube\Frontend\Controllers\HomeVideosController::render(); ?>
<?php endif; ?>

<?php get_footer(); ?>