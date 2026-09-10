<?php
/**
 * Cilla Skyn Order Tracking block — render template.
 *
 * A centered heading/description with a button to the customer's own
 * WooCommerce order history — for the Track Your Order page. There's no
 * shipment-tracking plugin installed, so this deliberately doesn't build a
 * custom guest order-lookup form; it points signed-in customers at
 * WooCommerce's own My Account → Orders (which already shows order status
 * and, once a shipping plugin adds it, tracking numbers), and offers a
 * contact fallback for guest checkouts. See the block's own README.
 *
 * @package custom-theme
 */

$eyebrow     = get_field( 'eyebrow' ) ?: 'Help';
$heading     = get_field( 'heading' ) ?: 'Track Your Order';
$description = get_field( 'description' ) ?: "Sign in to view your order status and history. Placed your order as a guest? Use the tracking link in your confirmation email, or reach out and we'll look it up for you.";

$button_label = get_field( 'button_label' ) ?: 'View My Orders';
$button_url   = get_field( 'button_url' );

if ( ! $button_url ) {
	$button_url = function_exists( 'wc_get_account_endpoint_url' ) ? wc_get_account_endpoint_url( 'orders' ) : '#';
}

$contact_text = get_field( 'contact_text' ) ?: 'Need help finding an order? WhatsApp us at +27 64 911 1932 or email Info@cillaskyn.co.za.';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-order-tracking bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-xl px-6 py-16 text-center min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h1 class="mb-6 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="mb-8 leading-relaxed text-cs-ink/70"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $button_label ) : ?>
			<a href="<?php echo esc_url( $button_url ); ?>" class="mb-8 inline-flex items-center gap-2 bg-cs-ink px-7 py-3.5 text-[13px] tracking-wide text-cream transition hover:bg-cs-ink/85">
				<?php echo esc_html( $button_label ); ?> <span aria-hidden="true">→</span>
			</a>
		<?php endif; ?>

		<?php if ( $contact_text ) : ?>
			<p class="text-sm text-cs-ink/55"><?php echo esc_html( $contact_text ); ?></p>
		<?php endif; ?>

	</div>
</section>
