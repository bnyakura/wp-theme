<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Renders the wp-theme/contact block. ACF fields override the built-in default
 * content; when empty the original Iron Gorilla /contact content is shown. The
 * dispatch form is processed by inc/page-forms.php on `template_redirect`.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/contact/render.php';

get_footer();
