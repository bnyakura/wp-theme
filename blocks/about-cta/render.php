<?php
/**
 * About — Final CTA block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_about_urls = array(
	'enlist' => add_query_arg( 'subject', 'enlist', home_url( '/contact/' ) ),
	'book'   => home_url( '/book/' ),
);

/**
 * Inline SVG icons keep the block independent of icon plugins.
 */
$iga_about_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'medal'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['medal'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

$iga_about_cta = array(
	'title'    => get_field( 'cta_title' ),
	'subtitle' => get_field( 'cta_subtitle' ),
);

$iga_about_cta['title']    = $iga_about_cta['title'] ?: 'Ready To Join The Army?';
$iga_about_cta['subtitle'] = $iga_about_cta['subtitle'] ?: 'Come see the floor. Meet the coaches. Experience the community. Your first drop-in is on us.';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about-cta overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Final CTA -->
	<section class="bg-s1 px-4.5 py-15 text-center min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-3xl">

			<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
				<?php echo esc_html( $iga_about_cta['title'] ); ?>
			</h2>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $iga_about_cta['subtitle'] ); ?>
			</p>

			<div class="mt-8 flex flex-wrap justify-center gap-3">

				<a
					href="<?php echo esc_url( $iga_about_urls['enlist'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]"
				>
					<?php
					echo $iga_about_icon( 'medal', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Enlist Today
				</a>

				<a
					href="<?php echo esc_url( $iga_about_urls['book'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:border-white/30 hover:bg-white/5"
				>
					<?php
					echo $iga_about_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Book a Drop-In
				</a>

			</div>

		</div>
	</section>
</div>
