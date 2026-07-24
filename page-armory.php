<?php
/**
 * Template Name: Armory
 * Template Post Type: page
 *
 * Tailwind WordPress version of the Iron Gorilla Army /armory page.
 *
 * Expected media locations inside the active theme:
 *   /assets/images/forge-gym.png
 *   /assets/videos/iga-apparel.mp4
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style(
	'iga-armory-fonts',
	'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
	array(),
	null
);

get_header();

// Works for both regular themes and child themes.
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

/* Inline SVG icons keep this template independent of icon plugins. */
$iga_armory_icon = static function ( $name, $classes = 'h-5 w-5' ) {
	$paths = array(
		'bell'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.86 17.08a23.85 23.85 0 0 0 5.45-1.31A8.97 8.97 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.97 8.97 0 0 1-2.31 6.02c1.75.58 3.58 1.02 5.45 1.31m5.72 0a24.3 24.3 0 0 1-5.72 0m5.72 0a3 3 0 1 1-5.72 0"/>',
		'medal' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'clock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',
		'arrow' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};
?>

<main
	id="primary"
	class="overflow-hidden bg-[#0A0A0A] font-['DM_Sans'] text-[#F2F2F2] antialiased"
>
	<!-- Armory hero -->
	<section class="relative flex min-h-[560px] items-center overflow-hidden lg:h-[90vh]">

		<!-- Background video -->
		<video
			class="absolute inset-0 h-full w-full object-cover object-center"
			poster="<?php echo esc_url( $iga_armory_media['poster'] ); ?>"
			autoplay
			muted
			loop
			playsinline
			preload="metadata"
			aria-label="Iron Gorilla Army apparel"
		>
			<source
				src="<?php echo esc_url( $iga_armory_media['video'] ); ?>"
				type="video/mp4"
			>
		</video>

		<!-- Video overlays -->
		<div
			class="absolute inset-0 bg-gradient-to-r from-[#0A0A0A] from-[38%] via-[#0A0A0A]/80 to-[#0A0A0A]/20"
		></div>

		<div
			class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A]/65 via-transparent to-[#0A0A0A]/20"
		></div>

		<!-- Hero content -->
		<div class="relative z-10 mx-auto w-full max-w-[1440px] px-6 py-24 sm:px-10 lg:px-20 xl:px-28">
			<div class="max-w-2xl">

				<!-- Eyebrow -->
				<div class="mb-5 flex items-center gap-3">
					<span class="h-px w-10 bg-[#3A7D44]"></span>

					<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]">
						The Armory
					</span>
				</div>

				<!-- Heading -->
				<h1 class="font-['Bebas_Neue'] text-6xl uppercase leading-[0.9] tracking-[0.035em] text-white sm:text-7xl lg:text-8xl xl:text-[6rem]">
					Gear For<br>
					<span class="text-[#4E9E5A]">The Grind</span>
				</h1>

				<!-- Description -->
				<p class="mt-6 max-w-md text-sm leading-7 text-white/55 sm:text-base">
					IGA supplements and apparel built for those who train with purpose.
					No filler. No noise. Just the kit you need to show up and perform.
				</p>

				<!-- CTA buttons -->
				<div class="mt-8 flex flex-wrap gap-3">

					<a
						href="<?php echo esc_url( $iga_armory_urls['early_access'] ); ?>"
						class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#3A7D44] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:-translate-y-0.5 hover:bg-[#4E9E5A] hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]"
					>
						<?php
						echo $iga_armory_icon(
							'bell',
							'h-5 w-5'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>

						Get Early Access
					</a>

					<a
						href="<?php echo esc_url( $iga_armory_urls['memberships'] ); ?>"
						class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/20 bg-black/10 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white backdrop-blur-sm transition duration-300 hover:border-white/35 hover:bg-white/[0.07]"
					>
						<?php
						echo $iga_armory_icon(
							'medal',
							'h-5 w-5'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>

						View Memberships
					</a>

				</div>

				<!-- Coming soon badge -->
				<div class="mt-5 inline-flex items-center gap-2 rounded-full border border-[#C47B2B]/30 bg-[#C47B2B]/10 px-4 py-2">

					<span class="text-[#C47B2B]">
						<?php
						echo $iga_armory_icon(
							'clock',
							'h-4 w-4'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</span>

					<span class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#C47B2B] sm:text-xs">
						Online Shop — Coming Soon
					</span>

				</div>

			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>