<?php
/**
 * Cilla Skyn Shop by Concern block — render template.
 *
 * A grid of skin-concern category tiles (flat colour swatch, title,
 * subtitle, arrow link) — mirrors NewProject/cilla-skyn-homepage.html's
 * "Shop by Concern" section.
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
				<?php foreach ( $concerns as $concern ) : ?>
					<a href="<?php echo esc_url( $concern['url'] ?: '#' ); ?>" class="group block">
						<div class="mb-3 aspect-square overflow-hidden" style="background-color: <?php echo esc_attr( $concern['swatch_color'] ?: '#E4CDBB' ); ?>;"></div>
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
