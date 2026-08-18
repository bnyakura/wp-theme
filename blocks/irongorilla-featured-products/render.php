<?php
/**
 * IronGorilla Featured Products block — render template.
 *
 * Editor fields only choose [products] shortcode attributes; WooCommerce
 * itself still owns the product query, card markup, and cart/AJAX
 * behaviour via do_shortcode(). Colour/contrast overrides for that
 * shortcode's markup on this block's white background live in
 * src/input.css under .wp-theme-irongorilla-featured-products.
 *
 * @package custom-theme
 */

$heading    = get_field( 'heading' );
$subheading = get_field( 'subheading' );

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
		'class' => 'wp-theme-irongorilla-featured-products bg-white',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1280px] px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">

		<?php if ( $heading || $subheading ) : ?>
			<div class="mx-auto mb-12 max-w-2xl text-center">
				<?php if ( $heading ) : ?>
					<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-ink sm:text-5xl">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>
				<?php if ( $subheading ) : ?>
					<p class="mx-auto max-w-xl text-sm leading-7 text-ink/65 <?php echo $heading ? 'mt-5' : ''; ?>">
						<?php echo esc_html( $subheading ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="wp-theme-irongorilla-featured-products__grid">
			<?php echo do_shortcode( $shortcode ); ?>
		</div>

	</div>
</section>
