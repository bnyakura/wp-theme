<?php
/**
 * Pricing section — tabbed "Choose Your Rank" grid.
 *
 * Tiers come from Dashboard → Pricing Tiers (defaults until added); header
 * text from Appearance → Customize → Pricing Section. Tab switching is handled
 * by assets/js/pricing-tabs.js. Header args and the starting tab can be
 * overridden per placement:
 *
 *   get_template_part( 'template-parts/Pricing', null, [
 *       'eyebrow'    => 'Drop-In',
 *       'title'      => 'Book a Session',
 *       'forced_tab' => 'dropin',   // 'monthly' | 'dropin'
 *   ] );
 *
 * @package IGA
 */

$header = iga_get_pricing_header();
$tiers  = iga_get_pricing_tiers();

foreach ( [ 'eyebrow', 'title', 'subtitle' ] as $key ) {
	if ( ! empty( $args[ $key ] ) ) {
		$header[ $key ] = $args[ $key ];
	}
}

$forced = $args['forced_tab'] ?? '';
$active = in_array( $forced, [ 'monthly', 'dropin' ], true ) ? $forced : 'monthly';

$tab_classes = 'inline-flex cursor-pointer items-center gap-2 rounded-full border-0 bg-transparent px-[14px] py-[9px] font-sans text-[0.7rem] font-bold uppercase tracking-[0.5px] text-muted transition-all duration-[250ms] min-[481px]:px-[28px] min-[481px]:py-[10px] min-[481px]:text-[0.8rem] min-[481px]:tracking-[1px] [&.is-active]:bg-green [&.is-active]:text-white [&.is-active]:shadow-[0_4px_16px_rgba(58,125,68,0.3)] [&:not(.is-active):hover]:text-muted-l';

$note_button = 'cursor-pointer border-none bg-transparent p-0 text-[0.83rem] font-bold text-green-l';
?>

<section
	id="pricing"
	data-reveal
	class="translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
>
	<div class="mx-auto max-w-[1100px]" data-pricing-tabs>

		<?php get_template_part( 'template-parts/section-header', null, $header ); ?>

		<!-- Tab toggle -->
		<div class="mb-12 flex justify-center">
			<div class="inline-flex gap-1 rounded-full border border-line bg-s1 p-[5px]">
				<button type="button" data-pricing-tab="monthly" class="<?php echo esc_attr( $tab_classes ); ?> <?php echo 'monthly' === $active ? 'is-active' : ''; ?>">
					<i class="fa-solid fa-calendar-days shrink-0 text-[0.85em]" aria-hidden="true"></i>
					<?php esc_html_e( 'Monthly Memberships', 'iga' ); ?>
				</button>
				<button type="button" data-pricing-tab="dropin" class="<?php echo esc_attr( $tab_classes ); ?> <?php echo 'dropin' === $active ? 'is-active' : ''; ?>">
					<i class="fa-solid fa-bolt shrink-0 text-[0.85em]" aria-hidden="true"></i>
					<?php esc_html_e( 'Drop-In Sessions', 'iga' ); ?>
				</button>
			</div>
		</div>

		<!-- Monthly panel -->
		<div data-pricing-panel="monthly" class="hidden [&.is-active]:block <?php echo 'monthly' === $active ? 'is-active' : ''; ?>">
			<?php if ( ! empty( $tiers['monthly'] ) ) : ?>
				<div class="grid grid-cols-[repeat(auto-fill,minmax(min(280px,100%),1fr))] gap-5">
					<?php foreach ( $tiers['monthly'] as $i => $tier ) : ?>
						<?php get_template_part( 'template-parts/pricing-card', null, [ 'tier' => $tier, 'delay' => $i * 80 ] ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="mx-auto mt-8 max-w-[580px] rounded-[18px] border border-line bg-s1 px-6 py-[18px] text-center">
				<p class="text-[0.83rem] leading-[1.7] text-muted">
					<strong class="text-muted-l"><?php esc_html_e( 'Not ready to commit?', 'iga' ); ?></strong>
					<?php esc_html_e( 'Try a drop-in first — no obligation, just show up and train.', 'iga' ); ?>
					<button type="button" data-pricing-goto="dropin" class="<?php echo esc_attr( $note_button ); ?>">
						<?php esc_html_e( 'See Drop-In options →', 'iga' ); ?>
					</button>
				</p>
			</div>
		</div>

		<!-- Drop-in panel -->
		<div data-pricing-panel="dropin" class="hidden [&.is-active]:block <?php echo 'dropin' === $active ? 'is-active' : ''; ?>">
			<?php if ( ! empty( $tiers['dropin'] ) ) : ?>
				<div class="mx-auto grid max-w-[680px] grid-cols-1 items-start gap-5 min-[481px]:grid-cols-2">
					<?php foreach ( $tiers['dropin'] as $i => $tier ) : ?>
						<?php get_template_part( 'template-parts/pricing-card', null, [ 'tier' => $tier, 'delay' => $i * 80 ] ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="mx-auto mt-8 max-w-[580px] rounded-[18px] border border-line bg-s1 px-6 py-[18px] text-center">
				<p class="text-[0.83rem] leading-[1.7] text-muted">
					<strong class="text-muted-l"><?php esc_html_e( 'Train regularly?', 'iga' ); ?></strong>
					<?php esc_html_e( 'A monthly membership works out far cheaper.', 'iga' ); ?>
					<button type="button" data-pricing-goto="monthly" class="<?php echo esc_attr( $note_button ); ?>">
						<?php esc_html_e( 'See Monthly plans →', 'iga' ); ?>
					</button>
				</p>
			</div>
		</div>

	</div>
</section>
