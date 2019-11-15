<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Xtube
 * @since 1.0.0
 */

?>

<footer class="bg-dark text-white mt-4 navbar">
    <div class="container-fluid">
        <div class="col-sm-12 text-center">
            <div class="row">
                <div class="col-sm-4">
                    <?php wp_nav_menu(array('container' => '', 'menu_class' => 'navbar-nav mr-auto', 'theme_location'  => 'footer-nav-1')); ?>
                </div>
                <div class="col-sm-4">
                    <?php wp_nav_menu(array('container' => '', 'menu_class' => 'navbar-nav mr-auto', 'theme_location'  => 'footer-nav-2')); ?>
                </div>
                <div class="col-sm-4">
                    <?php wp_nav_menu(array('container' => '', 'menu_class' => 'navbar-nav mr-auto', 'theme_location'  => 'footer-nav-social')); ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <p>Copyright</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<a class="button-go-up" href="<?php echo $_SERVER["REQUEST_URI"] ?>#">
    <i class="fa fa-chevron-up"></i>
</a>
<?php wp_footer(); ?>
</body>

</html>