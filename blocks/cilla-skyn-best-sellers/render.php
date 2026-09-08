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

$shortcode = sprintf(
	'[products limit="%d" columns="%d" visibility="%s" orderby="%s" order="%s"]',
	$limit,
	$columns,
	esc_attr( $visibility ),
	esc_attr( $orderby ),
	esc_attr( $order )
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-best-sellers bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $heading || $subheading || $view_all_url ) : ?>
			<div class="mb-10 flex items-end justify-between">
				<div>
					<?php if ( $heading ) : ?>
						<h2 class="mb-2 font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $subheading ) : ?>
						<p class="text-sm text-cs-ink/60"><?php echo esc_html( $subheading ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $view_all_url ) : ?>
					<a href="<?php echo esc_url( $view_all_url ); ?>" class="hidden whitespace-nowrap text-[13px] underline underline-offset-4 transition hover:text-gold min-[768px]:inline-block">
						<?php echo esc_html( $view_all_label ); ?> →
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="wp-theme-cilla-skyn-best-sellers__grid">
			<?php echo do_shortcode( $shortcode ); ?>
		</div>

	</div>
</section>
