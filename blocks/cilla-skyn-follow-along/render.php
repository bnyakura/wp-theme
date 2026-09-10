<?php
/**
 * Cilla Skyn Follow Along block — render template.
 *
 * An Instagram-style tile grid mixing product photo tiles with a quote
 * tile — mirrors the approved Cilla Skyn design mockup. Caption tiles pull
 * their photo, name and link straight from a selected WooCommerce product
 * when one is set; otherwise they fall back to the flat colour + manual
 * caption used before real product photography existed.
 *
 * @package custom-theme
 */

$instagram_icon = '<svg class="absolute right-2 top-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>';

$heading  = get_field( 'heading' ) ?: 'Follow Along';
$handle   = get_field( 'handle' ) ?: '@cillaskyn';
$cta_label = get_field( 'cta_label' ) ?: 'Follow us on Instagram';
$cta_url   = get_field( 'cta_url' ) ?: '#';
$tiles     = get_field( 'tiles' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-follow-along bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<div class="mb-10 flex items-end justify-between">
			<div>
				<?php if ( $heading ) : ?>
					<h2 class="mb-1 font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $handle ) : ?>
					<p class="text-sm text-cs-ink/60"><?php echo esc_html( $handle ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="hidden whitespace-nowrap text-[13px] underline underline-offset-4 transition hover:text-gold min-[768px]:inline-block">
					<?php echo esc_html( $cta_label ); ?> →
				</a>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $tiles ) ) : ?>
			<div class="grid grid-cols-2 gap-4 min-[768px]:grid-cols-6">
				<?php foreach ( $tiles as $tile ) : ?>
					<?php if ( 'quote' === ( $tile['type'] ?? 'caption' ) ) : ?>
						<div class="relative flex aspect-square items-center justify-center p-4 text-center" style="background-color: <?php echo esc_attr( $tile['color'] ?: '#E7DCC7' ); ?>;">
							<p class="font-serif text-sm italic leading-snug">
								"<?php echo esc_html( $tile['quote'] ); ?>"<br>
								<?php if ( ! empty( $tile['attribution'] ) ) : ?>
									<span class="mt-2 block text-[10px] uppercase not-italic tracking-[0.22em]"><?php echo esc_html( $tile['attribution'] ); ?></span>
								<?php endif; ?>
							</p>
						</div>
					<?php else : ?>
						<?php
						$product   = ! empty( $tile['product'] ) ? wc_get_product( $tile['product'] ) : null;
						$image_url = $product ? wp_get_attachment_image_url( $product->get_image_id(), 'large' ) : '';
						$caption   = $tile['caption'] ?: ( $product ? $product->get_name() : '' );
						$link      = $product ? get_permalink( $product->get_id() ) : '';
						$tag       = $link ? 'a' : 'div';
						?>
						<<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

							<?php if ( $link ) : ?>href="<?php echo esc_url( $link ); ?>"<?php endif; ?>
							class="group relative flex aspect-square items-end overflow-hidden p-3"
							<?php if ( ! $image_url ) : ?>style="background-color: <?php echo esc_attr( $tile['color'] ?: '#DED0B4' ); ?>;"<?php endif; ?>
						>
							<?php if ( $image_url ) : ?>
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $caption ); ?>"
									class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
									loading="lazy"
								>
								<div class="absolute inset-0 bg-gradient-to-t from-cs-ink/70 via-cs-ink/0 to-transparent"></div>
							<?php endif; ?>
							<p class="relative text-[11px] uppercase leading-snug tracking-[0.22em] <?php echo $image_url ? 'text-cream' : ''; ?>"><?php echo nl2br( esc_html( $caption ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php if ( ! empty( $tile['show_icon'] ) ) : ?>
								<span class="relative <?php echo $image_url ? 'text-cream' : ''; ?>"><?php echo $instagram_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<?php endif; ?>
						</<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
