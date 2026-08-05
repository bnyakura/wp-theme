<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * Renders the wp-theme/faq block. ACF fields override the built-in default
 * content; when empty the original Iron Gorilla /faq content is shown.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/faq/render.php';

get_footer();
