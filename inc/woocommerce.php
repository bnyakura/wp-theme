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

if ( ! function_exists( 'cilla_skyn_edit_account_dob_field' ) ) {
	/**
	 * Renders an optional "Date of birth" field on the My Account > Account
	 * details form (my-account/edit-account/). Hooked into the core form so no
	 * WooCommerce template override is needed.
	 */
	function cilla_skyn_edit_account_dob_field(): void {
		$user_id = get_current_user_id();
		$value   = $user_id ? get_user_meta( $user_id, 'cilla_skyn_date_of_birth', true ) : '';
		?>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="cilla_skyn_date_of_birth"><?php esc_html_e( 'Date of birth', 'custom-theme' ); ?>&nbsp;<span class="optional">(<?php esc_html_e( 'optional', 'custom-theme' ); ?>)</span></label>
			<input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="cilla_skyn_date_of_birth" id="cilla_skyn_date_of_birth" value="<?php echo esc_attr( $value ); ?>" />
		</p>
		<?php
	}
}
add_action( 'woocommerce_edit_account_form', 'cilla_skyn_edit_account_dob_field' );

if ( ! function_exists( 'cilla_skyn_save_account_dob_field' ) ) {
	/**
	 * Saves the optional "Date of birth" field from the Account details form.
	 * The field is optional, so an empty submission simply clears the stored
	 * value rather than raising a validation error.
	 *
	 * @param int $user_id ID of the user being updated.
	 */
	function cilla_skyn_save_account_dob_field( int $user_id ): void {
		if ( ! isset( $_POST['cilla_skyn_date_of_birth'] ) ) {
			return;
		}

		// Nonce already verified by WooCommerce's save_account_details handler.
		$dob = sanitize_text_field( wp_unslash( $_POST['cilla_skyn_date_of_birth'] ) );

		update_user_meta( $user_id, 'cilla_skyn_date_of_birth', $dob );
	}
}
add_action( 'woocommerce_save_account_details', 'cilla_skyn_save_account_dob_field' );
