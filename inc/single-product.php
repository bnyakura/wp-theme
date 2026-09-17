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

if ( ! function_exists( 'iga_render_related_products' ) ) {
	/**
	 * Outputs a "You May Also Like" grid of related products, styled to
	 * match the Armory Products block cards.
	 *
	 * @param WC_Product $product Current product.
	 * @return void
	 */
	function iga_render_related_products( WC_Product $product ): void {
		$related_ids = wc_get_related_products( $product->get_id(), 4 );

		if ( empty( $related_ids ) ) {
			return;
		}
		?>
		<div class="mx-auto mb-10 max-w-2xl text-center">
			<h2 class="font-serif text-3xl leading-none text-cs-ink sm:text-4xl">
				<?php esc_html_e( 'You May Also Like', 'iga' ); ?>
			</h2>
		</div>

		<div class="grid grid-cols-1 gap-5 min-[601px]:grid-cols-2 min-[1024px]:grid-cols-4">
			<?php
			foreach ( $related_ids as $related_id ) :
				$related_product = wc_get_product( $related_id );

				if ( ! $related_product || 'publish' !== $related_product->get_status() ) {
					continue;
				}

				$image_id  = $related_product->get_image_id();
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : wc_placeholder_img_src( 'medium_large' );
				?>
				<article class="group relative flex h-full flex-col overflow-hidden border border-cs-ink/10 bg-cream-dark transition duration-300 hover:-translate-y-1 hover:border-cs-ink/30">
					<a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" class="relative block aspect-square overflow-hidden bg-cream">
						<img
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( $related_product->get_name() ); ?>"
							class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
							loading="lazy"
						>
					</a>
					<div class="flex flex-1 flex-col p-5">
						<h3 class="font-sans-cs text-sm font-medium text-cs-ink">
							<a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" class="hover:text-gold">
								<?php echo esc_html( $related_product->get_name() ); ?>
							</a>
						</h3>
						<div class="mt-2 text-sm text-cs-ink/70"><?php echo wp_kses_post( $related_product->get_price_html() ); ?></div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
