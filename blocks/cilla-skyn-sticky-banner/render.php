<?php
/**
 * Cilla Skyn Sticky Banner block — render template.
 *
 * Classic CSS-only parallax: `background-attachment: fixed` on the section
 * itself (not an <img>) keeps the photo visually pinned to the browser
 * window while the section's own box scrolls past it normally, in normal
 * document flow -- no `position: sticky`, no JS, no negative margins, no
 * z-index. The next block on the page simply covers it the moment this
 * section's own box ends, exactly like any other pair of adjacent
 * sections, which is also why there's no lingering-ghost failure mode to
 * guard against here (an earlier `position: sticky` + negative-margin
 * version of this block had exactly that bug).
 *
 * Same optional fields as the Cilla Skyn Banner block otherwise (image
 * with focal point, overlay, text colour, eyebrow, heading, two rich-text
 * paragraphs, tagline) -- nothing falls back to placeholder copy, same as
 * Banner.
 *
 * @package custom-theme
 */

$desktop_image_id = get_field( 'image' );
$tablet_image_id   = get_field( 'tablet_image' );
$mobile_image_id   = get_field( 'mobile_image' );

/*
 * Optional separate crops/photos per device size (art direction, not just
 * smaller versions of the same file — see the Hero/Banner blocks' same
 * pattern). Unlike those blocks' <picture>/<source> markup, a CSS
 * background-image can't respond to a <source>'s media attribute, so the
 * per-tier swap happens via the @media-scoped <style> block below instead
 * — each tier is still independently optional, falling through to
 * whichever of Desktop/Tablet/Mobile is set first.
 */
$image_id  = $desktop_image_id ?: ( $tablet_image_id ?: $mobile_image_id );
$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'full' ) : '';

$tablet_image_url = $tablet_image_id ? wp_get_attachment_image_url( (int) $tablet_image_id, 'full' ) : $image_url;
$mobile_image_url = $mobile_image_id ? wp_get_attachment_image_url( (int) $mobile_image_id, 'full' ) : $tablet_image_url;

/*
 * Which part of the image stays visible once background-size:cover crops
 * it (CSS background-position), as free-form X/Y percentages — same
 * pattern as the Banner block's Image Focal Point fields.
 */
$focal_x = get_field( 'image_focal_x' );
$focal_y = get_field( 'image_focal_y' );
$focal_x = is_numeric( $focal_x ) ? max( 0, min( 100, (float) $focal_x ) ) : 50;
$focal_y = is_numeric( $focal_y ) ? max( 0, min( 100, (float) $focal_y ) ) : 50;

$overlay_color = get_field( 'overlay_color' );
$text_color    = get_field( 'text_color' );
$text_style    = $text_color ? sprintf( ' style="color: %s;"', esc_attr( $text_color ) ) : '';

$eyebrow = get_field( 'eyebrow' );
$heading = get_field( 'heading' );
$tagline = get_field( 'tagline' );

/*
 * Intro/Description are WYSIWYG fields, run through the same `the_content`
 * pipeline WordPress uses for post content (wpautop, shortcodes, oEmbed)
 * rather than ACF's own wysiwyg formatting, to avoid double-wrapping
 * paragraphs in <p> tags — same pattern as the Banner/About Hero blocks.
 */
$intro_raw       = get_field( 'intro', false, false );
$intro           = $intro_raw ? apply_filters( 'the_content', $intro_raw ) : '';
$description_raw = get_field( 'description', false, false );
$description     = $description_raw ? apply_filters( 'the_content', $description_raw ) : '';

$cilla_skyn_sticky_banner_has_content = static function ( $html ) {
	return trim( wp_strip_all_tags( $html ) ) || false !== strpos( $html, '<img' ) || false !== strpos( $html, '<iframe' );
};

/*
 * How tall the parallax section is — the only thing controlling how long
 * the effect lasts, now that there's no separate "pin duration" to
 * configure. Free-form vh, so it goes out as an inline style rather than
 * a pre-built Tailwind class, same reasoning as the focal-point percentages.
 */
$min_height = get_field( 'min_height' );
$min_height = is_numeric( $min_height ) ? max( 40, min( 200, (float) $min_height ) ) : 80;

$block_id = 'cilla-skyn-sticky-banner-' . wp_unique_id();

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-sticky-banner relative flex flex-col items-center justify-center bg-cream font-sans-cs text-cs-ink bg-cover bg-no-repeat',
		'style' => sprintf( 'min-height: %1$svh; background-position: %2$s%% %3$s%%;', $min_height, $focal_x, $focal_y ),
		'id'    => $block_id,
	)
);

/*
 * `background-attachment: fixed` is notoriously unreliable on iOS Safari
 * (janky/non-functional, a long-documented platform limitation, not a bug
 * here) -- falls back to a normal scrolling background below 768px, same
 * breakpoint the rest of the theme uses, rather than shipping a broken
 * effect to most phones.
 */
?>
<?php if ( $image_url ) : ?>
	<style>
		#<?php echo esc_attr( $block_id ); ?> { background-image: url('<?php echo esc_url( $image_url ); ?>'); }
		@media (max-width: 767px) {
			#<?php echo esc_attr( $block_id ); ?> { background-image: url('<?php echo esc_url( $mobile_image_url ); ?>'); background-attachment: scroll; }
		}
		@media (min-width: 768px) and (max-width: 1279px) {
			#<?php echo esc_attr( $block_id ); ?> { background-image: url('<?php echo esc_url( $tablet_image_url ); ?>'); }
		}
		@media (min-width: 768px) {
			#<?php echo esc_attr( $block_id ); ?> { background-attachment: fixed; }
		}
	</style>
<?php endif; ?>
<section <?php echo $wrapper_attributes; ?>>
	<?php if ( $overlay_color ) : ?>
		<div class="absolute inset-0" style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></div>
	<?php endif; ?>

	<div class="relative mx-auto w-full max-w-2xl px-6 py-16 text-center min-[768px]:px-10">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h1 class="mb-6 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $cilla_skyn_sticky_banner_has_content( $intro ) ) : ?>
			<div class="cilla-skyn-sticky-banner-content mb-4 leading-relaxed opacity-[0.8]"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php echo $intro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( $cilla_skyn_sticky_banner_has_content( $description ) ) : ?>
			<div class="cilla-skyn-sticky-banner-content mb-8 leading-relaxed opacity-[0.7]"<?php echo $text_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
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
