<?php
/**
 * Cilla Skyn About Hero block — render template.
 *
 * A centered brand-statement intro for the top of the About page — an
 * optional full-bleed background image behind eyebrow, serif heading, two
 * supporting paragraphs and a closing tagline. Mirrors the "Hero
 * Statement" copy in NewProject/Cilla Skyn Website Layout.docx's About Us
 * section (there's no matching section in
 * NewProject/cilla-skyn-homepage.html since this is an About-page block,
 * not a homepage one). Unlike the Hero block, there's no bundled fallback
 * photo — the background is optional and the section renders as a plain
 * cream panel until one is set, since no image was supplied for this
 * section in the source design.
 *
 * @package custom-theme
 */

$image_id  = get_field( 'background_image' );
$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'full' ) : '';
$image_alt = $image_id ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : '';

$overlay_color = get_field( 'overlay_color' ) ?: 'rgba(244, 236, 224, 0.8)';
$text_color    = get_field( 'text_color' ) ?: '#1B1712';

$eyebrow = get_field( 'eyebrow' ) ?: 'About Cilla Skyn';
$heading = get_field( 'heading' ) ?: 'Skincare with Purpose';
$tagline = get_field( 'tagline' ) ?: 'Thoughtfully formulated. Purposefully layered. Inspired by nature.';

/*
 * Intro/Description are WYSIWYG fields (bold/headings/lists/links/images/
 * video embeds/file links) — fetched unformatted (3rd arg `false`) and
 * run through the same `the_content` pipeline WordPress uses for post
 * content (wpautop, shortcodes, oEmbed), rather than ACF's own wysiwyg
 * formatting, to avoid double-wrapping paragraphs in <p> tags. See the
 * Contact Info block for the same pattern.
 */
$intro_raw = get_field( 'intro', false, false ) ?: 'Cilla Skyn™ is a modern African skincare brand creating thoughtful, sensorial formulations inspired by nature and refined by science.';
$intro     = apply_filters( 'the_content', $intro_raw );

$description_raw = get_field( 'description', false, false ) ?: 'We believe skincare should do more than simply sit on the skin. It should feel considered, purposeful and beautifully balanced — from the ingredients chosen to the textures experienced and the rituals created around them.';
$description     = apply_filters( 'the_content', $description_raw );

$cilla_skyn_about_hero_has_content = static function ( $html ) {
	return trim( wp_strip_all_tags( $html ) ) || false !== strpos( $html, '<img' ) || false !== strpos( $html, '<iframe' );
};

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-about-hero relative isolate overflow-hidden bg-cream font-sans-cs text-cs-ink',
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
			<div class="absolute inset-0" style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></div>
		</div>
	<?php endif; ?>

	<div class="relative mx-auto max-w-2xl px-6 py-20 text-center min-[768px]:px-10 min-[768px]:py-28">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h1 class="mb-6 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl" style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $cilla_skyn_about_hero_has_content( $intro ) ) : ?>
			<div class="cilla-skyn-about-hero-content mb-4 leading-relaxed opacity-[0.8]" style="color: <?php echo esc_attr( $text_color ); ?>;">
				<?php echo $intro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( $cilla_skyn_about_hero_has_content( $description ) ) : ?>
			<div class="cilla-skyn-about-hero-content mb-8 leading-relaxed opacity-[0.7]" style="color: <?php echo esc_attr( $text_color ); ?>;">
				<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( $tagline ) : ?>
			<p class="flex items-center justify-center gap-3 text-[11px] uppercase tracking-[0.22em] opacity-[0.5]" style="color: <?php echo esc_attr( $text_color ); ?>;">
				<span class="h-px w-8 bg-current"></span> <?php echo esc_html( $tagline ); ?> <span class="h-px w-8 bg-current"></span>
			</p>
		<?php endif; ?>

	</div>
</section>
