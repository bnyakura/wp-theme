<?php
/**
 * ACF options pages.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_register_acf_options_pages' ) ) {
	/**
	 * Register ACF options pages.
	 *
	 * @return void
	 */
	function custom_theme_register_acf_options_pages(): void {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title' => __( 'Theme Options', 'custom-theme' ),
				'menu_title' => __( 'Theme Options', 'custom-theme' ),
				'menu_slug'  => 'theme-options',
				'capability' => 'edit_posts',
				'redirect'   => true,
				'position'   => 59,
				'icon_url'   => 'dashicons-admin-customizer',
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => __( 'General', 'custom-theme' ),
				'menu_title'  => __( 'General', 'custom-theme' ),
				'menu_slug'   => 'theme-options-general',
				'parent_slug' => 'theme-options',
				'capability'  => 'edit_posts',
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => __( 'Header', 'custom-theme' ),
				'menu_title'  => __( 'Header', 'custom-theme' ),
				'menu_slug'   => 'theme-options-header',
				'parent_slug' => 'theme-options',
				'capability'  => 'edit_posts',
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => __( 'Footer', 'custom-theme' ),
				'menu_title'  => __( 'Footer', 'custom-theme' ),
				'menu_slug'   => 'theme-options-footer',
				'parent_slug' => 'theme-options',
				'capability'  => 'edit_posts',
			)
		);
	}
}
add_action( 'acf/init', 'custom_theme_register_acf_options_pages' );	