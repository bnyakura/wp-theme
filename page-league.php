<?php
/**
 * Template Name: League of Legends
 * Template Post Type: page
 *
 * Renders the wp-theme/league block. ACF fields override the built-in default
 * content; when empty the original Iron Gorilla /league content is shown.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/league/render.php';

get_footer();
