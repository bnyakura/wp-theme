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
 * already contains the Armory Products block.
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

	if ( $shop_page_id && has_block( 'wp-theme/armory-products', $shop_page_id ) ) {
		remove_filter( 'the_content', array( 'WC_Template_Loader', 'unsupported_theme_shop_content_filter' ), 10 );
	}
}
add_action( 'template_redirect', 'iga_prevent_duplicate_shop_products', 20 );





// Add scrolled class via body class (optional enhancement)
function iron_gorilla_header_classes($classes) {
    if (is_admin_bar_showing()) {
        $classes[] = 'admin-bar';
    }
    return $classes;
}
add_filter('body_class', 'iron_gorilla_header_classes');


function iron_gorilla_customizer($wp_customize) {
    $wp_customize->add_setting('iron_gorilla_whatsapp', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('iron_gorilla_whatsapp', [
        'label'   => __('WhatsApp Number', 'iron-gorilla'),
        'section' => 'title_tagline',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'iron_gorilla_customizer');








/**
 * Apply Tailwind classes to footer menu links.
 *
 * wp_nav_menu() has no link-class argument, so this filter keeps the
 * markup identical to the old React NAV list.
 */
function iga_footer_menu_link_atts( $atts, $item, $args ) {
	if ( 'footer' === $args->theme_location ) {
		$atts['class'] = 'text-[0.95rem] text-muted-l transition-colors duration-200 hover:text-white';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'iga_footer_menu_link_atts', 10, 3 );

/**
 * Fallback footer nav when no menu is assigned to the "footer" location.
 * Mirrors the hardcoded NAV array from the React site so the footer works
 * before menus are configured in wp-admin.
 */
function iga_footer_nav_fallback() {
	$items = [
		[ 'label' => __( 'About', 'iga' ), 'path' => '/about/' ],
		[ 'label' => __( 'The Forge', 'iga' ), 'path' => '/training/' ],
		[ 'label' => __( 'Armory', 'iga' ), 'path' => '/armory/' ],
		[ 'label' => __( 'FAQ', 'iga' ), 'path' => '/faq/' ],
		[ 'label' => __( 'Contact', 'iga' ), 'path' => '/contact/' ],
		[ 'label' => __( 'Legends', 'iga' ), 'path' => '/league/' ],
	];

	echo '<ul class="flex list-none flex-col gap-2.5">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s" class="text-[0.95rem] text-muted-l transition-colors duration-200 hover:text-white">%s</a></li>',
			esc_url( home_url( $item['path'] ) ),
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
			'default'           => 'https://www.instagram.com/irongorillaarmy',
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
