<?php
/**
 * FAQ — Hero block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_faq_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title'    => get_field( 'hero_title' ),
	'subtitle' => get_field( 'hero_subtitle' ),
);

$iga_faq_hero['eyebrow']  = $iga_faq_hero['eyebrow'] ?: 'Questions';
$iga_faq_hero['title']    = $iga_faq_hero['title'] ?: 'Is This For You?';
$iga_faq_hero['subtitle'] = $iga_faq_hero['subtitle'] ?: "Straight answers. No fluff. If your question isn't here, send a dispatch and we'll respond within 24 hours.";

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-faq-hero overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Page hero -->
	<section class="border-b border-line bg-s1 px-4.5 pb-12 pt-15 text-center min-[481px]:px-[5vw] min-[481px]:pb-16 min-[481px]:pt-20">
		<div class="mx-auto max-w-3xl">

			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-green"></span>

				<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l">
					<?php echo esc_html( $iga_faq_hero['eyebrow'] ); ?>
				</span>

				<span class="h-px w-10 bg-green"></span>
			</div>

			<h1 class="font-display text-5xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl">
				<?php echo esc_html( $iga_faq_hero['title'] ); ?>
			</h1>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $iga_faq_hero['subtitle'] ); ?>
			</p>

		</div>
	</section>
</div>
