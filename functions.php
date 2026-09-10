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

// Define the path to the page block form handlers (booking + contact)
$page_forms_file_path = get_template_directory() . '/inc/page-forms.php';
if( file_exists( $page_forms_file_path ) ) {
    require $page_forms_file_path;
}

// Define the path to the Cilla Skyn Contact Form block's handler
$cilla_skyn_contact_form_file_path = get_template_directory() . '/inc/cilla-skyn-contact-form.php';
if( file_exists( $cilla_skyn_contact_form_file_path ) ) {
    require $cilla_skyn_contact_form_file_path;
}

// Define the path to the ACF block field defaults file (pre-fills the block
// editor forms with the theme's shipped content instead of blank fields)
$acf_block_defaults_file_path = get_template_directory() . '/inc/acf-block-defaults.php';
if( file_exists( $acf_block_defaults_file_path ) ) {
    require $acf_block_defaults_file_path;
}

// Define the path to the single product page file (related products
// renderer + compatibility fixes used by single-product.php)
$single_product_file_path = get_template_directory() . '/inc/single-product.php';
if( file_exists( $single_product_file_path ) ) {
    require $single_product_file_path;
}
















