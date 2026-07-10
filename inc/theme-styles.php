<?php
/**
 * Theme styles.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_enqueue_styles' ) ) {
	/**
	 * Enqueue theme styles.
	 *
	 * @return void
	 */
	function custom_theme_enqueue_styles(): void {
		$stylesheet_path = '/dist/css/app.css';
		$stylesheet_file = get_template_directory() . $stylesheet_path;
		$stylesheet_uri  = get_template_directory_uri() . $stylesheet_path;

		wp_enqueue_style(
			'custom-theme-styles',
			$stylesheet_uri,
			array(),
			file_exists( $stylesheet_file ) ? filemtime( $stylesheet_file ) : wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_styles' );