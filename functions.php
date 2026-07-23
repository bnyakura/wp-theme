<?php
/**
 * custom-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package custom-theme
 */

DEFINED( 'CUSTOM_THEME_VERSION' ) OR define( 'CUSTOM_THEME_VERSION', '1.0.1' );

// Define the path to the acf-requirements file
$theme_setup_file_path = get_template_directory() . '/inc/acf-requirements.php';
if( file_exists( $theme_setup_file_path ) ) {
    require $theme_setup_file_path;
}

// Define the path to the theme-setup file
$theme_setup_file_path = get_template_directory() . '/inc/theme-setup.php';
if( file_exists( $theme_setup_file_path ) ) {
    require $theme_setup_file_path;
}

// Define the path to the theme-styles file
$theme_styles_file_path = get_template_directory() . '/inc/theme-styles.php';
if( file_exists( $theme_styles_file_path ) ) {
    require $theme_styles_file_path;
}

//Define path to js files
$theme_js_file_path = get_template_directory() . '/inc/theme-js.php';
if( file_exists( $theme_js_file_path ) ) {
    require $theme_js_file_path;
}



// Define the path to the acf-blocks file
$acf_blocks_file_path = get_template_directory() . '/inc/acf-blocks.php';
if( file_exists( $acf_blocks_file_path ) ) {
    require $acf_blocks_file_path;
}

// Define the path to the acf-json file
$acf_json_file_path = get_template_directory() . '/inc/acf-json.php';
if( file_exists( $acf_json_file_path ) ) {
    require $acf_json_file_path;
}

// Define the path to the acf-options file
$acf_options_file_path = get_template_directory() . '/inc/acf-options.php';
if( file_exists( $acf_options_file_path ) ) {
    require $acf_options_file_path;
}



