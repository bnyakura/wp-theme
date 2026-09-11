<?php
/**
 * Cilla Skyn Shop by Concern block — render template.
 *
 * A grid of skin-concern category tiles (image, title, subtitle, arrow
 * link) — mirrors NewProject/cilla-skyn-homepage.html's "Shop by Concern"
 * section, with each tile's flat colour swatch replaced by an image, and
 * the tile linking somewhere. Each row picks a WooCommerce Product (image
 * + link both come from the product) OR, when Product is left empty, a
 * manually uploaded Image + Link URL — see the block's own README.
 *
 * @package custom-theme
 */

$heading    = get_field( 'heading' ) ?: 'Shop by Concern';
$subheading = get_field( 'subheading' ) ?: "Real solutions for your skin's unique journey.";
$concerns   = get_field( 'concerns' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-shop-by-concern bg-cream-dark font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $heading ) : ?>
			<h2 class="mb-2 font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $subheading ) : ?>
			<p class="mb-10 text-sm text-cs-ink/60"><?php echo esc_html( $subheading ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $concerns ) ) : ?>
			<div class="grid grid-cols-2 gap-5 min-[768px]:grid-cols-3 min-[1080px]:grid-cols-6">
				<?php
				foreach ( $concerns as $concern ) :
					$product = ! empty( $concern['product'] ) && function_exists( 'wc_get_product' ) ? wc_get_product( $concern['product'] ) : null;

					if ( $product ) {
						$tile_url  = get_permalink( $product->get_id() );
						$image_id  = $product->get_image_id();
						$image_alt = $product->get_name();
					} else {
						$tile_url  = ! empty( $concern['url'] ) ? $concern['url'] : '#';
						$image_id  = ! empty( $concern['image'] ) ? (int) $concern['image'] : 0;
						$image_alt = ! empty( $concern['title'] ) ? $concern['title'] : '';
					}

					$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'large' ) : '' );
					?>
					<a href="<?php echo esc_url( $tile_url ); ?>" class="group block">
						<div class="mb-3 aspect-square overflow-hidden bg-cream">
							<?php if ( $image_url ) : ?>
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $image_alt ); ?>"
									class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
									loading="lazy"
								>
							<?php endif; ?>
						</div>
						<h3 class="text-sm font-medium leading-tight"><?php echo esc_html( $concern['title'] ); ?></h3>
						<?php if ( ! empty( $concern['subtitle'] ) ) : ?>
							<p class="mb-2 mt-1 text-xs text-cs-ink/55"><?php echo esc_html( $concern['subtitle'] ); ?></p>
						<?php endif; ?>
						<span class="inline-block text-xs transition group-hover:translate-x-1" aria-hidden="true">→</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
