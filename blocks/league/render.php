<?php
/**
 * League block — render template.
 *
 * Reads ACF fields and falls back to the original Iron Gorilla content, so
 * the page looks complete the moment the theme is activated.
 *
 * @package Iron_Gorilla
 */

$iga_league_contact_url = add_query_arg(
	'subject',
	'league-of-legends',
	home_url( '/contact/' )
);

/**
 * Inline SVG icons keep the block independent of icon plugins.
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

// ACF overrides (empty fields fall back to the defaults below).
$iga_league_banner = get_field( 'banner_text' ) ?: 'League of Legends — Coming Soon · Full launch with the online store';

$iga_league_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title_1'  => get_field( 'hero_title_line_1' ),
	'title_2'  => get_field( 'hero_title_accent' ),
	'subtitle' => get_field( 'hero_subtitle' ),
);

$iga_league_hero['eyebrow']  = $iga_league_hero['eyebrow'] ?: 'Honour Roll';
$iga_league_hero['title_1']  = $iga_league_hero['title_1'] ?: 'League of';
$iga_league_hero['title_2']  = $iga_league_hero['title_2'] ?: 'Legends';
$iga_league_hero['subtitle'] = $iga_league_hero['subtitle'] ?: 'Every name on this wall chose to invest in something bigger than themselves. They backed the mission, funded the brotherhood, and made Iron Gorilla Army possible.';

$iga_league_bank = array(
	'label'          => get_field( 'bank_label' ),
	'name'           => get_field( 'bank_name' ),
	'reference_note' => get_field( 'bank_reference_note' ),
	'footnote'       => get_field( 'bank_footnote' ),
	'link_label'     => get_field( 'bank_contact_link_label' ),
);

$iga_league_bank['label']          = $iga_league_bank['label'] ?: 'Bank Transfer';
$iga_league_bank['name']           = $iga_league_bank['name'] ?: 'Iron Gorilla Army';
$iga_league_bank['reference_note'] = $iga_league_bank['reference_note'] ?: 'LEAGUE + Your Name';
$iga_league_bank['footnote']       = $iga_league_bank['footnote'] ?: 'Bank details shared on request —';
$iga_league_bank['link_label']     = $iga_league_bank['link_label'] ?: 'reach out here';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-league overflow-hidden bg-[#0A0A0A] font-[\'DM_Sans\'] text-[#F2F2F2] antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

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
			<?php echo esc_html( $iga_league_banner ); ?>
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
					<?php echo esc_html( $iga_league_hero['eyebrow'] ); ?>
				</span>

				<span class="h-px w-10 bg-[#3A7D44]"></span>

			</div>

			<!-- Heading -->
			<h1 class="font-['Bebas_Neue'] text-6xl uppercase leading-[0.9] tracking-[0.04em] text-white sm:text-7xl lg:text-8xl">
				<?php echo esc_html( $iga_league_hero['title_1'] ); ?><br>
				<span class="text-[#4E9E5A]">
					<?php echo esc_html( $iga_league_hero['title_2'] ); ?>
				</span>
			</h1>

			<!-- Introduction -->
			<p class="mx-auto mt-6 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">
				<?php echo esc_html( $iga_league_hero['subtitle'] ); ?>
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
						<?php echo esc_html( $iga_league_bank['label'] ); ?>
					</p>

				</div>

				<p class="text-base text-white/70">
					<strong class="font-semibold text-white">
						<?php echo esc_html( $iga_league_bank['name'] ); ?>
					</strong>
				</p>

				<p class="mt-1 text-sm text-white/40">
					Reference:
					<span class="text-white/70">
						<?php echo esc_html( $iga_league_bank['reference_note'] ); ?>
					</span>
				</p>

				<p class="mt-4 border-t border-white/[0.07] pt-4 text-xs leading-6 text-white/30">
					<?php echo esc_html( $iga_league_bank['footnote'] ); ?>

					<a
						href="<?php echo esc_url( $iga_league_contact_url ); ?>"
						class="inline-flex items-center gap-1 font-semibold text-[#4E9E5A] transition hover:text-white"
					>
						<?php echo esc_html( $iga_league_bank['link_label'] ); ?>

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
</div>
