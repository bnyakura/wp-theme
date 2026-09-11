<?php
/**
 * Theme setup functionality.
 *
 * @package custom-theme
 */
require get_theme_file_path( 'inc/hero-slides.php' );
require get_theme_file_path( 'inc/distinction-cards.php' );
require get_theme_file_path( 'inc/mission.php' );
require get_theme_file_path( 'inc/forge-pillars.php' );
require get_theme_file_path( 'inc/pricing-tiers.php' );
require get_theme_file_path( 'inc/testimonials.php' );
require get_theme_file_path( 'inc/contact-section.php' );

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

/**
 * Skip WooCommerce's auto-appended shop grid when the Shop page's content
 * already contains the Best Sellers block.
 *
 * This theme has no add_theme_support('woocommerce') (see index.php), so on
 * the Shop page WooCommerce falls back to appending its own product grid to
 * the_content() via WC_Template_Loader::unsupported_theme_shop_content_filter().
 * That runs unconditionally, so without this, products rendered by the block
 * show up a second time via that auto-appended grid right below them.
 */
function iga_prevent_duplicate_shop_products() {
	if ( ! function_exists( 'wc_get_page_id' ) || ! class_exists( 'WC_Template_Loader' ) ) {
		return;
	}

	$shop_page_id = wc_get_page_id( 'shop' );

	if ( $shop_page_id && has_block( 'wp-theme/cilla-skyn-best-sellers', $shop_page_id ) ) {
		remove_filter( 'the_content', array( 'WC_Template_Loader', 'unsupported_theme_shop_content_filter' ), 10 );
	}
}
add_action( 'template_redirect', 'iga_prevent_duplicate_shop_products', 20 );





// Add scrolled class via body class (optional enhancement)
function cilla_skyn_header_classes($classes) {
    if (is_admin_bar_showing()) {
        $classes[] = 'admin-bar';
    }
    return $classes;
}
add_filter('body_class', 'cilla_skyn_header_classes');


