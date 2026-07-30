<?php
$eyebrow    = get_field( 'eyebrow' );
$heading    = get_field( 'heading' );
$paragraphs = get_field( 'paragraphs' );
$values     = get_field( 'values' );
$story_label = get_field( 'story_label' );
$story_url  = get_field( 'story_url' );
$image_id   = get_field( 'image' );
$caption    = get_field( 'caption' );

if ( empty( $heading ) && empty( $image_id ) ) {
    return;
}

if ( ! empty( $story_url ) && 0 === strpos( $story_url, '/' ) ) {
    $story_url = home_url( $story_url );
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100',
) );
?>
<section <?php echo $wrapper_attributes; ?> id="mission" data-reveal>
    <div class="mx-auto grid max-w-[1100px] grid-cols-1 items-center gap-9 min-[769px]:grid-cols-2 min-[769px]:gap-16">

        <div>
            <?php if ( $eyebrow ) : ?>
                <div class="mb-[14px] flex items-center justify-center gap-3 before:h-px before:max-w-10 before:flex-1 before:bg-green before:content-[''] after:h-px after:max-w-10 after:flex-1 after:bg-green after:content-['']">
                    <span class="text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l">
                        <?php echo esc_html( $eyebrow ); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ( $heading ) : ?>
                <h2 class="mb-6 text-left font-display text-[clamp(2rem,4vw,3.5rem)] leading-[1.05] tracking-[2px] text-white">
                    <?php echo esc_html( $heading ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( $paragraphs ) : ?>
                <?php $total = count( $paragraphs ); ?>
                <?php foreach ( $paragraphs as $i => $p ) : ?>
                    <p class="text-[1.02rem] leading-[1.85] text-muted-l <?php echo $i === $total - 1 ? 'mb-9' : 'mb-5'; ?>">
                        <?php echo esc_html( $p['paragraph'] ); ?>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ( $values ) : ?>
                <div class="mb-9 flex flex-wrap gap-3">
                    <?php foreach ( $values as $value ) : ?>
                        <div class="flex items-center gap-2 rounded-full border border-[rgba(58,125,68,0.35)] bg-[rgba(58,125,68,0.15)] px-4 py-2 text-[0.78rem] font-bold uppercase tracking-[1.2px] text-green-l">
                            <?php if ( ! empty( $value['icon'] ) ) : ?>
                                <i class="fa-solid <?php echo esc_attr( $value['icon'] ); ?> text-[0.8rem]" aria-hidden="true"></i>
                            <?php endif; ?>
                            <?php echo esc_html( $value['label'] ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $story_label && $story_url ) : ?>
                <a href="<?php echo esc_url( $story_url ); ?>" class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-line-strong bg-transparent px-[26px] py-[11px] font-sans text-[0.85rem] font-bold uppercase tracking-[1px] text-off no-underline transition-all duration-[250ms] hover:border-white/[0.32] hover:bg-white/[0.05]">
                    <?php echo esc_html( $story_label ); ?>
                    <i class="fa-solid fa-arrow-right ml-1 shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
        </div>

        <?php if ( $image_id ) : ?>
            <div class="relative isolate h-[260px] overflow-hidden rounded-[18px] min-[769px]:aspect-[4/5] min-[769px]:h-auto min-[769px]:min-h-[380px]">
                <?php echo wp_get_attachment_image( $image_id, 'full', '', array(
                    'class'    => 'absolute inset-0 h-full w-full object-cover',
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                ) ); ?>
                <div class="absolute inset-0 bg-[linear-gradient(to_top,rgba(10,10,10,0.7)_0%,transparent_60%)]"></div>
                <?php if ( $caption ) : ?>
                    <div class="absolute bottom-6 left-6 font-display text-[1.1rem] tracking-[3px] text-white/90">
                        <?php echo esc_html( $caption ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
