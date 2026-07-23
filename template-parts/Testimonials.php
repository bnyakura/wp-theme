<?php
/**
 * Testimonials section — member quote cards.
 *
 * Testimonials come from Dashboard → Testimonials (defaults until added);
 * header text from Appearance → Customize → Testimonials Section. Cards have
 * no hover transform, so the reveal classes sit directly on the card with a
 * per-index inline delay (i * 100ms), matching the React stagger.
 *
 * @package IGA
 */

$header       = iga_get_testimonials_header();
$testimonials = iga_get_testimonials();

if ( empty( $testimonials ) ) {
	return;
}

// Matches the original cascade: 1 col ≤480px, 2 cols 481–768px, 1 col 769–1080px, 3 cols above.
$grid_classes = 'mt-10 grid grid-cols-1 gap-3 min-[768px]:grid-cols-1 min-[481px]:grid-cols-2 min-[769px]:gap-4 min-[1081px]:grid-cols-3';
?>

<section
	id="testimonials"
	data-reveal
	class="translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
>
	<?php get_template_part( 'template-parts/section-header', null, $header ); ?>

	<div class="<?php echo esc_attr( $grid_classes ); ?>">
		<?php foreach ( $testimonials as $i => $t ) : ?>
			<div
				data-reveal
				class="translate-y-6 rounded-[18px] border border-line bg-s1 px-[30px] py-[35px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
				style="transition-delay: <?php echo esc_attr( (string) ( $i * 100 ) ); ?>ms;"
			>
				<div class="mb-[18px]">
					<i class="fa-solid fa-quote-left text-[1.4rem] text-green-l opacity-50" aria-hidden="true"></i>
				</div>

				<p class="mb-[22px] text-[0.92rem] italic leading-[1.8] text-muted-l">
					&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;
				</p>

				<div class="flex flex-wrap items-center justify-between gap-3 border-t border-line pt-4">
					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-line-strong bg-s3 font-display text-[1.1rem] tracking-[1px] text-white">
							<?php echo esc_html( $t['initials'] ); ?>
						</div>
						<div>
							<div class="text-[0.9rem] font-bold text-white">
								<?php echo esc_html( $t['name'] ); ?>
							</div>
							<?php if ( ! empty( $t['location'] ) ) : ?>
								<div class="mt-[1px] text-[0.8rem] uppercase tracking-[1px] text-muted">
									<?php echo esc_html( $t['location'] ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( ! empty( $t['result'] ) ) : ?>
						<span class="whitespace-nowrap rounded-full border border-[rgba(58,125,68,0.35)] bg-[rgba(58,125,68,0.15)] px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-[1.2px] text-green-l">
							<?php echo esc_html( $t['result'] ); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
