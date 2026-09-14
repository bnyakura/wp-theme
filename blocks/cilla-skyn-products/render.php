<?php
/**
 * Cilla Skyn Products block — render template.
 *
 * Renders the exact same WooCommerce product grid as the Shop page
 * (page-shop.php) — bordered cards, result count, sort dropdown, and
 * pagination — via the native [products] shortcode with paginate="true",
 * which makes WooCommerce fire the same woocommerce_before_shop_loop /
 * woocommerce_after_shop_loop hooks the real shop archive fires (result
 * count, catalog ordering, pagination). The only addition over the Shop
 * page is the Categories field below, which filters the shortcode's
 * product_cat tax_query -- leaving it empty shows every product, same as
 * /shop. Visual parity comes from reusing the Shop page's bordered-card
 * styles, scoped to .wp-theme-cilla-skyn-products in src/input.css.
 *
 * @package custom-theme
 */

$heading    = get_field( 'heading' );
$subheading = get_field( 'subheading' );

$category_ids = get_field( 'categories' );
// is_array() (not just !empty()) matters here: when this field is empty, SCF's
// auto-inline-editing dry run (block.json's "autoInlineEditing") temporarily
// replaces the empty value with a placeholder string to trace which output
// belongs to which field -- array_map() on that string would be a fatal
// TypeError, which is what was breaking block insertion in the editor.
$category = is_array( $category_ids ) && ! empty( $category_ids ) ? implode( ',', array_map( 'absint', $category_ids ) ) : '';

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
$sort                     = get_field( 'sort' );
list( $orderby, $order ) = $sort_map[ $sort ] ?? $sort_map['default'];

$limit = min( 48, max( 1, absint( get_field( 'products_per_page' ) ?: 12 ) ) );

$shortcode = sprintf(
	'[products limit="%d" columns="4" paginate="true" visibility="visible" orderby="%s" order="%s"%s]',
	$limit,
	esc_attr( $orderby ),
	esc_attr( $order ),
	$category ? ' category="' . esc_attr( $category ) . '"' : ''
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-products bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1280px] px-4.5 py-16 min-[481px]:px-6 min-[768px]:py-20 min-[1081px]:px-[5vw]">

		<?php if ( $heading || $subheading ) : ?>
			<div class="mb-10">
				<?php if ( $heading ) : ?>
					<h2 class="mb-2 font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $subheading ) : ?>
					<p class="text-sm text-cs-ink/60"><?php echo esc_html( $subheading ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php echo do_shortcode( $shortcode ); ?>

	</div>
</section>
