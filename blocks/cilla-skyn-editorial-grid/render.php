<?php
/**
 * Cilla Skyn Editorial Grid block — render template.
 *
 * A grid of article/journal teaser tiles (image, tag, title, excerpt,
 * link) — for The Edit page. There's no blog/journal post type in this
 * theme, so each tile is a manually-entered Repeater row rather than a
 * query of real WordPress posts — see the block's own README for how to
 * point a tile at a real article once one exists (a Page, or a Post if
 * you set one up). There's no matching section in
 * NewProject/cilla-skyn-homepage.html or the docx; the example teaser
 * copy here was written for this block, not supplied by the client.
 *
 * @package custom-theme
 */

$eyebrow  = get_field( 'eyebrow' ) ?: 'The Edit';
$heading  = get_field( 'heading' ) ?: 'Stories, Rituals & Skin Wisdom';
$intro    = get_field( 'intro' ) ?: 'Skincare tips, rituals and the thinking behind our formulas.';
$articles = get_field( 'articles' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-editorial-grid bg-cream font-sans-cs text-cs-ink',
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

		<?php if ( ! empty( $articles ) ) : ?>
			<div class="grid grid-cols-1 gap-10 min-[640px]:grid-cols-2 min-[1080px]:grid-cols-3">
				<?php foreach ( $articles as $article ) : ?>
					<?php
					$image_id  = $article['image'] ?? 0;
					$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'large' ) : '';
					$url       = trim( (string) ( $article['url'] ?? '' ) );
					$tag       = $url ? 'a' : 'div';
					?>
					<<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php if ( $url ) : ?>href="<?php echo esc_url( $url ); ?>" class="group block"<?php else : ?>class="group block"<?php endif; ?>
					>
						<div class="mb-4 aspect-[4/3] overflow-hidden bg-cream-dark">
							<?php if ( $image_url ) : ?>
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $article['title'] ?? '' ); ?>"
									class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
									loading="lazy"
								>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $article['tag'] ) ) : ?>
							<p class="mb-2 text-[11px] uppercase tracking-[0.18em] text-gold"><?php echo esc_html( $article['tag'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $article['title'] ) ) : ?>
							<h3 class="mb-2 font-serif text-xl leading-snug"><?php echo esc_html( $article['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $article['excerpt'] ) ) : ?>
							<p class="mb-2 text-sm leading-relaxed text-cs-ink/65"><?php echo esc_html( $article['excerpt'] ); ?></p>
						<?php endif; ?>
						<?php if ( $url ) : ?>
							<span class="inline-block text-xs uppercase tracking-[0.18em] transition group-hover:translate-x-1"><?php esc_html_e( 'Read More', 'custom-theme' ); ?> <span aria-hidden="true">→</span></span>
						<?php endif; ?>
					</<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
