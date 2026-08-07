<?php
$eyebrow       = get_field( 'eyebrow' );
$title         = get_field( 'title' );
$subtitle      = get_field( 'subtitle' );
$monthly_tiers = get_field( 'monthly_tiers' );
$dropin_tiers  = get_field( 'dropin_tiers' );

if ( empty( $monthly_tiers ) && empty( $dropin_tiers ) ) {
    return;
}

$tab_classes = 'inline-flex cursor-pointer items-center gap-2 rounded-full border-0 bg-transparent px-[14px] py-[9px] font-sans text-[0.7rem] font-bold uppercase tracking-[0.5px] text-muted transition-all duration-[250ms] min-[481px]:px-[28px] min-[481px]:py-[10px] min-[481px]:text-[0.8rem] min-[481px]:tracking-[1px] [&.is-active]:bg-green [&.is-active]:text-white [&.is-active]:shadow-[0_4px_16px_rgba(58,125,68,0.3)] [&:not(.is-active):hover]:text-muted-l';

$note_button = 'cursor-pointer border-none bg-transparent p-0 text-[0.83rem] font-bold text-green-l';

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100',
) );
?>
<section <?php echo $wrapper_attributes; ?> id="pricing" data-reveal>
    <div class="mx-auto max-w-[1100px]" data-pricing-tabs>

        <?php if ( $eyebrow || $title || $subtitle ) : ?>
            <div class="section-header">
                <?php if ( $eyebrow ) : ?>
                    <div class="mb-[14px] flex items-center justify-center gap-3 before:h-px before:max-w-10 before:flex-1 before:bg-green before:content-[''] after:h-px after:max-w-10 after:flex-1 after:bg-green after:content-['']">
                        <span class="text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l"><?php echo esc_html( $eyebrow ); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ( $title ) : ?>
                    <h2 class="mb-4 text-center font-display text-[clamp(2rem,4vw,3.5rem)] leading-[1.05] tracking-[2px] text-white"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="mx-auto mb-12 max-w-[600px] text-center text-[1rem] leading-[1.85] text-muted"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="mb-12 flex justify-center">
            <div class="inline-flex gap-1 rounded-full border border-line bg-s1 p-[5px]">
                <button type="button" data-pricing-tab="monthly" class="<?php echo esc_attr( $tab_classes ); ?> is-active">
                    <i class="fa-solid fa-calendar-days shrink-0 text-[0.85em]" aria-hidden="true"></i>
                    <?php esc_html_e( 'Monthly Memberships', 'iga' ); ?>
                </button>
                <button type="button" data-pricing-tab="dropin" class="<?php echo esc_attr( $tab_classes ); ?>">
                    <i class="fa-solid fa-bolt shrink-0 text-[0.85em]" aria-hidden="true"></i>
                    <?php esc_html_e( 'Drop-In Sessions', 'iga' ); ?>
                </button>
            </div>
        </div>

        <div data-pricing-panel="monthly" class="is-active hidden [&.is-active]:block">
            <?php if ( $monthly_tiers ) : ?>
                <div class="grid grid-cols-[repeat(auto-fill,minmax(min(280px,100%),1fr))] gap-5">
                    <?php foreach ( $monthly_tiers as $i => $tier ) : ?>
                        <?php $delay = $i * 80; ?>
                        <div data-reveal class="translate-y-6 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100" style="transition-delay: <?php echo (int) $delay; ?>ms;">
                            <?php echo render_pricing_card( $tier ); ?>
                        </div>
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

        <div data-pricing-panel="dropin" class="hidden [&.is-active]:block">
            <?php if ( $dropin_tiers ) : ?>
                <div class="mx-auto grid max-w-[680px] grid-cols-1 items-start gap-5 min-[481px]:grid-cols-2">
                    <?php foreach ( $dropin_tiers as $i => $tier ) : ?>
                        <?php $delay = $i * 80; ?>
                        <div data-reveal class="translate-y-6 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100" style="transition-delay: <?php echo (int) $delay; ?>ms;">
                            <?php echo render_pricing_card( $tier ); ?>
                        </div>
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

<?php
/**
 * Render a single pricing card.
 */
if ( ! function_exists( 'render_pricing_card' ) ) :
function render_pricing_card( $tier ) {
    $primary  = ! empty( $tier['primary'] );
    $features_raw = $tier['features'] ?? '';
    $features = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $features_raw ) ) ) );

    $card_variant = $primary
        ? 'border-[rgba(58,125,68,0.35)] bg-[linear-gradient(160deg,rgba(58,125,68,0.1)_0%,#141414_50%)] hover:border-green-l'
        : 'border-line bg-s1 hover:border-line-strong';

    $cta_classes = 'mt-auto inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border px-[26px] py-[11px] font-sans text-[0.85rem] font-bold uppercase tracking-[1px] no-underline transition-all duration-[250ms] '
        . ( $primary
            ? 'border-transparent bg-green text-white hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]'
            : 'border-line-strong bg-transparent text-off hover:border-white/[0.32] hover:bg-white/[0.05]' );

    $cta_url = $tier['cta_url'] ?? '';
    if ( ! empty( $cta_url ) && 0 === strpos( $cta_url, '/' ) ) {
        $cta_url = home_url( $cta_url );
    }

    ob_start();
    ?>
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
            <p class="mb-5 text-[0.85rem] leading-[1.65] text-muted"><?php echo esc_html( $tier['desc'] ); ?></p>
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
                <button type="button" data-modal-open="<?php echo esc_attr( $tier['cta_action'] ?? '' ); ?>" class="<?php echo esc_attr( $cta_classes ); ?>">
                    <?php echo esc_html( $tier['cta_label'] ); ?>
                    <i class="fa-solid fa-arrow-right shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                </button>
            <?php endif; ?>
        <?php endif; ?>
    </article>
    <?php
    return ob_get_clean();
}
endif;
