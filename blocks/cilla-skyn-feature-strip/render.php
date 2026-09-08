<?php
/**
 * Cilla Skyn Feature Strip block — render template.
 *
 * A row of icon + text trust badges — mirrors
 * NewProject/cilla-skyn-homepage.html's feature strip section.
 *
 * @package custom-theme
 */

$cilla_skyn_feature_icon = static function ( $name ) {
	$paths = array(
		'leaf'   => '<path d="M4 20c8-1 12-7 12-16-9 0-14 5-14 12 0 1.5.7 3 2 4z"/>',
		'drop'   => '<path d="M12 3c3 3 3 7 0 10-3-3-3-7 0-10z"/><path d="M12 13v8"/>',
		'shield' => '<path d="M9 3h6M10 3v5l-5 9a2 2 0 002 3h10a2 2 0 002-3l-5-9V3"/>',
		'wave'   => '<path d="M4 12c2-3 4-3 6 0s4 3 6 0 4-3 4 0M4 18c2-3 4-3 6 0s4 3 6 0 4-3 4 0"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['leaf'];

	return sprintf(
		'<svg class="h-6 w-6 shrink-0 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">%s</svg>',
		$path
	);
};

$features = get_field( 'features' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-feature-strip border-y border-cs-ink/10 bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto grid max-w-[1400px] grid-cols-2 gap-8 px-6 py-10 min-[768px]:grid-cols-4 min-[768px]:px-10">
		<?php if ( ! empty( $features ) ) : ?>
			<?php foreach ( $features as $feature ) : ?>
				<div class="flex items-center gap-3">
					<?php echo $cilla_skyn_feature_icon( $feature['icon'] ?: 'leaf' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<p class="text-sm font-medium"><?php echo esc_html( $feature['title'] ); ?></p>
						<?php if ( ! empty( $feature['description'] ) ) : ?>
							<p class="text-xs text-cs-ink/55"><?php echo esc_html( $feature['description'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
