<?php
/**
 * ACF local JSON configuration.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_acf_json_save_point' ) ) {
	/**
	 * Set the ACF JSON save path.
	 *
	 * @param string $path Existing save path.
	 *
	 * @return string
	 */
	function custom_theme_acf_json_save_point( string $path ): string {
		return get_template_directory() . '/acf-json';
	}
}
add_filter( 'acf/settings/save_json', 'custom_theme_acf_json_save_point' );

if ( ! function_exists( 'custom_theme_acf_json_load_point' ) ) {
	/**
	 * Set the ACF JSON load paths.
	 *
	 * @param array<int, string> $paths Existing load paths.
	 *
	 * @return array<int, string>
	 */
	function custom_theme_acf_json_load_point( array $paths ): array {
		$paths[] = get_template_directory() . '/acf-json';

		return $paths;
	}
}
add_filter( 'acf/settings/load_json', 'custom_theme_acf_json_load_point' );