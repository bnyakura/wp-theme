<?php
/**
 * Training — Final CTA block — render template.
 *
 * @package Iron_Gorilla
 */

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

$iga_training_section_header = static function ( $eyebrow, $title, $subtitle = '' ) {
	?>
	<div class="mx-auto mb-12 max-w-3xl text-center">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-green"></span>
			<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l"><?php echo esc_html( $eyebrow ); ?></span>
			<span class="h-px w-10 bg-green"></span>
		</div>
		<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
			<?php echo esc_html( $title ); ?>
		</h2>
		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
	<?php
};

$iga_training_urls = array(
	'book'    => home_url( '/book/' ),
	'contact' => home_url( '/contact/' ),
	'faq'     => home_url( '/faq/' ),
);

$iga_training_cta = array(
	'eyebrow'  => get_field( 'cta_eyebrow' ),
	'title'    => get_field( 'cta_title' ),
	'subtitle' => get_field( 'cta_subtitle' ),
);

$iga_training_cta['eyebrow']  = $iga_training_cta['eyebrow'] ?: 'Ready?';
$iga_training_cta['title']    = $iga_training_cta['title'] ?: 'Your First Session Is Free';
$iga_training_cta['subtitle'] = $iga_training_cta['subtitle'] ?: 'Zero pressure. No commitment. Come in, meet the coaches, and see if The Forge is where you belong.';

$iga_training_hero_location = get_field( 'cta_location' ) ?: 'Unit 209 Salt Circle, Kent Str, Salt River, Cape Town';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training-cta overflow-hidden bg-s1 font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<section class="border-t border-line px-4.5 py-20 text-center min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-3xl">
			<?php
			$iga_training_section_header(
				$iga_training_cta['eyebrow'],
				$iga_training_cta['title'],
				$iga_training_cta['subtitle']
			);
			?>

			<div class="flex flex-wrap justify-center gap-3">
				<a href="<?php echo esc_url( iga_get_whatsapp_number_url( "Hi Iron Gorilla Army, I'd like to book a free assessment." ) ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
					<?php echo $iga_training_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					Book Free Assessment
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'subject', 'operations-list', $iga_training_urls['contact'] ) ); ?>" class="inline-flex min-h-12 items-center gap-2 px-4 py-3 text-sm font-semibold text-white/60 transition hover:text-white">
					Join The Operations List
					<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>

			<p class="mt-7 flex items-center justify-center gap-2 text-sm text-white/40">
				<span class="text-green-l"><?php echo $iga_training_icon( 'location', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php echo esc_html( $iga_training_hero_location ); ?>
			</p>

			<div class="mt-8 border-t border-line pt-6 text-sm text-white/40">
				Questions about membership or training?
				<a href="<?php echo esc_url( $iga_training_urls['faq'] ); ?>" class="ml-1 inline-flex items-center gap-1.5 font-bold text-green-l hover:text-white">
					Browse the FAQ
					<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>
		</div>
	</section>
</div>
