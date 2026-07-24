<?php
/**
 * Template Name: League of Legends
 * Template Post Type: page
 *
 * Tailwind WordPress version of the Iron Gorilla Army /league page.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style(
	'iga-league-fonts',
	'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
	array(),
	null
);

get_header();

$iga_league_contact_url = add_query_arg(
	'subject',
	'league-of-legends',
	home_url( '/contact/' )
);

/**
 * Inline SVG icons keep the page independent of icon plugins.
 */
$iga_league_icon = static function (
	$name,
	$classes = 'h-5 w-5'
) {
	$paths = array(
		'clock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',

		'bank' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5h18M4.5 9V7.5L12 3l7.5 4.5V9M5.25 10.5v7.5m4.5-7.5v7.5m4.5-7.5v7.5m4.5-7.5v7.5M3 21h18M3.75 18h16.5"/>',

		'arrow' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
	);

	$path = isset( $paths[ $name ] )
		? $paths[ $name ]
		: $paths['arrow'];

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
	<!-- Coming soon banner -->
	<div class="flex items-center justify-center gap-2.5 border-b border-[#C47B2B]/25 bg-[#C47B2B]/10 px-6 py-3 text-center">

		<span class="shrink-0 text-[#C47B2B]">
			<?php
			echo $iga_league_icon(
				'clock',
				'h-4 w-4'
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</span>

		<p class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#C47B2B] sm:text-xs">
			League of Legends — Coming Soon · Full launch with the online store
		</p>

	</div>

	<!-- League hero -->
	<section class="relative flex min-h-[620px] items-center border-b border-white/[0.07] bg-gradient-to-b from-[#0A0A0A] to-[#111111] px-6 py-20 text-center sm:px-10 lg:px-20 lg:py-28 xl:px-28">

		<!-- Decorative background -->
		<div
			class="pointer-events-none absolute inset-0 overflow-hidden"
			aria-hidden="true"
		>
			<div class="absolute left-1/2 top-1/2 h-[480px] w-[480px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#3A7D44]/[0.06] blur-3xl"></div>

			<div class="absolute left-1/2 top-1/2 h-[300px] w-[300px] -translate-x-1/2 -translate-y-1/2 rounded-full border border-[#3A7D44]/10"></div>
		</div>

		<div class="relative z-10 mx-auto w-full max-w-3xl">

			<!-- Eyebrow -->
			<div class="mb-5 flex items-center justify-center gap-3">

				<span class="h-px w-10 bg-[#3A7D44]"></span>

				<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]">
					Honour Roll
				</span>

				<span class="h-px w-10 bg-[#3A7D44]"></span>

			</div>

			<!-- Heading -->
			<h1 class="font-['Bebas_Neue'] text-6xl uppercase leading-[0.9] tracking-[0.04em] text-white sm:text-7xl lg:text-8xl">
				League of<br>
				<span class="text-[#4E9E5A]">
					Legends
				</span>
			</h1>

			<!-- Introduction -->
			<p class="mx-auto mt-6 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">
				Every name on this wall chose to invest in something bigger than
				themselves. They backed the mission, funded the brotherhood, and
				made Iron Gorilla Army possible.
			</p>

			<!-- Bank transfer card -->
			<div class="mx-auto mt-10 max-w-md rounded-xl border border-[#3A7D44] bg-[#141414] p-6 text-left shadow-[0_20px_60px_rgba(0,0,0,0.35)] sm:px-7">

				<div class="mb-4 flex items-center gap-3">

					<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-[#3A7D44]/40 bg-[#3A7D44]/10 text-[#4E9E5A]">
						<?php
						echo $iga_league_icon(
							'bank',
							'h-5 w-5'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</span>

					<p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#4E9E5A]">
						Bank Transfer
					</p>

				</div>

				<p class="text-base text-white/70">
					<strong class="font-semibold text-white">
						Iron Gorilla Army
					</strong>
				</p>

				<p class="mt-1 text-sm text-white/40">
					Reference:
					<span class="text-white/70">
						LEAGUE + Your Name
					</span>
				</p>

				<p class="mt-4 border-t border-white/[0.07] pt-4 text-xs leading-6 text-white/30">
					Bank details shared on request —

					<a
						href="<?php echo esc_url( $iga_league_contact_url ); ?>"
						class="inline-flex items-center gap-1 font-semibold text-[#4E9E5A] transition hover:text-white"
					>
						reach out here

						<?php
						echo $iga_league_icon(
							'arrow',
							'h-3.5 w-3.5'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</a>
				</p>

			</div>

		</div>
	</section>
</main>

<?php get_footer(); ?>