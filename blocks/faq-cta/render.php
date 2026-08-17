<?php
/**
 * FAQ — Final CTA block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_faq_urls = array(
	'contact' => home_url( '/contact/' ),
	'book'    => home_url( '/book/' ),
);

/**
 * Inline SVG icons keep the block independent of icon plugins.
 */
$iga_faq_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'send'     => '<path stroke-linecap="round" stroke-linejoin="round" d="m3.75 3.75 16.5 8.25-16.5 8.25 3-8.25-3-8.25Zm3 8.25h7.5"/>',
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
	);

	$path = isset( $paths[ $name ] )
		? $paths[ $name ]
		: $paths['send'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

$iga_faq_cta = array(
	'title'    => get_field( 'cta_title' ),
	'subtitle' => get_field( 'cta_subtitle' ),
);

$iga_faq_cta['title']    = $iga_faq_cta['title'] ?: 'Still Have Questions?';
$iga_faq_cta['subtitle'] = $iga_faq_cta['subtitle'] ?: "Our team is available to answer anything not covered here. Don't overthink it — just reach out.";

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-faq-cta overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Final CTA -->
	<section class="bg-s1 px-4.5 py-15 text-center min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-3xl">

			<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
				<?php echo esc_html( $iga_faq_cta['title'] ); ?>
			</h2>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $iga_faq_cta['subtitle'] ); ?>
			</p>

			<div class="mt-8 flex flex-wrap justify-center gap-3">

				<a
					href="<?php echo esc_url( $iga_faq_urls['contact'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]"
				>
					<?php
					echo $iga_faq_icon(
						'send',
						'h-5 w-5'
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Send a Dispatch
				</a>

				<a
					href="<?php echo esc_url( $iga_faq_urls['book'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:border-white/30 hover:bg-white/5"
				>
					<?php
					echo $iga_faq_icon(
						'calendar',
						'h-5 w-5'
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Book a Drop-In Instead
				</a>

			</div>

		</div>
	</section>
</div>
