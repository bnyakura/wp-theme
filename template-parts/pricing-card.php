<?php
/**
 * Pricing card — one tier (mirrors the React PricingCard component).
 *
 * Args via get_template_part():
 *   tier  (array)  rank/sub/price/cadence/desc/features/cta_label/cta_action/
 *                  cta_href/primary/badge
 *   delay (int)    reveal transition-delay in ms (i * 80)
 *
 * @package IGA
 */

$tier     = $args['tier'] ?? [];
$delay    = (int) ( $args['delay'] ?? 0 );
$primary  = ! empty( $tier['primary'] );
$features = $tier['features'] ?? [];

$card_variant = $primary
	? 'border-[rgba(58,125,68,0.35)] bg-[linear-gradient(160deg,rgba(58,125,68,0.1)_0%,#141414_50%)] hover:border-green-l'
	: 'border-line bg-s1 hover:border-line-strong';

$cta_classes = 'mt-auto inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border px-[26px] py-[11px] font-sans text-[0.85rem] font-bold uppercase tracking-[1px] no-underline transition-all duration-[250ms] '
	. ( $primary
		? 'border-transparent bg-green text-white hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]'
		: 'border-line-strong bg-transparent text-off hover:border-white/[0.32] hover:bg-white/[0.05]' );

$cta_url = ( ! empty( $tier['cta_href'] ) && 0 === strpos( $tier['cta_href'], '/' ) )
	? home_url( $tier['cta_href'] )
	: ( $tier['cta_href'] ?? '' );
?>

<!-- Reveal wrapper (staggered) — keeps reveal transform separate from the hover lift -->
<div
	data-reveal
	class="translate-y-6 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
	style="transition-delay: <?php echo (int) $delay; ?>ms;"
>
	<article class="relative flex h-full flex-col rounded-[18px] border px-[28px] py-9 transition-all duration-[250ms] hover:-translate-y-1 <?php echo esc_attr( $card_variant ); ?>">

		<?php if ( ! empty( $tier['badge'] ) ) : ?>
			<div class="absolute left-1/2 top-[-1px] -translate-x-1/2 rounded-b-[10px] bg-green px-4 py-1 text-[0.62rem] font-bold uppercase tracking-[1.5px] text-white">
				<?php echo esc_html( $tier['badge'] ); ?>
			</div>
		<?php endif; ?>

		<div class="mb-4">
			<?php if ( ! empty( $tier['sub'] ) ) : ?>
				<div class="mb-1.5 text-[0.6rem] font-bold uppercase tracking-[2px] <?php echo $primary ? 'text-green-l' : 'text-muted'; ?>">
					<?php echo esc_html( $tier['sub'] ); ?>
				</div>
			<?php endif; ?>
			<h3 class="font-display text-[1.9rem] leading-none tracking-[1px] text-white">
				<?php echo esc_html( $tier['rank'] ?? '' ); ?>
			</h3>
		</div>

		<div class="mb-[14px]">
			<span class="font-display text-[2.6rem] tracking-[1px] <?php echo $primary ? 'text-green-l' : 'text-white'; ?>">
				<?php echo esc_html( $tier['price'] ?? '' ); ?>
			</span>
			<?php if ( ! empty( $tier['cadence'] ) ) : ?>
				<span class="ml-1.5 text-[0.78rem] text-muted"><?php echo esc_html( $tier['cadence'] ); ?></span>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $tier['desc'] ) ) : ?>
			<p class="mb-5 text-[0.85rem] leading-[1.65] text-muted">
				<?php echo esc_html( $tier['desc'] ); ?>
			</p>
		<?php endif; ?>

		<?php if ( ! empty( $features ) ) : ?>
			<ul class="mb-6 flex list-none flex-col gap-[9px]">
				<?php foreach ( $features as $feature ) : ?>
					<li class="flex items-start gap-2.5 text-[0.83rem] text-muted-l">
						<i class="fa-solid fa-check mt-1 shrink-0 text-[0.65rem] <?php echo $primary ? 'text-green-l' : 'text-muted'; ?>" aria-hidden="true"></i>
						<?php echo esc_html( $feature ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( ! empty( $tier['cta_label'] ) ) : ?>
			<?php if ( 'link' === ( $tier['cta_action'] ?? 'link' ) && $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" class="<?php echo esc_attr( $cta_classes ); ?>">
					<?php echo esc_html( $tier['cta_label'] ); ?>
					<i class="fa-solid fa-arrow-right shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<button type="button" data-modal-open="<?php echo esc_attr( $tier['cta_action'] ); ?>" class="<?php echo esc_attr( $cta_classes ); ?>">
					<?php echo esc_html( $tier['cta_label'] ); ?>
					<i class="fa-solid fa-arrow-right shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
				</button>
			<?php endif; ?>
		<?php endif; ?>

	</article>
</div>
