<?php
/**
 * Template Name: Armory
 * Template Post Type: page
 *
 * Renders the wp-theme/armory block. ACF fields override the built-in default
 * content; when empty the original Iron Gorilla /armory content is shown.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

get_header();

require get_template_directory() . '/blocks/armory/render.php';

get_footer();
