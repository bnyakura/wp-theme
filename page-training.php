<?php
/**
 * Template Name: Training
 * Template Post Type: page
 *
 * Renders the wp-theme/training block. ACF fields override the built-in
 * default content; when empty the original Iron Gorilla /training content
 * is shown.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/training/render.php';

get_footer();
