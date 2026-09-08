<?php
/**
 * Cilla Skyn Follow Along block — render template.
 *
 * An Instagram-style tile grid mixing flat colour-block captions with a
 * quote tile — mirrors NewProject/cilla-skyn-homepage.html's "Follow
 * Along" section.
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
						<div class="relative flex aspect-square items-end p-3" style="background-color: <?php echo esc_attr( $tile['color'] ?: '#DED0B4' ); ?>;">
							<p class="text-[11px] uppercase leading-snug tracking-[0.22em]"><?php echo nl2br( esc_html( $tile['caption'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php if ( ! empty( $tile['show_icon'] ) ) : ?>
								<?php echo $instagram_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
