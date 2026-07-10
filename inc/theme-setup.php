<?php
/**
 * Theme setup functionality.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for WordPress features.
	 *
	 * @return void
	 */
	function custom_theme_setup(): void {
		load_theme_textdomain( 'custom-theme', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );

		register_nav_menus(
			array(
				'primary_navigation' => esc_html__( 'Primary Navigation', 'custom-theme' ),
				'footer_navigation'  => esc_html__( 'Footer Navigation', 'custom-theme' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

if ( ! function_exists( 'custom_theme_allow_svg_mime_type' ) ) {
	/**
	 * Allows SVG uploads in the media library.
	 *
	 * @param array<string, string> $mime_types Allowed MIME types.
	 *
	 * @return array<string, string>
	 */
	function custom_theme_allow_svg_mime_type( array $mime_types ): array {
		$mime_types['svg'] = 'image/svg+xml';

		return $mime_types;
	}
}
add_filter( 'upload_mimes', 'custom_theme_allow_svg_mime_type' );