<?php
/**
 * Hero slider.
 *
 * Slide content comes from Dashboard → Hero Slides (see inc/hero-slides.php),
 * falling back to built-in defaults when none exist. Autoplay speed is set in
 * Appearance → Customize → Hero Slider and passed to
 * assets/js/hero-slider.js via data-hero-interval.
 *
 * @package IGA
 */

$slides = iga_get_hero_slides();

if ( empty( $slides ) ) {
	return;
}

$interval = (int) get_theme_mod( 'iga_hero_interval', 6000 );
if ( $interval < 2000 ) {
	$interval = 2000; // Sanity floor — anything faster is unreadable.
}
?>

<section id="hero" data-hero-slider data-hero-interval="<?php echo esc_attr( (string) $interval ); ?>" class="relative h-[90vh] min-h-[560px] w-full overflow-hidden bg-[#0A0A0A]">

	<?php foreach ( $slides as $i => $slide ) : ?>
		<!-- Slide <?php echo (int) $i + 1; ?> -->
		<div
			data-hero-slide
			class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-[1100ms] ease-[ease] [&.is-active]:pointer-events-auto [&.is-active]:opacity-100 <?php echo 0 === $i ? 'is-active' : ''; ?>"
		>
			<img
				src="<?php echo esc_url( $slide['image'] ); ?>"
				alt="<?php echo esc_attr( $slide['eyebrow'] ? $slide['eyebrow'] : $slide['line_1'] ); ?>"
				class="absolute inset-0 h-full w-full object-cover object-top"
				decoding="async"
				<?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?>
			/>

			<!-- Gradient — heavy left, fades right -->
			<div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(10,10,10,0.93)_35%,rgba(10,10,10,0.3)_75%,rgba(10,10,10,0.1)_100%)]"></div>

			<!-- Content — vertically centred left -->
			<div class="absolute inset-0 flex items-center px-[clamp(24px,5vw,80px)] pb-20">
				<div class="max-w-[620px]">
					<div class="mb-5 flex items-center justify-center gap-3 before:h-px before:max-w-10 before:flex-1 before:bg-green before:content-[''] after:h-px after:max-w-10 after:flex-1 after:bg-green after:content-['']">
						<span class="text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l">
							<?php echo esc_html( $slide['eyebrow'] ); ?>
						</span>
					</div>

					<h1 class="mb-[22px] font-display text-[clamp(3.2rem,7.5vw,6.5rem)] leading-[0.92] tracking-[2px] text-white">
						<?php echo esc_html( $slide['line_1'] ); ?><br />
						<em class="not-italic text-green-l"><?php echo esc_html( $slide['line_2'] ); ?></em>
					</h1>

					<p class="mb-8 max-w-[440px] text-[1rem] leading-[1.8] text-white/[0.55]">
						<?php echo esc_html( $slide['body'] ); ?>
					</p>

					<div class="flex flex-col gap-3 min-[601px]:flex-row min-[601px]:flex-wrap">
						<a
							href="<?php echo esc_url( home_url( '/book/' ) ); ?>"
							class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border-0 bg-green px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)] min-[601px]:w-auto"
						>
							<i class="fa-regular fa-calendar-check shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
							<?php esc_html_e( 'Book Free Assessment', 'iga' ); ?>
						</a>
						<button
							type="button"
							data-modal-open="enlist-modal"
							class="group inline-flex cursor-pointer items-center justify-center gap-2 border-0 bg-transparent px-1 py-[15px] font-sans text-[0.9rem] font-semibold tracking-[0.3px] text-white/[0.6] transition-colors duration-200 hover:text-white min-[601px]:justify-start"
						>
							<?php esc_html_e( 'Enlist Now', 'iga' ); ?>
							<i class="fa-solid fa-arrow-right shrink-0 text-[0.8em] transition-transform duration-200 group-hover:translate-x-[3px]" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<!-- Arrows -->
	<button
		type="button"
		data-hero-prev
		aria-label="<?php esc_attr_e( 'Previous slide', 'iga' ); ?>"
		class="absolute left-[clamp(12px,3vw,32px)] top-1/2 z-[4] flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-white/[0.12] bg-[rgba(10,10,10,0.55)] text-[0.8rem] text-white backdrop-blur-[8px] transition-[background,border-color] duration-200 hover:border-[#3A7D44] hover:bg-[rgba(58,125,68,0.75)]"
	>
		<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
	</button>
	<button
		type="button"
		data-hero-next
		aria-label="<?php esc_attr_e( 'Next slide', 'iga' ); ?>"
		class="absolute right-[clamp(12px,3vw,32px)] top-1/2 z-[4] flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-white/[0.12] bg-[rgba(10,10,10,0.55)] text-[0.8rem] text-white backdrop-blur-[8px] transition-[background,border-color] duration-200 hover:border-[#3A7D44] hover:bg-[rgba(58,125,68,0.75)]"
	>
		<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
	</button>

	<!-- Dots -->
	<div class="absolute inset-x-0 bottom-9 z-[4] flex justify-center gap-2">
		<?php foreach ( $slides as $i => $slide ) : ?>
			<button
				type="button"
				data-hero-dot
				aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number. */ __( 'Slide %d', 'iga' ), $i + 1 ) ); ?>"
				class="h-[7px] w-[7px] cursor-pointer rounded-[4px] border-0 bg-white/[0.2] transition-all duration-[350ms] [&.is-active]:w-6 [&.is-active]:bg-green <?php echo 0 === $i ? 'is-active' : ''; ?>"
			></button>
		<?php endforeach; ?>
	</div>

	<!-- Progress bar (hidden by JS while paused) -->
	<div data-hero-progress class="absolute inset-x-0 bottom-0 z-[4] h-[3px] bg-white/[0.07]">
		<div data-hero-progress-fill class="h-full w-0 animate-slide-progress bg-green"></div>
	</div>

</section>
