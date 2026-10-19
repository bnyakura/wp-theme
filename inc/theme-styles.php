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



function cilla_skyn_enqueue_icons() {

    // Self-hosted Font Awesome 6.5.2 (assets/fontawesome/) instead of the
    // cdnjs copy: removes a render-blocking cross-origin request, serves the
    // CSS gzipped from our own domain, and keeps the FULL icon set so the
    // admin-chosen ACF icon fields (pillars, cards, value pills, etc.) keep
    // working. The stylesheet itself is made non-render-blocking in
    // cilla_skyn_async_styles() below.
    $fa_rel  = '/assets/fontawesome/css/all.min.css';
    $fa_file = get_template_directory() . $fa_rel;

    if ( file_exists( $fa_file ) ) {
        wp_enqueue_style(
            'font-awesome',
            get_template_directory_uri() . $fa_rel,
            [],
            '6.5.2'
        );
    } else {
        // Fallback to cdnjs if the self-hosted copy is missing (e.g. not deployed).
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
            [],
            '6.5.2'
        );
    }

}

add_action('wp_enqueue_scripts', 'cilla_skyn_enqueue_icons');

if ( ! function_exists( 'cilla_skyn_enqueue_fonts' ) ) {
	/**
	 * Bricolage Grotesque (headings) and Montserrat (body) back the
	 * Cilla Skyn blocks' `font-serif` / `font-sans-cs` Tailwind utilities
	 * (src/input.css @theme).
	 *
	 * @return void
	 */
	function cilla_skyn_enqueue_fonts(): void {
		wp_enqueue_style(
			'cilla-skyn-fonts',
			'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Montserrat:wght@300;400;500;600;700&display=swap',
			[],
			null
		);
	}
}
add_action( 'wp_enqueue_scripts', 'cilla_skyn_enqueue_fonts' );
add_action( 'enqueue_block_editor_assets', 'cilla_skyn_enqueue_fonts' );
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_styles' );

if ( ! function_exists( 'cilla_skyn_dequeue_preorders_sitewide_assets' ) ) {
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
	function cilla_skyn_dequeue_preorders_sitewide_assets(): void {
		wp_dequeue_style( 'woocommerce-pre-orders-main-css' );

		if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			return;
		}

		wp_dequeue_style( 'jquery-ui' );
		wp_dequeue_script( 'preorders-main-js' );
		wp_dequeue_script( 'preorders-field-date-js' );
	}
}
add_action( 'wp_enqueue_scripts', 'cilla_skyn_dequeue_preorders_sitewide_assets', 100 );

if ( ! function_exists( 'cilla_skyn_is_woo_page' ) ) {
	/**
	 * Pages where WooCommerce's own stylesheets are genuinely needed above the
	 * fold: the shop archive, single product, cart, checkout and account pages
	 * (all of which the theme restyles on top of Woo's base layout).
	 *
	 * The front page also renders products (the cilla-skyn-products /
	 * best-sellers blocks via the [products] shortcode), but those sit below
	 * the fold, so there the Woo CSS is kept-but-async'd rather than dequeued.
	 *
	 * @return bool
	 */
	function cilla_skyn_is_woo_page(): bool {
		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		return is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_product() || is_shop();
	}
}

if ( ! function_exists( 'cilla_skyn_dequeue_woocommerce_css' ) ) {
	/**
	 * WooCommerce enqueues woocommerce-general (woocommerce.css, ~90 KiB),
	 * woocommerce-layout and woocommerce-smallscreen on EVERY front-end page.
	 * On pages that render no WooCommerce markup at all (About, Contact, FAQ,
	 * generic content pages) that's ~120 KiB of unused, render-blocking CSS.
	 *
	 * Drop all three there. They are kept on real Woo pages and on the front
	 * page (which embeds product blocks); on the front page they are made
	 * non-render-blocking instead -- see cilla_skyn_async_styles().
	 *
	 * @return void
	 */
	function cilla_skyn_dequeue_woocommerce_css(): void {
		if ( cilla_skyn_is_woo_page() || is_front_page() ) {
			return;
		}

		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
	}
}
add_action( 'wp_enqueue_scripts', 'cilla_skyn_dequeue_woocommerce_css', 100 );

if ( ! function_exists( 'cilla_skyn_async_styles' ) ) {
	/**
	 * Make non-critical stylesheets load without blocking first paint, using
	 * the `media="print"` + `onload` swap (with a <noscript> fallback). These
	 * styles are decorative or below-the-fold, so a few ms of unstyled content
	 * is a far better trade than ~3.7 s of render-blocking network time.
	 *
	 *   - font-awesome   : icons (decorative)
	 *   - cilla-skyn-fonts / iga-fonts : Google Fonts (text uses the swap
	 *                      fallback until they arrive; display=swap is set)
	 *   - sbi-styles / sb_instagram_styles : Instagram feed (footer)
	 *   - woocommerce-*  : on the FRONT PAGE only, where products are below
	 *                      the fold. On real Woo pages these stay blocking
	 *                      because product layout is the primary content.
	 *
	 * @param string $tag    The full <link> tag.
	 * @param string $handle The stylesheet handle.
	 * @param string $href   The stylesheet URL.
	 * @param string $media  The media attribute.
	 * @return string
	 */
	function cilla_skyn_async_styles( $tag, $handle, $href, $media ) {
		$async = array(
			'font-awesome',
			'cilla-skyn-fonts',
			'iga-fonts',
			'sbi-styles',
			'sb_instagram_styles',
		);

		if ( is_front_page() ) {
			$async[] = 'woocommerce-general';
			$async[] = 'woocommerce-layout';
			$async[] = 'woocommerce-smallscreen';
		}

		if ( ! in_array( $handle, $async, true ) ) {
			return $tag;
		}

		return sprintf(
			'<link rel="stylesheet" id="%1$s-css" href="%2$s" media="print" onload="this.media=\'all\';this.onload=null;" />' .
			'<noscript><link rel="stylesheet" href="%2$s" /></noscript>' . "\n",
			esc_attr( $handle ),
			esc_url( $href )
		);
	}
}
add_filter( 'style_loader_tag', 'cilla_skyn_async_styles', 10, 4 );

if ( ! function_exists( 'cilla_skyn_resource_hints' ) ) {
	/**
	 * Warm up the Google Fonts connections early so the now-async font CSS
	 * (fonts.googleapis.com) and the font files themselves (fonts.gstatic.com)
	 * download sooner. gstatic needs crossorigin because fonts are CORS loads.
	 *
	 * @param array  $hints    URLs to hint.
	 * @param string $relation The relation type being requested.
	 * @return array
	 */
	function cilla_skyn_resource_hints( $hints, $relation ) {
		if ( 'preconnect' === $relation ) {
			$hints[] = 'https://fonts.googleapis.com';
			$hints[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}
		return $hints;
	}
}
add_filter( 'wp_resource_hints', 'cilla_skyn_resource_hints', 10, 2 );

if ( ! function_exists( 'custom_theme_enqueue_editor_styles' ) ) {
	/**
	 * Load the frontend styles inside the block editor so ACF block
	 * previews match how they actually look on the live site.
	 *
	 * @return void
	 */
	function custom_theme_enqueue_editor_styles(): void {
		custom_theme_enqueue_styles();
		cilla_skyn_enqueue_icons();

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