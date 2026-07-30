<?php
$eyebrow      = get_field( 'eyebrow' );
$title        = get_field( 'title' );
$subtitle     = get_field( 'subtitle' );
$testimonials = get_field( 'testimonials' );

if ( empty( $testimonials ) ) {
    return;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100',
) );
?>
<section <?php echo $wrapper_attributes; ?> id="testimonials" data-reveal>

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
                <p class="mx-auto mb-10 max-w-[600px] text-center text-[1rem] leading-[1.85] text-muted"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="mx-auto mt-10 grid max-w-[1100px] grid-cols-1 gap-3 min-[768px]:grid-cols-1 min-[481px]:grid-cols-2 min-[769px]:gap-4 min-[1081px]:grid-cols-3">
        <?php foreach ( $testimonials as $i => $t ) : ?>
            <div data-reveal class="translate-y-6 rounded-[18px] border border-line bg-s1 px-[30px] py-[35px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100" style="transition-delay: <?php echo esc_attr( (string) ( $i * 100 ) ); ?>ms;">
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
