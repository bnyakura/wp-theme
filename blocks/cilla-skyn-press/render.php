<?php
/**
 * Cilla Skyn Press block — render template.
 *
 * "As Seen In" publication logos plus press quote mentions — for the
 * Press page. Unlike this theme's other new blocks, this one ships with
 * NO default logos or mentions: a fabricated "as seen in" claim (a real
 * publication name/logo the brand wasn't actually featured in) would be
 * misleading, not just a placeholder — so this block only ever shows
 * press coverage a real person adds. See the block's own README.
 *
 * @package custom-theme
 */

$eyebrow    = get_field( 'eyebrow' ) ?: 'Press';
$heading    = get_field( 'heading' ) ?: 'As Seen In';
$intro      = get_field( 'intro' ) ?: 'Cilla Skyn is proud to be featured by press and media who share our passion for thoughtful, purposeful skincare.';
$logos      = get_field( 'logos' );
$mentions   = get_field( 'mentions' );
$empty_text = get_field( 'empty_state_text' ) ?: "We're just getting started — check back soon for press mentions.";

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-press bg-cream font-sans-cs text-cs-ink',
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

		<?php if ( ! empty( $logos ) ) : ?>
			<div class="mb-16 flex flex-wrap items-center justify-center gap-x-12 gap-y-8">
				<?php foreach ( $logos as $logo ) : ?>
					<?php
					$image_id  = $logo['logo'] ?? 0;
					$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'medium' ) : '';
					if ( ! $image_url ) {
						continue;
					}
					$tag = ! empty( $logo['url'] ) ? 'a' : 'span';
					?>
					<<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php if ( 'a' === $tag ) : ?>href="<?php echo esc_url( $logo['url'] ); ?>" target="_blank" rel="noopener noreferrer"<?php endif; ?>
						class="opacity-60 grayscale transition hover:opacity-100 hover:grayscale-0"
					>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $logo['name'] ?? '' ); ?>" class="h-8 w-auto min-[768px]:h-10">
					</<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $mentions ) ) : ?>
			<div class="mx-auto grid max-w-4xl grid-cols-1 gap-8 min-[768px]:grid-cols-3">
				<?php foreach ( $mentions as $mention ) : ?>
					<?php if ( ! empty( $mention['quote'] ) ) : ?>
						<blockquote class="border-t border-cs-ink/15 pt-5">
							<p class="mb-3 font-serif text-lg italic leading-snug">&ldquo;<?php echo esc_html( $mention['quote'] ); ?>&rdquo;</p>
							<?php if ( ! empty( $mention['publication'] ) ) : ?>
								<cite class="text-[11px] not-italic uppercase tracking-[0.18em] text-cs-ink/55">
									<?php if ( ! empty( $mention['url'] ) ) : ?>
										<a href="<?php echo esc_url( $mention['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-cs-ink"><?php echo esc_html( $mention['publication'] ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $mention['publication'] ); ?>
									<?php endif; ?>
								</cite>
							<?php endif; ?>
						</blockquote>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( empty( $logos ) && empty( $mentions ) && $empty_text ) : ?>
			<p class="text-center text-sm text-cs-ink/50"><?php echo esc_html( $empty_text ); ?></p>
		<?php endif; ?>

	</div>
</section>
