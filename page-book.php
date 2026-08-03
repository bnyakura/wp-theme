<?php
/**
 * Template Name: Book a Drop-In
 * Template Post Type: page
 *
 * Renders the wp-theme/book block. ACF fields override the built-in default
 * content; when empty the original Iron Gorilla /book content is shown. The
 * booking form is processed by inc/page-forms.php on `template_redirect`.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/book/render.php';

get_footer();
