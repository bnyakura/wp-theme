<?php
/**
 * Single product page — related products renderer and small compatibility
 * fixes for the custom single-product.php template.
 *
 * @package custom-theme
 */

/**
 * Undo two compatibility shims WooCommerce applies for themes without
 * add_theme_support('woocommerce') (see WC_Template_Loader::
 * unsupported_theme_product_page_init(), hooked on template_redirect
 * priority 10) that fight our custom single-product.php template:
 *
 * 1. unsupported_theme_product_content_filter() replaces the_content()
 *    with do_shortcode('[product_page ...]') -- a full nested re-render of
 *    the entire product page. woocommerce_output_product_data_tabs()'s
 *    Description tab calls the_content() internally, so without this fix
 *    the Description tab contained a second complete copy of the gallery,
 *    price, add-to-cart form, meta, and tabs.
 * 2. unsupported_theme_remove_review_tab() strips the Reviews tab, on the
 *    assumption such themes render reviews via their own comments
 *    template instead of tabs -- ours doesn't, so put it back.
 */
function iga_fix_single_product_tabs() {
	if ( ! function_exists( 'is_product' ) || ! is_product() || ! class_exists( 'WC_Template_Loader' ) ) {
		return;
	}

	remove_filter( 'the_content', array( 'WC_Template_Loader', 'unsupported_theme_product_content_filter' ), 10 );
	remove_filter( 'woocommerce_product_tabs', array( 'WC_Template_Loader', 'unsupported_theme_remove_review_tab' ) );
}
add_action( 'template_redirect', 'iga_fix_single_product_tabs', 20 );

/**
 * Restore a third compatibility shim WC_Template_Loader::init() only wires
 * up when add_theme_support('woocommerce') is declared: the 'comments_template'
 * filter that swaps in WooCommerce's own templates/single-product-reviews.php
 * (star-rating select, "Add a review" / "Be the first to review" copy, the
 * #reviews/.woocommerce-Reviews markup this theme's CSS already targets)
 * whenever the Reviews tab's callback -- woocommerce_output_product_data_tabs()
 * hard-codes the string 'comments_template' -- calls comments_template( 'reviews', ... ).
 *
 * Without this filter, comments_template() looks for a theme-root file
 * literally named "reviews" (the tab key, not "reviews.php"), never finds
 * one, and silently falls back to WordPress's generic
 * wp-includes/theme-compat/comments.php -- a plain "Leave a Reply" form
 * with no rating field and none of the product-review markup at all.
 *
 * WC_Template_Loader::comments_template_loader() already contains exactly
 * the right lookup (theme override first, then the WooCommerce plugin's own
 * template), so we just point the filter at it directly instead of
 * duplicating its logic.
 */
if ( class_exists( 'WC_Template_Loader' ) ) {
	add_filter( 'comments_template', array( 'WC_Template_Loader', 'comments_template_loader' ) );
}

/**
 * Disable WooCommerce's flexslider gallery and hover-zoom on single products.
 *
 * Because this theme declares no add_theme_support('woocommerce'),
 * WooCommerce's "unsupported theme" compatibility layer
 * (WC_Template_Loader::unsupported_theme_init()) force-enables
 * wc-product-gallery-slider / -zoom / -lightbox for us. flexslider then runs
 * on our custom .wp-theme-single-product-gallery markup, but all of the CSS
 * that sizes and clips it ships scoped to WooCommerce's own
 * ".woocommerce div.product div.images" wrapper -- which our custom
 * single-product.php template doesn't output. With no width constraint from
 * that CSS, flexslider mis-measures the gallery and pins every slide to a
 * ~1400px inline width, so the main image sprawls far past its column and is
 * clipped by the page's overflow-x (most visibly broken on mobile).
 *
 * The static (no-flexslider) gallery markup lays out correctly on its own and
 * is styled in src/input.css. We keep the PhotoSwipe lightbox so tapping an
 * image still opens it full-screen; hover-zoom is pointless on touch and
 * depends on the same broken sizing, so it's disabled too.
 */
add_filter( 'woocommerce_single_product_flexslider_enabled', '__return_false' );
add_filter( 'woocommerce_single_product_zoom_enabled', '__return_false' );

if ( ! function_exists( 'iga_render_related_products' ) ) {
	/**
	 * Outputs a "You May Also Like" grid of related products.
	 *
	 * Renders WooCommerce's native [products] grid — the same markup the
	 * Best Sellers block, Shop page and Products block use — so these cards
	 * match every other product surface on the site exactly: full-bleed 4:5
	 * image, title, price (incl. sale strike-through), star rating, sale
	 * badge and the real AJAX add-to-cart button. The shared borderless
	 * cream/gold card styling lives in src/input.css, where
	 * .wp-theme-single-product-related rides on the Best Sellers ruleset.
	 *
	 * This replaces the previous hand-built card markup, which had drifted
	 * from the rest of the site (static "Shop Now" link, no star rating/sale
	 * badge, and a price line that rendered empty).
	 *
	 * @param WC_Product $product Current product.
	 * @return void
	 */
	function iga_render_related_products( WC_Product $product ): void {
		$related_ids = wc_get_related_products( $product->get_id(), 5 );

		if ( empty( $related_ids ) ) {
			return;
		}

		// absint() each id and let WooCommerce's shortcode own the query and
		// card markup. limit matches the id count so none are dropped (the
		// shortcode's default per-page cap can be lower than the id list).
		$ids = implode( ',', array_map( 'absint', $related_ids ) );
		?>
		<div class="mx-auto mb-10 max-w-2xl text-center">
			<h2 class="font-serif text-3xl leading-none text-cs-ink sm:text-4xl">
				<?php esc_html_e( 'You May Also Like', 'iga' ); ?>
			</h2>
		</div>

		<?php
		// --cs-bs-columns is the Best Sellers ruleset's desktop column count
		// (it defaults to 4); set it to 5 here so this shared grid shows five
		// cards per row on desktop. Tablet/mobile still step down to 3/2 for
		// legibility, same as every other product grid.
		?>
		<div class="wp-theme-single-product-related" style="--cs-bs-columns:5;">
			<?php
			echo do_shortcode(
				sprintf(
					'[products ids="%s" columns="5" limit="%d"]',
					esc_attr( $ids ),
					count( $related_ids )
				)
			);
			?>
		</div>
		<?php
	}
}
