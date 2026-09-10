<?php
/**
 * Cilla Skyn Ingredients block — render template.
 *
 * A grid of hero-ingredient cards (photo, name, description) — for the
 * Our Ingredients page. There's no matching section in
 * NewProject/cilla-skyn-homepage.html or the docx (the docx only lists
 * ingredient names as part of product names, e.g. "Bakuchi Renewal
 * Facial Oil"), so the default ingredient set/copy here was written for
 * this block, not supplied by the client — see the block's own README.
 *
 * @package custom-theme
 */

$eyebrow     = get_field( 'eyebrow' ) ?: 'Our Ingredients';
$heading     = get_field( 'heading' ) ?: 'Nature, Refined by Science';
$intro       = get_field( 'intro' ) ?: 'A closer look at some of the botanicals and actives we formulate with most often.';
$ingredients = get_field( 'ingredients' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-ingredients bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<div class="mx-auto mb-12 max-w-xl text-center">
			<?php if ( $eyebrow ) : ?>
				<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( $heading ) : ?>
				<h1 class="mb-4 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>
			<?php if ( $intro ) : ?>
				<p class="leading-relaxed text-cs-ink/70"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $ingredients ) ) : ?>
			<div class="grid grid-cols-1 gap-8 min-[640px]:grid-cols-2 min-[1080px]:grid-cols-3">
				<?php foreach ( $ingredients as $ingredient ) : ?>
					<?php
					$image_id  = $ingredient['image'] ?? 0;
					$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'large' ) : '';
					$image_alt = $image_id ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : '';
					?>
					<div>
						<div class="mb-4 aspect-square overflow-hidden bg-cream-dark">
							<?php if ( $image_url ) : ?>
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $image_alt ?: ( $ingredient['name'] ?? '' ) ); ?>"
									class="h-full w-full object-cover"
									loading="lazy"
								>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $ingredient['name'] ) ) : ?>
							<h3 class="mb-1.5 font-serif text-xl"><?php echo esc_html( $ingredient['name'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $ingredient['description'] ) ) : ?>
							<p class="text-sm leading-relaxed text-cs-ink/65"><?php echo esc_html( $ingredient['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
