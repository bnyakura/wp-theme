<?php
/**
 * Cilla Skyn Hero block — render template.
 *
 * Full-bleed cream hero: a background image fading into the cream section
 * colour, a serif headline/description/two buttons on the left, and an
 * optional vertical label list on the right — mirrors
 * NewProject/cilla-skyn-homepage.html's hero section.
 *
 * @package custom-theme
 */

$theme_uri = get_stylesheet_directory_uri();

$image_id  = get_field( 'image' );
$image_url = $image_id ? wp_get_attachment_image_url( (int) $image_id, 'full' ) : $theme_uri . '/assets/images/cilla-skyn-hero.jpg';
$image_alt = $image_id ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : 'Cilla Skyn natural botanical ingredients';

/*
 * Optional separate crops/photos per device size (art direction, not
 * just smaller versions of the same file — the mobile shot is typically
 * a different, taller composition) — rendered via <picture> with one
 * <source> per tier below Desktop, so the browser picks whichever file
 * actually matches the viewport instead of just scaling the desktop
 * image down. Sources are evaluated top-to-bottom and the browser uses
 * the first one whose media query matches, so an empty tier is simply
 * omitted below and the next size up is used for that viewport range —
 * no explicit fallback logic needed here.
 */
$laptop_image_id  = get_field( 'laptop_image' );
$laptop_image_url = $laptop_image_id ? wp_get_attachment_image_url( (int) $laptop_image_id, 'full' ) : '';

$tablet_image_id  = get_field( 'tablet_image' );
$tablet_image_url = $tablet_image_id ? wp_get_attachment_image_url( (int) $tablet_image_id, 'full' ) : '';

$mobile_image_id  = get_field( 'mobile_image' );
$mobile_image_url = $mobile_image_id ? wp_get_attachment_image_url( (int) $mobile_image_id, 'full' ) : '';

/*
 * Overlay sitting on top of the Background Image so the text stays
 * readable — either the original design's left-to-right gradient, a flat
 * solid-colour wash, or none at all. `$overlay_style_css` becomes the
 * overlay <div>'s whole inline `style` attribute value (or '' to render
 * no overlay div).
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

$eyebrow     = get_field( 'eyebrow' ) ?: 'Nature Meets A Brighter You';
$heading     = get_field( 'heading' ) ?: 'Layered in the Essence of Nature.';
$description = get_field( 'description' ) ?: 'Cilla Skyn™ is a modern African skincare brand blending powerful botanicals and advanced science to reveal healthy, radiant skin — for today and generations to come.';
$footer_note = get_field( 'footer_note' ) ?: 'African Roots. Radiant Tomorrows.';

$primary_label = get_field( 'primary_button_label' ) ?: 'Shop Best Sellers';
$primary_url   = get_field( 'primary_button_url' ) ?: '#bestsellers';

$secondary_label = get_field( 'secondary_button_label' ) ?: 'Explore Rituals';
$secondary_url   = get_field( 'secondary_button_url' ) ?: '#';

$side_items = get_field( 'side_items' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-hero relative isolate overflow-hidden bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="absolute inset-0">
		<picture>
			<?php if ( $mobile_image_url ) : ?>
				<source media="(max-width: 767px)" srcset="<?php echo esc_url( $mobile_image_url ); ?>">
			<?php endif; ?>
			<?php if ( $tablet_image_url ) : ?>
				<source media="(max-width: 1279px)" srcset="<?php echo esc_url( $tablet_image_url ); ?>">
			<?php endif; ?>
			<?php if ( $laptop_image_url ) : ?>
				<source media="(max-width: 1919px)" srcset="<?php echo esc_url( $laptop_image_url ); ?>">
			<?php endif; ?>
			<img
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				class="h-full w-full object-cover"
				loading="eager"
				decoding="async"
			>
		</picture>
		<?php if ( $overlay_style_css ) : ?>
			<div class="absolute inset-0" style="<?php echo esc_attr( $overlay_style_css ); ?>"></div>
		<?php endif; ?>
	</div>

	<div class="relative mx-auto grid min-h-[560px] max-w-[1400px] grid-cols-1 gap-8 px-6 py-20 min-[768px]:grid-cols-12 min-[768px]:px-10 min-[768px]:py-28">
		<div class="flex flex-col justify-center min-[768px]:col-span-7">
			<?php if ( $eyebrow ) : ?>
				<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-cs-ink/60"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1 class="mb-6 max-w-xl font-serif text-5xl leading-[1.08] min-[768px]:text-6xl"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p class="mb-8 max-w-md leading-relaxed text-cs-ink/70"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>

			<?php if ( $primary_label || $secondary_label ) : ?>
				<div class="mb-10 flex flex-wrap gap-4">
					<?php if ( $primary_label ) : ?>
						<a href="<?php echo esc_url( $primary_url ); ?>" class="inline-flex items-center gap-2 bg-cs-ink px-7 py-3.5 text-[13px] tracking-wide text-cream transition hover:bg-cs-ink/85">
							<?php echo esc_html( $primary_label ); ?> <span aria-hidden="true">→</span>
						</a>
					<?php endif; ?>
					<?php if ( $secondary_label ) : ?>
						<a href="<?php echo esc_url( $secondary_url ); ?>" class="inline-flex items-center gap-2 border border-cs-ink px-7 py-3.5 text-[13px] tracking-wide text-cs-ink transition hover:bg-cs-ink hover:text-cream">
							<?php echo esc_html( $secondary_label ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $footer_note ) : ?>
				<p class="flex items-center gap-3 text-[11px] uppercase tracking-[0.22em] text-cs-ink/50">
					<span class="h-px w-8 bg-cs-ink/40"></span> <?php echo esc_html( $footer_note ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $side_items ) ) : ?>
			<div class="hidden flex-col items-end justify-center text-right min-[768px]:col-span-5 min-[768px]:flex">
				<ul class="space-y-2 text-[12px] uppercase tracking-[0.22em] text-cs-ink/70">
					<?php foreach ( $side_items as $item ) : ?>
						<li><?php echo esc_html( $item['label'] ); ?></li>
					<?php endforeach; ?>
				</ul>
				<span class="mt-4 block h-px w-8 bg-cs-ink/40"></span>
			</div>
		<?php endif; ?>
	</div>
</section>
