<?php
/**
 * About — Hero block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_about_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title'    => get_field( 'hero_title' ),
	'subtitle' => get_field( 'hero_subtitle' ),
);

$iga_about_hero['eyebrow']  = $iga_about_hero['eyebrow'] ?: 'Our Story';
$iga_about_hero['title']    = $iga_about_hero['title'] ?: 'Who We Are';
$iga_about_hero['subtitle'] = $iga_about_hero['subtitle'] ?: 'Iron Gorilla Army is more than a gym. It is a movement built around the belief that real strength is forged — through iron, faith, and community.';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about-hero overflow-hidden bg-ink font-sans text-off antialiased',
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
					<?php echo esc_html( $iga_about_hero['eyebrow'] ); ?>
				</span>

				<span class="h-px w-10 bg-green"></span>
			</div>

			<h1 class="font-display text-5xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl">
				<?php echo esc_html( $iga_about_hero['title'] ); ?>
			</h1>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $iga_about_hero['subtitle'] ); ?>
			</p>

		</div>
	</section>
</div>
