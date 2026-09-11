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

$desktop_image_id = get_field( 'background_image' );
$tablet_image_id  = get_field( 'tablet_image' );
$mobile_image_id  = get_field( 'mobile_image' );

/*
 * Optional separate crops/photos per device size (art direction, not just
 * smaller versions of the same file — see the Hero block's same pattern),
 * rendered via <picture> with one <source> per tier below Desktop. Each
 * tier is independently optional: the <img> fallback below resolves to
 * whichever of Desktop/Tablet/Mobile is set first, so filling in only one
 * of the three still shows that image at every screen size, and the whole
 * image area (like every other section in this block) simply doesn't
 * render when none of the three are set.
 */
$image_id  = $desktop_image_id ?: ( $tablet_image_id ?: $mobile_image_id );
$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'full' ) : '';
$image_alt = $image_id ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : '';

$tablet_image_url = $tablet_image_id ? wp_get_attachment_image_url( (int) $tablet_image_id, 'full' ) : '';
$mobile_image_url = $mobile_image_id ? wp_get_attachment_image_url( (int) $mobile_image_id, 'full' ) : '';

/*
 * How the image fills its area (CSS object-fit). Written out as a literal
 * class-name map, rather than building "object-{$choice}" by string
 * concatenation, so Tailwind's content scanner (which just looks for these
 * exact tokens in the theme's .php files — see src/input.css's top
 * comment) can see every possible class and generate its CSS; a
 * dynamically-built class name wouldn't be visible to it.
 */
$image_fit_classes = array(
	'cover'      => 'object-cover',
	'contain'    => 'object-contain',
	'fill'       => 'object-fill',
	'none'       => 'object-none',
	'scale-down' => 'object-scale-down',
);
$image_fit_class = $image_fit_classes[ get_field( 'image_fit' ) ] ?? 'object-cover';

/*
 * Which part of the image stays visible once Image Fit crops it (CSS
 * object-position), as free-form X/Y percentages rather than a fixed set of
 * positions — set either by dragging the crosshair overlay that
 * focal-point-editor.js draws on this field's image preview in the block
 * editor, or by moving the two range sliders directly. Continuous values
 * like these can't be pre-built Tailwind classes (Tailwind only generates
 * CSS for exact class names it finds as literal text at build time, and a
 * per-post percentage never is one), so this goes out as an inline style
 * instead of a class, unlike Image Fit above.
 */
$focal_x = get_field( 'image_focal_x' );
$focal_y = get_field( 'image_focal_y' );
$focal_x = is_numeric( $focal_x ) ? max( 0, min( 100, (float) $focal_x ) ) : 50;
$focal_y = is_numeric( $focal_y ) ? max( 0, min( 100, (float) $focal_y ) ) : 50;
$image_position_style = sprintf( 'object-position: %s%% %s%%;', esc_attr( $focal_x ), esc_attr( $focal_y ) );

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
			<picture>
				<?php if ( $mobile_image_url ) : ?>
					<source media="(max-width: 767px)" srcset="<?php echo esc_url( $mobile_image_url ); ?>">
				<?php endif; ?>
				<?php if ( $tablet_image_url ) : ?>
					<source media="(max-width: 1279px)" srcset="<?php echo esc_url( $tablet_image_url ); ?>">
				<?php endif; ?>
				<img
					src="<?php echo esc_url( $image_url ); ?>"
					alt="<?php echo esc_attr( $image_alt ); ?>"
					class="h-full w-full <?php echo esc_attr( $image_fit_class ); ?>"
					style="<?php echo esc_attr( $image_position_style ); ?>"
					loading="lazy"
					decoding="async"
				>
			</picture>
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
