<?php
/**
 * Cilla Skyn Banner block — render template.
 *
 * Same layout as the About Hero block (an optional full-bleed background
 * image behind an eyebrow, serif heading, two rich-text paragraphs and a
 * closing tagline), but every field here is genuinely optional — nothing
 * carries a `default_value` in acf-json/group_cilla_skyn_banner.json and
 * nothing here falls back to placeholder copy with `?:`. Leaving a field
 * empty simply omits that section rather than substituting default text,
 * so this block can be trimmed down to just an image, just a heading, or
 * left entirely blank as a plain spacer panel. Use About Hero instead when
 * the docx's own default copy should always show until someone overrides it.
 *
 * @package custom-theme
 */

$image_id  = get_field( 'background_image' );
$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'full' ) : '';
$image_alt = $image_id ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : '';

$overlay_color = get_field( 'overlay_color' );
$text_color    = get_field( 'text_color' );
$text_style    = $text_color ? sprintf( ' style="color: %s;"', esc_attr( $text_color ) ) : '';

$eyebrow = get_field( 'eyebrow' );
$heading = get_field( 'heading' );
$tagline = get_field( 'tagline' );

/*
 * Intro/Description are WYSIWYG fields (bold/headings/lists/links/images/
 * video embeds/file links) — fetched unformatted (3rd arg `false`) and run
 * through the same `the_content` pipeline WordPress uses for post content
 * (wpautop, shortcodes, oEmbed), rather than ACF's own wysiwyg formatting,
 * to avoid double-wrapping paragraphs in <p> tags. See the About Hero and
 * Contact Info blocks for the same pattern.
 */
$intro_raw       = get_field( 'intro', false, false );
$intro           = $intro_raw ? apply_filters( 'the_content', $intro_raw ) : '';
$description_raw = get_field( 'description', false, false );
$description     = $description_raw ? apply_filters( 'the_content', $description_raw ) : '';

$cilla_skyn_banner_has_content = static function ( $html ) {
	return trim( wp_strip_all_tags( $html ) ) || false !== strpos( $html, '<img' ) || false !== strpos( $html, '<iframe' );
};

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-banner relative isolate overflow-hidden bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<?php if ( $image_url ) : ?>
		<div class="absolute inset-0">
			<img
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				class="h-full w-full object-cover"
				loading="lazy"
				decoding="async"
			>
			<?php if ( $overlay_color ) : ?>
				<div class="absolute inset-0" style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="relative mx-auto max-w-2xl px-6 py-20 text-center min-[768px]:px-10 min-[768px]:py-28">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h1 class="mb-6 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $cilla_skyn_banner_has_content( $intro ) ) : ?>
			<div class="cilla-skyn-banner-content mb-4 leading-relaxed opacity-[0.8]"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php echo $intro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( $cilla_skyn_banner_has_content( $description ) ) : ?>
			<div class="cilla-skyn-banner-content mb-8 leading-relaxed opacity-[0.7]"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( $tagline ) : ?>
			<p class="flex items-center justify-center gap-3 text-[11px] uppercase tracking-[0.22em] opacity-[0.5]"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<span class="h-px w-8 bg-current"></span> <?php echo esc_html( $tagline ); ?> <span class="h-px w-8 bg-current"></span>
			</p>
		<?php endif; ?>

	</div>
</section>
