<?php
$slides = get_field( 'slides' );
$layout = get_field( 'layout' ) ?: 'left';

if ( empty( $slides ) ) {
    return;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'hero-block hero-layout-' . esc_attr( $layout ),
) );
?>
<div <?php echo $wrapper_attributes; ?>>
    <div class="hero-slider" data-hero-slider>
        <?php foreach ( $slides as $i => $slide ) : ?>
            <div
                data-hero-slide
                class="hero-slide <?php echo 0 === $i ? 'is-active' : ''; ?>"
            >
                <?php
                $image_id = $slide['background_image'];
                if ( $image_id ) :
                    echo wp_get_attachment_image( $image_id, 'full', '', array(
                        'class'   => 'hero-slide-image',
                        'decoding' => 'async',
                        ( 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"' ),
                    ) );
                endif;
                ?>
                <div class="hero-overlay"></div>
                <div class="hero-slide-content">
                    <?php if ( ! empty( $slide['eyebrow'] ) ) : ?>
                        <div class="hero-eyebrow">
                            <span><?php echo esc_html( $slide['eyebrow'] ); ?></span>
                        </div>
                    <?php endif; ?>
                    <<?php echo is_admin() ? 'h2' : 'h1'; ?> class="hero-headline">
                        <?php echo esc_html( $slide['title'] ); ?><br>
                        <?php if ( ! empty( $slide['line_2'] ) ) : ?>
                            <em class="hero-headline-accent"><?php echo esc_html( $slide['line_2'] ); ?></em>
                        <?php endif; ?>
                    </<?php echo is_admin() ? 'h2' : 'h1'; ?>>
                    <?php if ( ! empty( $slide['description'] ) ) : ?>
                        <p class="hero-description"><?php echo esc_html( $slide['description'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $slide['button_text'] ) && ! empty( $slide['button_url'] ) ) : ?>
                        <div class="hero-actions">
                            <a class="hero-button" href="<?php echo esc_url( $slide['button_url'] ); ?>">
                                <?php echo esc_html( $slide['button_text'] ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="button" data-hero-prev class="hero-arrow hero-arrow-prev" aria-label="Previous slide">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>
        <button type="button" data-hero-next class="hero-arrow hero-arrow-next" aria-label="Next slide">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
        <div class="hero-dots">
            <?php foreach ( $slides as $i => $slide ) : ?>
                <button type="button" data-hero-dot class="hero-dot <?php echo 0 === $i ? 'is-active' : ''; ?>" aria-label="Slide <?php echo (int) $i + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
        <div data-hero-progress class="hero-progress">
            <div data-hero-progress-fill class="hero-progress-fill animate-slide-progress"></div>
        </div>
    </div>
</div>
