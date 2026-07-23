<?php
/**
 * Theme JavaScript.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_enqueue_js' ) ) {
	/**
	 * Enqueue theme JavaScript.
	 *
	 * @return void
	 */
	function custom_theme_enqueue_js(): void {
		$version = wp_get_theme()->get( 'Version' );
		$script_path = '/assets/js/header.js';
		$script_file = get_template_directory() . $script_path;
		$script_uri  = get_template_directory_uri() . $script_path;

		// Only enqueue if the compiled file exists.
		if ( file_exists( $script_file ) ) {
			wp_enqueue_script(
				'custom-theme-header',
				$script_uri,
				array(),                  // Dependencies (e.g. array('jquery'))
				filemtime( $script_file ),// Version for cache busting
				true                      // Load in footer
			);
		} else {
			add_action(
				'admin_notices',
				function () {
					echo '<div class="notice notice-error"><p><strong>Theme Error:</strong> <code>assets/js/header.js</code> was not found.</p></div>';
				}
			);
		};








		// Bebas Neue + DM Sans.
	wp_enqueue_style(
		'iga-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap',
		[],
		null
	);

	// Modal controller — replaces the old React ModalContext.
	wp_enqueue_script( 'iga-modal', get_theme_file_uri( 'assets/js/modal.js' ), [], $version, true );
	// Hero slider — autoplay, hover-pause, swipe, arrows, dots, progress.
	wp_enqueue_script( 'iga-hero-slider', get_theme_file_uri( 'assets/js/hero-slider.js' ), [], $version, true );
	// Scroll-reveal — .reveal/.active replacement.
	wp_enqueue_script( 'iga-reveal', get_theme_file_uri( 'assets/js/reveal.js' ), [], $version, true );
	// Pricing tab toggle.
	wp_enqueue_script( 'iga-pricing-tabs', get_theme_file_uri( 'assets/js/pricing-tabs.js' ), [], $version, true );







		
	}
}

add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_js' );