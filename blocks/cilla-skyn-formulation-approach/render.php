<?php
/**
 * Cilla Skyn Formulation Approach block — render template.
 *
 * A narrow-column formulation-philosophy section for the About page —
 * eyebrow, serif heading, one paragraph per Repeater row, and a
 * three-line principles strip underneath. Mirrors the "Our Formulation
 * Approach — Every Ingredient Should Have a Purpose" copy in
 * NewProject/Cilla Skyn Website Layout.docx's About Us section.
 *
 * @package custom-theme
 */

$eyebrow    = get_field( 'eyebrow' ) ?: 'Our Formulation Approach';
$heading    = get_field( 'heading' ) ?: 'Every Ingredient Should Have a Purpose';
$paragraphs = get_field( 'paragraphs' );
$principles = get_field( 'principles' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-formulation-approach bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-20 min-[768px]:px-10 min-[768px]:py-24">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-center text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h2 class="mb-8 text-center font-serif text-3xl leading-[1.15] min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $paragraphs ) ) : ?>
			<div class="space-y-4 text-center leading-relaxed text-cs-ink/75">
				<?php foreach ( $paragraphs as $paragraph ) : ?>
					<?php if ( ! empty( $paragraph['paragraph'] ) ) : ?>
						<p><?php echo esc_html( $paragraph['paragraph'] ); ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $principles ) ) : ?>
			<div class="mt-12 grid grid-cols-1 gap-6 border-t border-cs-ink/10 pt-10 text-center min-[768px]:grid-cols-3 min-[768px]:gap-4">
				<?php foreach ( $principles as $principle ) : ?>
					<?php if ( ! empty( $principle['label'] ) ) : ?>
						<p class="font-serif text-lg italic text-cs-ink"><?php echo esc_html( $principle['label'] ); ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
