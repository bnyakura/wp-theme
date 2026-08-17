<?php
/**
 * Training — Hero block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_theme_uri = get_stylesheet_directory_uri();

$iga_training_images = apply_filters(
	'iga_training_images',
	array(
		'hero' => $iga_theme_uri . '/assets/images/forge-gym.png',
	)
);

$iga_training_urls = array(
	'book' => home_url( '/book/' ),
);

$iga_training_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
		'arrow'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
		'location' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 5.25-7.5 11.25-7.5 11.25S4.5 15.75 4.5 10.5a7.5 7.5 0 1 1 15 0Zm-5.25 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

/**
 * Resolve an ACF image field (id) to a URL, falling back to $default.
 */
$iga_training_image_url = static function ( $image_id, $default = '' ) {
	if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
		$url = wp_get_attachment_image_url( (int) $image_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return $default;
};

$iga_training_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title_1'  => get_field( 'hero_title_line_1' ),
	'accent'   => get_field( 'hero_title_accent' ),
	'title_2'  => get_field( 'hero_title_line_2' ),
	'subtitle' => get_field( 'hero_subtitle' ),
	'location' => get_field( 'hero_location' ),
	'image'    => $iga_training_image_url( get_field( 'hero_image' ), $iga_training_images['hero'] ),
);

$iga_training_hero['eyebrow']  = $iga_training_hero['eyebrow'] ?: 'The Forge · Salt River, Cape Town';
$iga_training_hero['title_1']  = $iga_training_hero['title_1'] ?: 'Forge Unbreakable';
$iga_training_hero['accent']   = $iga_training_hero['accent'] ?: 'Strength & Discipline';
$iga_training_hero['title_2']  = $iga_training_hero['title_2'] ?: 'Without the Chaos';
$iga_training_hero['subtitle'] = $iga_training_hero['subtitle'] ?: 'A results-driven coaching brotherhood. Body, mind, and spirit — trained together. Not a commercial gym. A standard.';
$iga_training_hero['location'] = $iga_training_hero['location'] ?: 'Unit 209 Salt Circle, Kent Str, Salt River, Cape Town';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training-hero overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<section class="relative flex h-[90vh] min-h-145 items-center overflow-hidden">
		<img
			src="<?php echo esc_url( $iga_training_hero['image'] ); ?>"
			alt="The Forge — Iron Gorilla Army training facility"
			class="absolute inset-0 h-full w-full object-cover object-center"
			fetchpriority="high"
		>
		<div class="absolute inset-0 bg-gradient-to-r from-ink from-[35%] via-ink/80 to-ink/20"></div>
		<div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-transparent to-transparent"></div>

		<div class="relative z-10 mx-auto w-full max-w-[1440px] px-[clamp(24px,6vw,120px)]">
			<div class="max-w-2xl">
				<div class="mb-6 flex items-center gap-3">
					<span class="h-px w-10 bg-green"></span>
					<span class="text-xs font-bold uppercase tracking-[0.2em] text-green-l"><?php echo esc_html( $iga_training_hero['eyebrow'] ); ?></span>
				</div>

				<h1 class="font-display text-5xl uppercase leading-[0.92] tracking-[0.03em] text-white sm:text-6xl lg:text-7xl xl:text-[5.5rem]">
					<?php echo esc_html( $iga_training_hero['title_1'] ); ?><br>
					<span class="text-green-l"><?php echo esc_html( $iga_training_hero['accent'] ); ?></span><br>
					<?php echo esc_html( $iga_training_hero['title_2'] ); ?>
				</h1>

				<p class="mt-6 max-w-md text-base leading-7 text-white/55">
					<?php echo esc_html( $iga_training_hero['subtitle'] ); ?>
				</p>

				<div class="mt-8 flex flex-wrap items-center gap-3">
					<a href="<?php echo esc_url( $iga_training_urls['book'] ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-7 py-3 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)] sm:px-9 sm:py-4">
						<?php echo $iga_training_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Book Free Assessment
					</a>
					<a href="#pricing" data-training-pricing-tab="monthly" class="inline-flex min-h-12 items-center gap-2 px-4 py-3 text-sm font-semibold text-white/65 transition hover:text-white">
						View Membership Plans
						<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>

				<p class="mt-7 flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-white/30">
					<span class="text-green-l"><?php echo $iga_training_icon( 'location', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php echo esc_html( $iga_training_hero['location'] ); ?>
				</p>
			</div>
		</div>
	</section>
</div>