function cilla_skyn_customizer($wp_customize) {
    $wp_customize->add_setting('cilla_skyn_tagline', [
        'default'           => __( 'Skin for a Brighter Tomorrow', 'cilla-skyn' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('cilla_skyn_tagline', [
        'label'       => __('Site Tagline (Header & Footer)', 'cilla-skyn'),
        'description' => __('Short uppercase line shown in the header announcement bar and twice in the footer. Not the same as "Footer Tagline" below, which is the longer footer description paragraph.', 'cilla-skyn'),
        'section'     => 'title_tagline',
        'type'        => 'text',
    ]);

    $wp_customize->add_setting('cilla_skyn_whatsapp', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('cilla_skyn_whatsapp', [
        'label'   => __('WhatsApp Number', 'cilla-skyn'),
        'section' => 'title_tagline',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('cilla_skyn_whatsapp_group', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('cilla_skyn_whatsapp_group', [
        'label'       => __('WhatsApp Group Invite Link', 'cilla-skyn'),
        'description' => __('Used by "Join Community" buttons site-wide, e.g. https://chat.whatsapp.com/xxxxxxxx', 'cilla-skyn'),
        'section'     => 'title_tagline',
        'type'        => 'url',
    ]);

    $wp_customize->add_setting('cilla_skyn_assessment_sheet_webhook', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('cilla_skyn_assessment_sheet_webhook', [
        'label'       => __('Book Assessment — Google Sheet Webhook URL', 'cilla-skyn'),
        'description' => __('The deployed Google Apps Script Web App URL that appends Book Assessment form submissions to a Google Sheet.', 'cilla-skyn'),
        'section'     => 'title_tagline',
        'type'        => 'url',
    ]);
}
add_action('customize_register', 'cilla_skyn_customizer');

/**
 * The Google Apps Script Web App URL that Book Assessment submissions are
 * posted to so they land in a Google Sheet.
 */
function iga_get_assessment_sheet_webhook_url() {
    return get_theme_mod( 'cilla_skyn_assessment_sheet_webhook', '' );
}

/**
 * The WhatsApp group invite link used by "Join Community" buttons site-wide.
 */
function iga_get_whatsapp_group_url() {
    return get_theme_mod('cilla_skyn_whatsapp_group', '');
}

/**
 * A wa.me chat link to the configured WhatsApp number, used by "Book Free
 * Assessment" / "Book Assessment" buttons site-wide and the floating
 * WhatsApp chat button (footer.php).
 *
 * The fallback number here is Cilla Skyn's real WhatsApp number from
 * NewProject/Cilla Skyn Website Layout.docx's "Contact Information"
 * section (also the Contact Info block's default) -- this used to be a
 * leftover number from the theme's original gym-brand build
 * ('27790614906'), which would have silently sent real customer messages
 * to the wrong WhatsApp account once this URL became visible/clickable
 * on the front end. Set the real number under Customize -> Site Identity
 * -> WhatsApp Number to override this fallback.
 */
function iga_get_whatsapp_number_url( $message = '' ) {
    $number = get_theme_mod( 'cilla_skyn_whatsapp', '' ) ?: '27649111932';
    $url    = 'https://wa.me/' . $number;

    if ( $message ) {
        $url .= '?text=' . rawurlencode( $message );
    }

    return $url;
}








if ( ! function_exists( 'cilla_skyn_footer_social_icon' ) ) {
	/**
	 * Inline SVG for one footer social icon.
	 *
	 * Used by footer.php to render the Brand column's icon row from the
	 * "Social Links" repeater on Theme Options → Footer (§16/§17 in the
	 * theme README) — one icon per row whose Platform matches a key here
	 * and whose URL isn't empty.
	 *
	 * @param string $platform One of the Social Links repeater's Platform choices.
	 * @return string SVG markup, or an empty string for an unrecognised platform.
	 */
	function cilla_skyn_footer_social_icon( string $platform ): string {
		$icons = array(
			'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/>',
			'facebook'  => '<path d="M14 9h3V6h-3a3 3 0 00-3 3v2H9v3h2v6h3v-6h3l1-3h-4V9a1 1 0 011-1z"/>',
			'tiktok'    => '<path d="M14 4v11.5a3.5 3.5 0 11-3-3.46M14 4a5 5 0 005 5"/>',
			'pinterest' => '<circle cx="12" cy="12" r="9"/><path d="M10 17c1-4 1.5-6 1.5-8a2 2 0 114 0c0 1.5-1 3.5-1.5 5"/>',
			'youtube'   => '<rect x="3" y="6" width="18" height="12" rx="3"/><path d="M11 10l4 2-4 2v-4z" fill="currentColor" stroke="none"/>',
		);

		if ( ! isset( $icons[ $platform ] ) ) {
			return '';
		}

		return '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">' . $icons[ $platform ] . '</svg>';
	}
}

/**
 * Customizer settings (replaces the SOCIAL constant from lib/links).
 */
function iga_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'iga_footer_tagline',
		[
			'default'           => __( 'A community built around iron and faith. Salt River, Cape Town. Forging people of discipline, purpose, and strength since 2022.', 'iga' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		]
	);

	$wp_customize->add_control(
		'iga_footer_tagline',
		[
			'label'   => __( 'Footer Tagline', 'iga' ),
			'section' => 'title_tagline',
			'type'    => 'textarea',
		]
	);

	// Hero slider settings.
	$wp_customize->add_section(
		'iga_hero',
		[
			'title'       => __( 'Hero Slider', 'iga' ),
			'description' => __( 'Slide content (text and images) is managed under Dashboard → Hero Slides.', 'iga' ),
		]
	);

	$wp_customize->add_setting(
		'iga_hero_interval',
		[
			'default'           => 6000,
			'sanitize_callback' => 'absint',
		]
	);

	$wp_customize->add_control(
		'iga_hero_interval',
		[
			'label'       => __( 'Autoplay interval (ms)', 'iga' ),
			'description' => __( 'Time each slide stays on screen. Minimum 2000.', 'iga' ),
			'section'     => 'iga_hero',
			'type'        => 'number',
		]
	);
}
add_action( 'customize_register', 'iga_customize_register' );
