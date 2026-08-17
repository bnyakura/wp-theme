<?php
/**
 * About — Origin Story block — render template.
 *
 * @package Iron_Gorilla
 */

/**
 * Set origin to an image URL to replace its placeholder.
 */
$iga_about_media = apply_filters(
	'iga_about_media',
	array(
		'origin' => '',
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

$iga_about_story = array(
	'eyebrow' => get_field( 'origin_eyebrow' ),
	'title'   => get_field( 'origin_title' ),
	'image'   => $iga_about_image_url( get_field( 'origin_image' ), $iga_about_media['origin'] ),
);

$iga_about_story['eyebrow'] = $iga_about_story['eyebrow'] ?: 'The Origin';
$iga_about_story['title']   = $iga_about_story['title'] ?: 'How The Army Was Born';

$iga_about_story['paragraphs'] = array();
$iga_origin_paragraphs_acf     = get_field( 'origin_paragraphs' );
if ( is_array( $iga_origin_paragraphs_acf ) && ! empty( $iga_origin_paragraphs_acf ) ) {
	foreach ( $iga_origin_paragraphs_acf as $iga_paragraph_row ) {
		if ( empty( $iga_paragraph_row['paragraph'] ) ) {
			continue;
		}
		$iga_about_story['paragraphs'][] = $iga_paragraph_row['paragraph'];
	}
}

if ( empty( $iga_about_story['paragraphs'] ) ) {
	$iga_about_story['paragraphs'] = array(
		"Iron Gorilla didn't start with a business plan. It started with a friendship.",
		'Paul and Rhema met as friends and colleagues — two men from different worlds who found common ground in the relentless pursuit of physical excellence. What started as early morning gym sessions slowly became something neither of them could ignore. The floor became a boardroom. The barbells became mirrors. And somewhere in the silence between sets, a vision took shape.',
		'They called it a sacred space — a place where iron genuinely sharpened iron. Not just the body, but the character, the purpose, the brotherhood. The gym sessions became a proving ground. Accountability replaced excuses. And the seed of something bigger was planted.',
		'The vision crystallised when they met Bongi at a community camp. Looking around at the men who showed up — hungry for structure, starved of direction — the need was undeniable. This was not just about training. It was about building something that could carry men forward.',
		'Othniel joined the mission. Then Junior. Each one arriving with exactly what the army needed. From Salt River, Cape Town — Iron Gorilla Army was born. Not as a gym. As a movement.',
	);
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about-origin overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Origin story -->
	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-3xl">

			<?php
			$iga_about_section_header(
				$iga_about_story['eyebrow'],
				$iga_about_story['title']
			);
			?>

			<div class="space-y-6 text-[1.05rem] leading-8 text-white/65">

				<?php foreach ( $iga_about_story['paragraphs'] as $paragraph ) : ?>

					<p><?php echo esc_html( $paragraph ); ?></p>

				<?php endforeach; ?>

			</div>

			<div class="mt-12">
				<?php
				$iga_about_placeholder(
					'The Forge — Gym Interior',
					'aspect-[16/7]',
					$iga_about_story['image']
				);
				?>
			</div>

		</div>
	</section>
</div>
