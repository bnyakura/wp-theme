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
	}
}
add_action( 'enqueue_block_editor_assets', 'custom_theme_enqueue_editor_styles' );