<?php
/**
 * About — Brotherhood Image block — render template.
 *
 * Self-contained: carries its own section heading (eyebrow / title /
 * subtitle) plus the group-shot photo (or placeholder) below it, so the
 * block can be independently added, removed, or reordered.
 *
 * @package Iron_Gorilla
 */

/**
 * Set brotherhood to an image URL to replace its placeholder.
 */
$iga_about_media = apply_filters(
	'iga_about_media',
	array(
		'brotherhood' => '',
	)
);

/**
 * Inline SVG icon (camera, used only by the image placeholder).
 */
$iga_about_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'camera' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75 8.25 4.5h7.5l1.5 2.25h2.25A1.5 1.5 0 0 1 21 8.25v9.75a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 18V8.25a1.5 1.5 0 0 1 1.5-1.5h2.25ZM15.75 13a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['camera'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

/**
 * Reusable section heading.
 */
$iga_about_section_header = static function ( $eyebrow, $title, $subtitle = '' ) {
	?>
	<div class="mx-auto mb-12 max-w-3xl text-center">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-green"></span>

			<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l">
				<?php echo esc_html( $eyebrow ); ?>
			</span>

			<span class="h-px w-10 bg-green"></span>
		</div>

		<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $subtitle ); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php
};

/**
 * Original Next.js page used a placeholder for this image.
 * Supply an image URL through iga_about_media to replace the placeholder.
 */
$iga_about_placeholder = static function ( $label, $ratio_class, $image = '' ) use ( $iga_about_icon ) {
	?>
	<div class="relative w-full overflow-hidden rounded-2xl <?php echo esc_attr( $ratio_class ); ?>">

		<?php if ( $image ) : ?>

			<img
				src="<?php echo esc_url( $image ); ?>"
				alt="<?php echo esc_attr( $label ); ?>"
				class="absolute inset-0 h-full w-full object-cover"
				loading="lazy"
			>

			<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

		<?php else : ?>

			<div class="absolute inset-0 flex flex-col items-center justify-center gap-3 border border-dashed border-white/15 bg-s2 text-white/20">
				<?php
				echo $iga_about_icon( 'camera', 'h-9 w-9' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>

				<span class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/35">
					<?php echo esc_html( $label ); ?>
				</span>
			</div>

		<?php endif; ?>

	</div>
	<?php
};

/**
 * Resolve an ACF image field (id) to a URL, falling back to $default.
 */
$iga_about_image_url = static function ( $image_id, $default = '' ) {
	if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
		$url = wp_get_attachment_image_url( (int) $image_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return $default;
};

$iga_about_brotherhood = array(
	'eyebrow'  => get_field( 'brotherhood_eyebrow' ),
	'title'    => get_field( 'brotherhood_title' ),
	'subtitle' => get_field( 'brotherhood_subtitle' ),
	'image'    => $iga_about_image_url( get_field( 'brotherhood_image' ), $iga_about_media['brotherhood'] ),
);

$iga_about_brotherhood['eyebrow']  = $iga_about_brotherhood['eyebrow'] ?: 'What We Stand For';
$iga_about_brotherhood['title']    = $iga_about_brotherhood['title'] ?: 'Our Core Values';
$iga_about_brotherhood['subtitle'] = $iga_about_brotherhood['subtitle'] ?: '';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about-brotherhood overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Brotherhood image -->
	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[1280px]">

			<?php
			$iga_about_section_header(
				$iga_about_brotherhood['eyebrow'],
				$iga_about_brotherhood['title'],
				$iga_about_brotherhood['subtitle']
			);
			?>

			<?php
			$iga_about_placeholder(
				'Brotherhood Group Shot',
				'aspect-[21/9]',
				$iga_about_brotherhood['image']
			);
			?>

		</div>
	</section>
</div>
