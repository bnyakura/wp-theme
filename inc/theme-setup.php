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
				'footer'             => esc_html__( 'Footer Navigation', 'custom-theme' ),
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
 * Assessment" / "Book Assessment" buttons site-wide.
 */
function iga_get_whatsapp_number_url( $message = '' ) {
    $number = get_theme_mod( 'cilla_skyn_whatsapp', '' ) ?: '27790614906';
    $url    = 'https://wa.me/' . $number;

    if ( $message ) {
        $url .= '?text=' . rawurlencode( $message );
    }

    return $url;
}








/**
 * Apply Tailwind classes to footer "Shop" menu links (footer.php).
 *
 * wp_nav_menu() has no link-class argument.
 */
function iga_footer_menu_link_atts( $atts, $item, $args ) {
	if ( 'footer' === $args->theme_location ) {
		$atts['class'] = 'text-cs-ink/65 hover:text-cs-ink';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'iga_footer_menu_link_atts', 10, 3 );

/**
 * Fallback for the footer's "Shop" column when no menu is assigned to the
 * "footer" location, so the footer isn't empty before menus are configured
 * in wp-admin.
 */
function iga_footer_nav_fallback() {
	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

	$items = [
		[ 'label' => __( 'All Products', 'custom-theme' ), 'url' => $shop_url ],
		[ 'label' => __( 'Best Sellers', 'custom-theme' ), 'url' => '#' ],
		[ 'label' => __( 'The Baby Collection', 'custom-theme' ), 'url' => '#' ],
		[ 'label' => __( 'Bundles & Sets', 'custom-theme' ), 'url' => '#' ],
		[ 'label' => __( 'Gift Cards', 'custom-theme' ), 'url' => '#' ],
	];

	echo '<ul class="cilla-skyn-footer-menu space-y-2.5 text-sm">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s" class="text-cs-ink/65 hover:text-cs-ink">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}



/**
 * Customizer settings (replaces the SOCIAL constant from lib/links).
 */
function iga_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'iga_instagram_url',
		[
			'default'           => 'https://www.instagram.com/cillaskyn',
			'sanitize_callback' => 'esc_url_raw',
		]
	);

	$wp_customize->add_control(
		'iga_instagram_url',
		[
			'label'   => __( 'Instagram URL', 'iga' ),
			'section' => 'title_tagline',
			'type'    => 'url',
		]
	);

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
