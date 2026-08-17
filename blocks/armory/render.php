<?php
/**
 * Armory block — render template.
 *
 * Reads ACF fields and falls back to the original Iron Gorilla content, so
 * the page looks complete the moment the theme is activated.
 *
 * @package Iron_Gorilla
 */

$iga_theme_uri = get_stylesheet_directory_uri();

/**
 * Filter these URLs if your theme keeps images or videos elsewhere.
 */
$iga_armory_media = apply_filters(
	'iga_armory_media',
	array(
		'poster' => $iga_theme_uri . '/assets/images/forge-gym.png',
		'video'  => $iga_theme_uri . '/assets/videos/iga-apparel.mp4',
	)
);

$iga_armory_urls = array(
	'early_access' => add_query_arg(
		array(
			'subject' => 'armory-early-access',
		),
		home_url( '/contact/' )
	),
	'memberships'  => home_url( '/training/' ) . '#pricing',
);

/* Inline SVG icons keep this block independent of icon plugins. */
$iga_armory_icon = static function ( $name, $classes = 'h-5 w-5' ) {
	$paths = array(
		'bell'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.86 17.08a23.85 23.85 0 0 0 5.45-1.31A8.97 8.97 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.97 8.97 0 0 1-2.31 6.02c1.75.58 3.58 1.02 5.45 1.31m5.72 0a24.3 24.3 0 0 1-5.72 0m5.72 0a3 3 0 1 1-5.72 0"/>',
		'medal' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'arrow' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

$iga_armory_hero = array(
	'eyebrow'    => get_field( 'hero_eyebrow' ),
	'title_1'    => get_field( 'hero_title_line_1' ),
	'title_2'    => get_field( 'hero_title_accent' ),
	'subtitle'   => get_field( 'hero_subtitle' ),
	'poster'     => get_field( 'hero_poster' ),
	'video'      => get_field( 'hero_video' ),
	'cta_1'      => get_field( 'early_access_label' ),
	'cta_2'      => get_field( 'memberships_label' ),
);

$iga_armory_hero['eyebrow']  = $iga_armory_hero['eyebrow'] ?: 'The Armory';
$iga_armory_hero['title_1']  = $iga_armory_hero['title_1'] ?: 'Gear For';
$iga_armory_hero['title_2']  = $iga_armory_hero['title_2'] ?: 'The Grind';
$iga_armory_hero['subtitle'] = $iga_armory_hero['subtitle'] ?: 'IGA supplements and apparel built for those who train with purpose. No filler. No noise. Just the kit you need to show up and perform.';
$iga_armory_hero['cta_1']    = $iga_armory_hero['cta_1'] ?: 'Get Early Access';
$iga_armory_hero['cta_2']    = $iga_armory_hero['cta_2'] ?: 'View Memberships';

if ( ! empty( $iga_armory_hero['poster'] ) && is_numeric( $iga_armory_hero['poster'] ) ) {
	$poster_url = wp_get_attachment_image_url( (int) $iga_armory_hero['poster'], 'full' );
	$iga_armory_hero['poster'] = $poster_url ? $poster_url : $iga_armory_media['poster'];
} else {
	$iga_armory_hero['poster'] = $iga_armory_media['poster'];
}

if ( empty( $iga_armory_hero['video'] ) ) {
	$iga_armory_hero['video'] = $iga_armory_media['video'];
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-armory overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Armory hero -->
	<section class="relative flex h-[90vh] min-h-140 items-center overflow-hidden">

		<!-- Background video -->
		<video
			class="absolute inset-0 h-full w-full object-cover object-center"
			poster="<?php echo esc_url( $iga_armory_hero['poster'] ); ?>"
			autoplay
			muted
			loop
			playsinline
			preload="metadata"
			aria-label="Iron Gorilla Army apparel"
		>
			<source
				src="<?php echo esc_url( $iga_armory_hero['video'] ); ?>"
				type="video/mp4"
			>
		</video>

		<!-- Video overlays -->
		<div
			class="absolute inset-0 bg-gradient-to-r from-ink from-[38%] via-ink/80 to-ink/20"
		></div>

		<div
			class="absolute inset-0 bg-gradient-to-t from-ink/65 via-transparent to-ink/20"
		></div>

		<!-- Hero content -->
		<div class="relative z-10 mx-auto w-full max-w-[1440px] px-[clamp(24px,5vw,80px)] py-24">
			<div class="max-w-2xl">

				<!-- Eyebrow -->
				<div class="mb-5 flex items-center gap-3">
					<span class="h-px w-10 bg-green"></span>

					<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l">
						<?php echo esc_html( $iga_armory_hero['eyebrow'] ); ?>
					</span>
				</div>

				<!-- Heading -->
				<h1 class="font-display text-[clamp(3rem,7vw,6rem)] uppercase leading-[0.9] tracking-[0.035em] text-white">
					<?php echo esc_html( $iga_armory_hero['title_1'] ); ?><br>
					<span class="text-green-l"><?php echo esc_html( $iga_armory_hero['title_2'] ); ?></span>
				</h1>

				<!-- Description -->
				<p class="mt-6 max-w-md text-base leading-7 text-white/55">
					<?php echo esc_html( $iga_armory_hero['subtitle'] ); ?>
				</p>

				<!-- CTA buttons -->
				<div class="mt-8 flex flex-wrap gap-3">

					<a
						href="<?php echo esc_url( $iga_armory_urls['early_access'] ); ?>"
						class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]"
					>
						<?php
						echo $iga_armory_icon( 'bell', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>

						<?php echo esc_html( $iga_armory_hero['cta_1'] ); ?>
					</a>

					<a
						href="<?php echo esc_url( $iga_armory_urls['memberships'] ); ?>"
						class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/20 bg-black/10 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white backdrop-blur-sm transition duration-300 hover:border-white/35 hover:bg-line"
					>
						<?php
						echo $iga_armory_icon( 'medal', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>

						<?php echo esc_html( $iga_armory_hero['cta_2'] ); ?>
					</a>

				</div>

			</div>
		</div>
	</section>
</div>
