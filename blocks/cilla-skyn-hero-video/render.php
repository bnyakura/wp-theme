<?php
/**
 * Cilla Skyn Hero Video block — render template.
 *
 * Same full-bleed cream hero shell as the Cilla Skyn Hero block, but with a
 * looping background video instead of a responsive image, no
 * eyebrow/description/secondary button, and editor-controlled text colour
 * and text/CTA alignment.
 *
 * Heading, Button Label/URL and Footer Note are all optional -- each is
 * wrapped in its own `if`, so clearing one in the editor just omits that
 * line instead of falling back to placeholder copy. Leaving all of them
 * empty (with no video/poster either) renders an empty section with only
 * its own padding.
 *
 * @package custom-theme
 */

$video_url        = get_field( 'video' ) ?: '';
$video_mobile_url = get_field( 'video_mobile' ) ?: '';

/*
 * Minimum height of the section below 768px wide, written as a literal
 * class-name map for the same Tailwind content-scanner reason as the
 * object-fit/position maps below -- a class built by concatenating the
 * field's raw value at runtime would be invisible to Tailwind's build.
 * "Tall" (1320px) is the original value carried over from the image Hero
 * block's shell and matches its own documented mobile layout tuning; it
 * isn't necessarily right for every video, so it's editable here rather
 * than fixed.
 */
$mobile_height_classes = array(
	'auto'   => '',
	'short'  => 'min-h-[480px]',
	'medium' => 'min-h-[720px]',
	'tall'   => 'min-h-[1320px]',
	'screen' => 'min-h-screen',
);
$mobile_height_class = $mobile_height_classes[ get_field( 'mobile_height' ) ?: 'tall' ] ?? 'min-h-[1320px]';

$poster_id  = get_field( 'poster_image' );
$poster_url = $poster_id ? wp_get_attachment_image_url( (int) $poster_id, 'full' ) : '';
$poster_alt = $poster_id ? get_post_meta( (int) $poster_id, '_wp_attachment_image_alt', true ) : '';

/*
 * How the background video fills its area (CSS object-fit) and which part
 * of it stays in view once cropped (CSS object-position) — written out as
 * literal class-name maps rather than building "object-{$choice}" by string
 * concatenation, so Tailwind's content scanner (which just looks for these
 * exact tokens in the theme's .php files — see src/input.css's top comment)
 * can see every possible class and generate its CSS.
 */
$video_fit_classes = array(
	'cover'      => 'object-cover',
	'contain'    => 'object-contain',
	'fill'       => 'object-fill',
	'none'       => 'object-none',
	'scale-down' => 'object-scale-down',
);
$video_fit_class = $video_fit_classes[ get_field( 'video_fit' ) ] ?? 'object-cover';

$video_position_classes = array(
	'top left'     => 'object-left-top',
	'top'          => 'object-top',
	'top right'    => 'object-right-top',
	'left'         => 'object-left',
	'center'       => 'object-center',
	'right'        => 'object-right',
	'bottom left'  => 'object-left-bottom',
	'bottom'       => 'object-bottom',
	'bottom right' => 'object-right-bottom',
);
$video_position_class = $video_position_classes[ get_field( 'video_position' ) ] ?? 'object-center';

/*
 * Overlay sitting on top of the Background Video so the text stays
 * readable — a gradient, a flat solid-colour wash, or none at all.
 * `$overlay_style_css` becomes the overlay <div>'s whole inline `style`
 * attribute value (or '' to render no overlay div).
 */
$overlay_style = get_field( 'overlay_style' ) ?: 'gradient';

$overlay_style_css = '';
if ( 'solid' === $overlay_style ) {
	$overlay_color     = get_field( 'overlay_color' ) ?: 'rgba(244, 236, 224, 0.85)';
	$overlay_style_css = 'background-color: ' . $overlay_color . ';';
} elseif ( 'gradient' === $overlay_style ) {
	$gradient_start     = get_field( 'gradient_start_color' ) ?: 'rgba(244, 236, 224, 1)';
	$gradient_end       = get_field( 'gradient_end_color' ) ?: 'rgba(244, 236, 224, 0.2)';
	$gradient_direction = get_field( 'gradient_direction' ) ?: 'to right';
	$overlay_style_css  = 'background-image: linear-gradient(' . $gradient_direction . ', ' . $gradient_start . ', ' . $gradient_end . ');';
}

$heading     = get_field( 'heading' );
$footer_note = get_field( 'footer_note' );

$text_color = get_field( 'text_color' ) ?: '#1B1712';

/*
 * Horizontal alignment of the heading/button/footer-note column — written
 * as a literal class-name map for the same Tailwind content-scanner reason
 * as the object-fit/position maps above.
 */
