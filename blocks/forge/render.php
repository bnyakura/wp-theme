<?php
$eyebrow    = get_field( 'eyebrow' );
$title      = get_field( 'title' );
$subtitle   = get_field( 'subtitle' );
$pillars    = get_field( 'pillars' );
$cta_label  = get_field( 'cta_primary_label' ) ?: __( 'Join Community', 'iga' );
$cta_action = get_field( 'cta_primary_action' ) ?: 'whatsapp-group';
$cta2_label = get_field( 'cta_secondary_label' ) ?: __( 'Explore Programs', 'iga' );
$cta2_url   = get_field( 'cta_secondary_url' ) ?: home_url( '/training/' );

$eyebrow  = $eyebrow ?: 'What We Offer';
$title    = $title ?: 'Built on Three Pillars';
$subtitle = $subtitle ?: 'Every session, every program, and every coach is built around three core pillars.';

$iga_forge_default_pillars = array(
    array(
        'icon'  => 'fa-dumbbell',
        'title' => 'Movement',
        'body'  => 'Strength & Conditioning, Hybrid Group Classes, Open Studio. Every session is coach-led — movements are scaled so anyone can train.',
    ),
    array(
        'icon'  => 'fa-brain',
        'title' => 'Holistic Wellness',
        'body'  => 'Physical training is one part of the equation. We integrate mental resilience, nutrition guidance, and spiritual grounding into everything.',
    ),
    array(
        'icon'  => 'fa-users',
        'title' => 'Brotherhood',
        'body'  => 'Small squads trained under professional guidance. You belong here. You are held accountable. You do not train alone.',
    ),
);

if ( empty( $pillars ) ) {
    $pillars = $iga_forge_default_pillars;
}

if ( ! empty( $cta2_url ) && 0 === strpos( $cta2_url, '/' ) ) {
    $cta2_url = home_url( $cta2_url );
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100',
) );
?>
<section <?php echo $wrapper_attributes; ?> id="forge" data-reveal>
    <div class="mx-auto max-w-[1100px]">

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

        <div class="grid grid-cols-[repeat(auto-fit,minmax(min(260px,100%),1fr))] gap-5">
            <?php foreach ( $pillars as $i => $pillar ) : ?>
                <div data-reveal class="translate-y-6 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100" style="transition-delay: <?php echo esc_attr( (string) ( $i * 100 ) ); ?>ms;">
                    <article class="relative flex h-full flex-row items-start gap-4 overflow-hidden rounded-[18px] border border-line bg-s2 px-[30px] py-10 transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:right-0 after:h-[3px] after:origin-left after:scale-x-0 after:bg-green after:transition-transform after:duration-[400ms] after:content-[''] hover:-translate-y-1.5 hover:border-line-strong hover:after:scale-x-100 min-[601px]:flex-col min-[601px]:gap-0">

                        <div class="mt-1 flex h-[55px] w-[55px] shrink-0 items-center justify-center rounded-full border border-[rgba(58,125,68,0.35)] bg-[rgba(58,125,68,0.15)] text-[1.3rem] text-green-l min-[601px]:mt-0 min-[601px]:mb-[25px]">
                            <?php if ( ! empty( $pillar['icon'] ) ) : ?>
                                <i class="fa-solid <?php echo esc_attr( $pillar['icon'] ); ?>" aria-hidden="true"></i>
                            <?php endif; ?>
                        </div>

                        <div class="flex-1">
                            <h3 class="mb-3 font-display text-[1.7rem] tracking-[2px] text-white">
                                <?php echo esc_html( $pillar['title'] ); ?>
                            </h3>
                            <p class="text-[0.95rem] leading-[1.8] text-muted">
                                <?php echo esc_html( $pillar['body'] ); ?>
                            </p>
                        </div>

                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <div data-reveal class="mt-12 flex translate-y-6 flex-wrap justify-center gap-4 opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100" style="transition-delay: 300ms;">
            <?php if ( $cta_label ) : ?>
                <?php if ( 'link' === $cta_action && ! empty( $cta_url ) ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-transparent bg-green px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]">
                        <i class="fa-solid fa-medal shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                <?php elseif ( in_array( $cta_action, array( 'whatsapp-group', 'enlist-modal' ), true ) ) : ?>
                    <a href="<?php echo esc_url( iga_get_whatsapp_group_url() ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-transparent bg-green px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]">
                        <i class="fa-solid fa-medal shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                <?php else : ?>
                    <button type="button" data-modal-open="<?php echo esc_attr( $cta_action ); ?>" class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-transparent bg-green px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]">
                        <i class="fa-solid fa-medal shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                        <?php echo esc_html( $cta_label ); ?>
                    </button>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ( $cta2_label && $cta2_url ) : ?>
                <a href="<?php echo esc_url( $cta2_url ); ?>" class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-line-strong bg-transparent px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-off no-underline transition-all duration-[250ms] hover:border-white/[0.32] hover:bg-white/[0.05]">
                    <?php echo esc_html( $cta2_label ); ?>
                    <i class="fa-solid fa-arrow-right shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
        </div>

    </div>
</section>
