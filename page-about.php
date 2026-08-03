<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * Renders the wp-theme/about block. ACF fields override the built-in default
 * content; when empty the original Iron Gorilla /about content is shown.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/about/render.php';

get_footer();
