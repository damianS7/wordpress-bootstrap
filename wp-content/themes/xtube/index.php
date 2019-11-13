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
<?php if (Xtube\Frontend\XtubeFrontend::get_view_name() == 'tag'): ?>
<?php include_once('tag.php'); ?>
<?php elseif (Xtube\Frontend\XtubeFrontend::get_view_name() == 'search'): ?>
<?php include_once('search.php'); ?>
<?php elseif (Xtube\Frontend\XtubeFrontend::get_view_name() == 'video'): ?>
<?php include_once('video.php'); ?>
<?php else: ?>
<?php include_once('videos.php'); ?>
<?php endif; ?>

<?php get_footer(); ?>