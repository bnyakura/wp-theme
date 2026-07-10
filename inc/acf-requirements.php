<?php
/**
 * ACF requirements.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_acf_admin_notice' ) ) {
	/**
	 * Display admin notice when ACF Pro is missing.
	 *
	 * @return void
	 */
	function custom_theme_acf_admin_notice(): void {
		?>
		<div class="notice notice-error">
			<p>
				<strong><?php esc_html_e( 'custom-theme:', 'custom-theme' ); ?></strong>
				<?php esc_html_e( 'Advanced Custom Fields Pro is required for this theme to function correctly.', 'custom-theme' ); ?>
			</p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'custom_theme_require_acf' ) ) {
	/**
	 * Validate ACF dependency.
	 *
	 * @return void
	 */
	function custom_theme_require_acf(): void {
		$acf_available = function_exists( 'acf' )
			&& function_exists( 'acf_add_options_page' );

		if ( $acf_available ) {
			return;
		}

		// Allow wp-admin access.
		if ( is_admin() ) {
			add_action( 'admin_notices', 'custom_theme_acf_admin_notice' );

			return;
		}

		// Block frontend rendering.
		wp_die(
			wp_kses_post(
				__(
					'<h1>Advanced Custom Fields Pro Required</h1><p>The custom-theme theme requires Advanced Custom Fields Pro to be installed and activated.</p>',
					'custom-theme'
				)
			),
			esc_html__( 'Missing Required Plugin', 'custom-theme' ),
			array(
				'response' => 500,
			)
		);
	}
}
add_action( 'after_setup_theme', 'custom_theme_require_acf', 1 );