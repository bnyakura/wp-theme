<?php
/**
 * Cilla Skyn Best Sellers block — render template.
 *
 * Editor fields only choose [products] shortcode attributes; WooCommerce
 * itself still owns the product query, card markup, and cart/AJAX
 * behaviour via do_shortcode(). Colour/typography overrides for that
 * shortcode's markup, to match the cream/gold Cilla Skyn palette, live in
 * src/input.css under .wp-theme-cilla-skyn-best-sellers.
 *
 * @package custom-theme
 */

$heading    = get_field( 'heading' );
$subheading = get_field( 'subheading' );

$view_all_label    = get_field( 'view_all_label' ) ?: 'View All Products';
$view_all_url_field = get_field( 'view_all_url' );
$view_all_url        = $view_all_url_field ? $view_all_url_field : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '' );

$allowed_visibility = array( 'visible', 'catalog', 'search', 'hidden', 'featured' );
$visibility          = get_field( 'visibility' );
$visibility          = in_array( $visibility, $allowed_visibility, true ) ? $visibility : 'visible';

// Editor-facing "Sort" labels mapped to valid WooCommerce orderby/order pairs
// -- the shortcode must never receive the raw editor value directly.
$sort_map = array(
	'default'        => array( 'menu_order', 'ASC' ),
	'newest'         => array( 'date', 'DESC' ),
	'oldest'         => array( 'date', 'ASC' ),
	'price_low_high' => array( 'price', 'ASC' ),
	'price_high_low' => array( 'price', 'DESC' ),
	'popularity'     => array( 'popularity', 'DESC' ),
	'rating'         => array( 'rating', 'DESC' ),
	'title_az'       => array( 'title', 'ASC' ),
	'title_za'       => array( 'title', 'DESC' ),
);
$sort               = get_field( 'sort' );
list( $orderby, $order ) = $sort_map[ $sort ] ?? $sort_map['default'];

$limit   = min( 24, max( 1, absint( get_field( 'limit' ) ?: 8 ) ) );
$columns = min( 6, max( 1, absint( get_field( 'columns' ) ?: 4 ) ) );

// "Display as Slider" toggle: when on, the product grid becomes a single
// horizontally-scrollable row (CSS-only layout, see the --slider rules in
// src/input.css). Columns then sets how many cards are visible at once; any
// extra products scroll into view. The arrow buttons and optional autoplay
// below are the only JS behaviour (assets/js/product-slider.js) — the row
// still scrolls/swipes natively without them.
$is_slider = (bool) get_field( 'slider' );

// Slider-only options. Arrows default on; autoplay off. All are inert unless
// $is_slider, mirroring the ACF conditional logic that hides them in the grid.
$show_arrows    = $is_slider && (bool) get_field( 'show_arrows' );
$autoplay       = $is_slider && (bool) get_field( 'autoplay' );
$autoplay_speed = (float) ( get_field( 'autoplay_speed' ) ?: 4 );
$autoplay_speed = min( 30, max( 1, $autoplay_speed ) );
$autoplay_ms    = (int) round( $autoplay_speed * 1000 );

// Editor-controlled typography/spacing, surfaced to CSS as custom
// properties on the section so the WooCommerce shortcode markup below can
// pick them up (see src/input.css). Clamped to the same ranges as the ACF
// fields so hand-edited meta can't produce absurd values.
$title_font_size = min( 40, max( 8, absint( get_field( 'title_font_size' ) ?: 12 ) ) );

$column_gap_field = get_field( 'column_gap' );
$column_gap       = min( 100, max( 0, '' === $column_gap_field || null === $column_gap_field ? 24 : absint( $column_gap_field ) ) );

$row_gap_field = get_field( 'row_gap' );
$row_gap       = min( 100, max( 0, '' === $row_gap_field || null === $row_gap_field ? 40 : absint( $row_gap_field ) ) );

$inline_style = sprintf(
	'--cs-bs-columns:%d;--cs-bs-title-size:%dpx;--cs-bs-col-gap:%dpx;--cs-bs-row-gap:%dpx;',
	$columns,
	$title_font_size,
	$column_gap,
	$row_gap
);

$shortcode = sprintf(
	'[products limit="%d" columns="%d" visibility="%s" orderby="%s" order="%s"]',
	$limit,
	$columns,
	esc_attr( $visibility ),
	esc_attr( $orderby ),
	esc_attr( $order )
);

$section_classes = 'wp-theme-cilla-skyn-best-sellers bg-cream font-sans-cs text-cs-ink';
if ( $is_slider ) {
	$section_classes .= ' wp-theme-cilla-skyn-best-sellers--slider';
}

$wrapper_args = array(
	'class' => $section_classes,
	'style' => $inline_style,
);

// Hooks read by assets/js/product-slider.js. Only emitted in slider mode, and
// the autoplay pair only when autoplay is on, so the script does nothing for a
// plain grid or a manual (non-autoplay) slider beyond arrow clicks.
if ( $is_slider ) {
	$wrapper_args['data-cs-slider'] = '';
	if ( $autoplay ) {
		$wrapper_args['data-cs-slider-autoplay'] = '1';
		$wrapper_args['data-cs-slider-interval'] = (string) $autoplay_ms;
	}
}

$wrapper_attributes = get_block_wrapper_attributes( $wrapper_args );

// Shared classes for the two arrow buttons (header, top-right).
$arrow_classes = 'inline-flex h-10 w-10 items-center justify-center rounded-full border border-cs-ink text-cs-ink transition hover:bg-cs-ink hover:text-cream focus-visible:outline focus-visible:outline-2 focus-visible:outline-gold';
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $heading || $subheading || $view_all_url || $show_arrows ) : ?>
			<div class="mb-10 flex items-end justify-between gap-4">
				<div>
					<?php if ( $heading ) : ?>
						<h2 class="mb-2 font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $subheading ) : ?>
						<p class="text-sm text-cs-ink/60"><?php echo esc_html( $subheading ); ?></p>
					<?php endif; ?>
				</div>
				<div class="flex items-center gap-4">
					<?php if ( $view_all_url ) : ?>
						<a href="<?php echo esc_url( $view_all_url ); ?>" class="hidden whitespace-nowrap text-[13px] underline underline-offset-4 transition hover:text-gold min-[768px]:inline-block">
							<?php echo esc_html( $view_all_label ); ?> →
						</a>
					<?php endif; ?>
					<?php if ( $show_arrows ) : ?>
						<div class="flex items-center gap-2">
							<button type="button" class="<?php echo esc_attr( $arrow_classes ); ?>" data-cs-slider-prev aria-label="<?php esc_attr_e( 'Previous products', 'custom-theme' ); ?>">
								<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
							</button>
							<button type="button" class="<?php echo esc_attr( $arrow_classes ); ?>" data-cs-slider-next aria-label="<?php esc_attr_e( 'Next products', 'custom-theme' ); ?>">
								<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="wp-theme-cilla-skyn-best-sellers__grid">
			<?php echo do_shortcode( $shortcode ); ?>
		</div>

	</div>
</section>
