<?php
/**
 * General WooCommerce integration hooks.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'cilla_skyn_cart_count_fragment' ) ) {
	/**
	 * Keeps the header cart badge (span#cilla-skyn-cart-count, see header.php)
	 * in sync after AJAX add-to-cart. WooCommerce's default fragments only
	 * refresh the Mini Cart widget markup, which this theme doesn't use, so
	 * without this filter the badge only reflects the correct count on a
	 * full page reload.
	 *
	 * @param array<string, string> $fragments Fragments to refresh via wc-cart-fragments.js.
	 *
	 * @return array<string, string>
	 */
	function cilla_skyn_cart_count_fragment( array $fragments ): array {
		$count = WC()->cart->get_cart_contents_count();

		ob_start();
		?>
		<span id="cilla-skyn-cart-count" class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-cs-ink text-[9px] text-cream"><?php echo esc_html( $count > 99 ? '99+' : $count ); ?></span>
		<?php
		$fragments['#cilla-skyn-cart-count'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'cilla_skyn_cart_count_fragment' );
