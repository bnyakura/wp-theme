<?php
/**
 * Cilla Skyn Pillars block — render template.
 *
 * A grid of larger icon + title + description commitment cards — for the
 * Sustainability page. Distinct from the Feature Strip block (a thin row
 * of small trust badges): this one is meant to carry real paragraph copy
 * per item. There's no matching section in
 * NewProject/cilla-skyn-homepage.html or the docx (sustainability wasn't
 * part of the original design brief), so the default copy here was
 * written for this block — see the block's own README.
 *
 * @package custom-theme
 */

$cilla_skyn_pillar_icon = static function ( $name ) {
	$paths = array(
		'leaf'     => '<path d="M4 20c8-1 12-7 12-16-9 0-14 5-14 12 0 1.5.7 3 2 4z"/>',
		'recycle'  => '<path d="M7 19H4a1 1 0 01-.87-1.5L5 14M17 19h3a1 1 0 00.87-1.5L19 14M12 3l2.5 4.5M9.5 7.5L12 3M7 19h10M5 14l2.5-4.5M19 14l-2.5-4.5"/>',
		'heart'    => '<path d="M12 20s-7-4.4-9.5-9A5.5 5.5 0 0112 6a5.5 5.5 0 019.5 5c-2.5 4.6-9.5 9-9.5 9z"/>',
		'shield'   => '<path d="M9 3h6M10 3v5l-5 9a2 2 0 002 3h10a2 2 0 002-3l-5-9V3"/>',
		'drop'     => '<path d="M12 3c3 3 3 7 0 10-3-3-3-7 0-10z"/><path d="M12 13v8"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['leaf'];

	return sprintf(
		'<svg class="h-7 w-7 shrink-0 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
		$path
	);
};

$eyebrow = get_field( 'eyebrow' ) ?: 'Sustainability';
$heading = get_field( 'heading' ) ?: 'Skincare With a Conscience';
$intro   = get_field( 'intro' ) ?: "Small, honest commitments we're building on, one step at a time.";
$pillars = get_field( 'pillars' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-pillars bg-cream-dark font-sans-cs text-cs-ink',
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

		<?php if ( ! empty( $pillars ) ) : ?>
			<div class="grid grid-cols-1 gap-10 min-[640px]:grid-cols-2 min-[1080px]:grid-cols-4">
				<?php foreach ( $pillars as $pillar ) : ?>
					<div>
						<?php echo $cilla_skyn_pillar_icon( $pillar['icon'] ?? 'leaf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php if ( ! empty( $pillar['title'] ) ) : ?>
							<h3 class="mb-2 mt-4 font-serif text-lg"><?php echo esc_html( $pillar['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $pillar['description'] ) ) : ?>
							<p class="text-sm leading-relaxed text-cs-ink/65"><?php echo esc_html( $pillar['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
