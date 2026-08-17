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
		$stylesheet_path = '/assets/css/tailwind.css';        // ← compiled output
		$stylesheet_file = get_template_directory() . $stylesheet_path;
		$stylesheet_uri  = get_template_directory_uri() . $stylesheet_path;

		// Only enqueue if the compiled file exists
		if ( file_exists( $stylesheet_file ) ) {
			wp_enqueue_style(
				'custom-theme-styles',
				$stylesheet_uri,
				array(),
				filemtime( $stylesheet_file )
			);
		} else {
			// Fallback: show admin notice if CSS hasn't been built
			add_action( 'admin_notices', function() {
				echo '<div class="notice notice-error"><p><strong>Theme Error:</strong> Compiled CSS not found. Run <code>npm run build:css</code> to generate <code>assets/css/app.css</code>.</p></div>';
			});
		}
	}
}



function iron_gorilla_enqueue_icons() {

    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        [],
        '6.5.2'
    );

}

add_action('wp_enqueue_scripts', 'iron_gorilla_enqueue_icons');
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_styles' );

if ( ! function_exists( 'iron_gorilla_dequeue_preorders_sitewide_assets' ) ) {
	/**
	 * Pre-Orders for WooCommerce enqueues its main.css / jquery-ui / main.js
	 * on every front-end page (no is_woocommerce() guard in the plugin), and
	 * main.css ships a bare `.hidden { display: none; }` rule that collides
	 * with Tailwind's `hidden` / `md:flex` utility classes used on the header
	 * nav, hiding it (the whole nav computes to display:none regardless of
	 * viewport). The CSS is purely cosmetic for the plugin's date-picker UI,
	 * not required for it to function, so it's always safe to drop -- unlike
	 * jquery-ui/main.js, which real pre-order products still need on pages
	 * where that UI can appear (product, cart, checkout, account).
	 *
	 * @return void
	 */
	function iron_gorilla_dequeue_preorders_sitewide_assets(): void {
		wp_dequeue_style( 'woocommerce-pre-orders-main-css' );

		if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			return;
		}

		wp_dequeue_style( 'jquery-ui' );
		wp_dequeue_script( 'preorders-main-js' );
		wp_dequeue_script( 'preorders-field-date-js' );
	}
}
add_action( 'wp_enqueue_scripts', 'iron_gorilla_dequeue_preorders_sitewide_assets', 100 );

if ( ! function_exists( 'custom_theme_enqueue_editor_styles' ) ) {
	/**
	 * Load the frontend styles inside the block editor so ACF block
	 * previews match how they actually look on the live site.
	 *
	 * @return void
	 */
	function custom_theme_enqueue_editor_styles(): void {
		custom_theme_enqueue_styles();
		iron_gorilla_enqueue_icons();

		wp_enqueue_style(
			'iga-fonts',
			'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap',
			[],
			null
		);

		// Scroll-reveal sections (Mission, Forge, Pricing, Testimonials, etc.)
		// render with opacity:0 until this runs, so it must load in the
		// editor canvas too or the preview stays blank until manually clicked.
		$version = wp_get_theme()->get( 'Version' );
		wp_enqueue_script( 'iga-reveal', get_theme_file_uri( 'assets/js/reveal.js' ), [], $version, true );
	}
}
add_action( 'enqueue_block_editor_assets', 'custom_theme_enqueue_editor_styles' );