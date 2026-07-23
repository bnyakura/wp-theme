<?php
/**
 * Forge section — "Built on Three Pillars".
 *
 * Pillar cards come from Dashboard → Forge Pillars (defaults until added);
 * header text from Appearance → Customize → Forge Section. The Enlist button
 * uses the shared data-modal-open wiring.
 *
 * @package IGA
 */

$header  = iga_get_forge_header();
$pillars = iga_get_forge_pillars();

if ( empty( $pillars ) ) {
	return;
}
?>

<section
	id="forge"
	data-reveal
	class="translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
>
	<div class="mx-auto max-w-[1100px]">

		<?php
		get_template_part(
			'template-parts/section-header',
			null,
			[
				'eyebrow'  => $header['eyebrow'],
				'title'    => $header['title'],
				'subtitle' => $header['subtitle'],
			]
		);
		?>

		<div class="grid grid-cols-[repeat(auto-fit,minmax(min(260px,100%),1fr))] gap-5">
			<?php foreach ( $pillars as $i => $pillar ) : ?>
				<!-- Reveal wrapper (staggered) — keeps the reveal transform separate from the card hover-lift -->
				<div
					data-reveal
					class="translate-y-6 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
					style="transition-delay: <?php echo esc_attr( (string) ( $i * 100 ) ); ?>ms;"
				>
					<article class="relative flex h-full flex-row items-start gap-4 overflow-hidden rounded-[18px] border border-line bg-s2 px-[30px] py-10 transition-all duration-700 after:absolute after:bottom-0 after:left-0 after:right-0 after:h-[3px] after:origin-left after:scale-x-0 after:bg-green after:transition-transform after:duration-[400ms] after:content-[''] hover:-translate-y-1.5 hover:border-line-strong hover:after:scale-x-100 min-[601px]:flex-col min-[601px]:gap-0">

						<div class="mt-1 flex h-[55px] w-[55px] shrink-0 items-center justify-center rounded-full border border-[rgba(58,125,68,0.35)] bg-[rgba(58,125,68,0.15)] text-[1.3rem] text-green-l min-[601px]:mt-0 min-[601px]:mb-[25px]">
							<?php if ( ! empty( $pillar['icon'] ) ) : ?>
								<i class="fa-solid <?php echo esc_attr( $pillar['icon'] ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
						</div>

						<div class="flex-1">
							<h3 class="mb-3 font-display text-[1.7rem] tracking-[2px] text-white">
								<?php echo esc_html( $pillar['title'] ); ?>
							</h3>
							<p class="leading-[1.8] text-muted">
								<?php echo esc_html( $pillar['body'] ); ?>
							</p>
						</div>

					</article>
				</div>
			<?php endforeach; ?>
		</div>

		<div
			data-reveal
			class="mt-12 flex translate-y-6 flex-wrap justify-center gap-4 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
			style="transition-delay: 300ms;"
		>
			<button
				type="button"
				data-modal-open="enlist-modal"
				class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-transparent bg-green px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]"
			>
				<i class="fa-solid fa-medal shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
				<?php esc_html_e( 'Enlist Now', 'iga' ); ?>
			</button>
			<a
				href="<?php echo esc_url( home_url( '/training/' ) ); ?>"
				class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-line-strong bg-transparent px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-off no-underline transition-all duration-[250ms] hover:border-white/[0.32] hover:bg-white/[0.05]"
			>
				<?php esc_html_e( 'Explore Programs', 'iga' ); ?>
				<i class="fa-solid fa-arrow-right shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
			</a>
		</div>

	</div>
</section>