$alignment_classes = array(
	'left'   => array(
		'text'    => 'text-left',
		'items'   => 'items-start',
		'justify' => 'justify-start',
	),
	'center' => array(
		'text'    => 'text-center',
		'items'   => 'items-center',
		'justify' => 'justify-center',
	),
	'right'  => array(
		'text'    => 'text-right',
		'items'   => 'items-end',
		'justify' => 'justify-end',
	),
);
$alignment_key = get_field( 'text_alignment' ) ?: 'left';
$alignment     = $alignment_classes[ $alignment_key ] ?? $alignment_classes['left'];

/*
 * Left alignment keeps the original 7/5 column split so the side list has
 * room on the right. Center/Right have nothing to share the row with — the
 * text column takes the full width so "Center" lands on the true center of
 * the banner instead of just the center of a box pinned to the left half,
 * and the Side Items list (which assumes a left-aligned block next to it)
 * is skipped in that case.
 */
$content_col_span_class = 'left' === $alignment_key ? 'min-[768px]:col-span-7' : 'min-[768px]:col-span-12';

$primary_label = get_field( 'primary_button_label' );
$primary_url   = get_field( 'primary_button_url' );

$side_items = 'left' === $alignment_key ? get_field( 'side_items' ) : false;

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-hero-video relative isolate overflow-hidden bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="absolute inset-0">
		<?php if ( $video_url ) : ?>
			<video
				class="h-full w-full <?php echo esc_attr( $video_fit_class . ' ' . $video_position_class ); ?>"
				autoplay
				muted
				loop
				playsinline
				preload="auto"
				<?php if ( $poster_url ) : ?>poster="<?php echo esc_url( $poster_url ); ?>"<?php endif; ?>
			>
				<?php if ( $video_mobile_url ) : ?>
					<source media="(max-width: 767px)" src="<?php echo esc_url( $video_mobile_url ); ?>">
				<?php endif; ?>
				<source src="<?php echo esc_url( $video_url ); ?>">
			</video>
		<?php elseif ( $poster_url ) : ?>
			<img
				src="<?php echo esc_url( $poster_url ); ?>"
				alt="<?php echo esc_attr( $poster_alt ); ?>"
				class="h-full w-full <?php echo esc_attr( $video_fit_class . ' ' . $video_position_class ); ?>"
				loading="eager"
				decoding="async"
			>
		<?php endif; ?>
		<?php if ( $overlay_style_css ) : ?>
			<div class="absolute inset-0" style="<?php echo esc_attr( $overlay_style_css ); ?>"></div>
		<?php endif; ?>
	</div>

	<div class="relative mx-auto grid <?php echo esc_attr( $mobile_height_class ); ?> max-w-[1400px] grid-cols-1 gap-8 px-6 py-20 min-[768px]:min-h-[560px] min-[768px]:grid-cols-12 min-[768px]:px-10 min-[768px]:py-28" style="color: <?php echo esc_attr( $text_color ); ?>;">
		<div class="flex flex-col justify-start min-[768px]:justify-center <?php echo esc_attr( $content_col_span_class . ' ' . $alignment['text'] . ' ' . $alignment['items'] ); ?>">
			<?php if ( $heading ) : ?>
				<h1 class="mb-6 max-w-xl font-serif text-5xl leading-[1.08] min-[768px]:text-6xl"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<?php if ( $primary_label ) : ?>
				<div class="mb-10 flex flex-wrap gap-4 <?php echo esc_attr( $alignment['justify'] ); ?>">
					<a href="<?php echo esc_url( $primary_url ); ?>" class="inline-flex items-center gap-2 bg-cs-ink px-7 py-3.5 text-[13px] tracking-wide text-cream transition hover:bg-cs-ink/85">
						<?php echo esc_html( $primary_label ); ?> <span aria-hidden="true">→</span>
					</a>
				</div>
			<?php endif; ?>

			<?php if ( $footer_note ) : ?>
				<p class="flex items-center gap-3 text-[11px] uppercase tracking-[0.22em] opacity-50 <?php echo esc_attr( $alignment['justify'] ); ?>">
					<span class="h-px w-8 bg-current"></span> <?php echo esc_html( $footer_note ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $side_items ) ) : ?>
			<div class="hidden flex-col items-end justify-center text-right min-[768px]:col-span-5 min-[768px]:flex">
				<ul class="space-y-2 text-[12px] uppercase tracking-[0.22em] opacity-70">
					<?php foreach ( $side_items as $item ) : ?>
						<li><?php echo esc_html( $item['label'] ); ?></li>
					<?php endforeach; ?>
				</ul>
				<span class="mt-4 block h-px w-8 bg-current opacity-40"></span>
			</div>
		<?php endif; ?>
	</div>
</section>
