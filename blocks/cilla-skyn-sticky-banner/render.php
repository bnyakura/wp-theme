<?php
/**
 * Cilla Skyn Sticky Banner block — render template.
 *
 * A full-bleed image banner meant to sit between two other sections on a
 * page and mark the break between them: its outer wrapper is taller than
 * the viewport (Pin Duration, below), but the image/text inside it is
 * `position: sticky; top: 0; height: 100vh`, so it locks in place and
 * stays fully visible for that extra scroll distance — the section above
 * scrolls away, this banner holds still for a beat, then releases and the
 * section below continues normally. That pause is what reads as a
 * deliberate divider rather than just another section going by.
 *
 * Same field set as the Cilla Skyn Banner block otherwise (image with
 * fit/focal point, overlay, text colour, eyebrow, heading, two rich-text
 * paragraphs, tagline) — every field optional, nothing falls back to
 * placeholder copy, same as Banner.
 *
 * @package custom-theme
 */

$desktop_image_id = get_field( 'image' );
$tablet_image_id   = get_field( 'tablet_image' );
$mobile_image_id   = get_field( 'mobile_image' );

/*
 * Optional separate crops/photos per device size (art direction, not just
 * smaller versions of the same file — see the Hero/Banner blocks' same
 * pattern), rendered via <picture> with one <source> per tier below
 * Desktop. Each tier is independently optional: the <img> fallback below
 * resolves to whichever of Desktop/Tablet/Mobile is set first.
 */
$image_id  = $desktop_image_id ?: ( $tablet_image_id ?: $mobile_image_id );
$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'full' ) : '';
$image_alt = $image_id ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : '';

$tablet_image_url = $tablet_image_id ? wp_get_attachment_image_url( (int) $tablet_image_id, 'full' ) : '';
$mobile_image_url = $mobile_image_id ? wp_get_attachment_image_url( (int) $mobile_image_id, 'full' ) : '';

/*
 * How the image fills the banner (CSS object-fit). Written out as a
 * literal class-name map, rather than building "object-{$choice}" by
 * string concatenation, so Tailwind's content scanner (which just looks
 * for these exact tokens in the theme's .php files — see src/input.css's
 * top comment) can see every possible class and generate its CSS.
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
 * object-position), as free-form X/Y percentages — see the Banner block's
 * identical pattern. Continuous values like these can't be pre-built
 * Tailwind classes, so this goes out as an inline style instead.
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
 * How long the banner holds still, as a percentage of the viewport height
 * for the *outer* wrapper — the inner pinned content is always exactly one
 * viewport tall (100vh), so anything above 100% here is extra scroll
 * distance the visitor spends looking at a banner that isn't moving. 100%
 * turns off the pinning effect entirely (wrapper and pinned content are
 * the same height, so there's no extra distance to stick through) and the
 * block behaves like an ordinary full-height section.
 */
$pin_height = get_field( 'pin_height' );
$pin_height = is_numeric( $pin_height ) ? max( 100, min( 300, (float) $pin_height ) ) : 150;

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-sticky-banner relative isolate bg-cream font-sans-cs text-cs-ink',
		'style' => sprintf( 'min-height: %svh;', $pin_height ),
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="sticky top-0 h-screen w-full overflow-hidden">
		<?php if ( $image_url ) : ?>
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
					class="absolute inset-0 h-full w-full <?php echo esc_attr( $image_fit_class ); ?>"
					style="<?php echo esc_attr( $image_position_style ); ?>"
					loading="lazy"
					decoding="async"
				>
			</picture>
		<?php endif; ?>
		<?php if ( $overlay_color ) : ?>
			<div class="absolute inset-0" style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></div>
		<?php endif; ?>

		<div class="relative mx-auto flex h-full max-w-2xl flex-col items-center justify-center px-6 text-center min-[768px]:px-10">

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
	</div>
</section>
