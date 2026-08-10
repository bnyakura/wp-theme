<?php
$iga_theme_uri = get_stylesheet_directory_uri();

/**
 * Resolve an ACF image field (id) to a URL, falling back to $default.
 */
$iga_hero_image_url = static function ( $image_id, $default = '' ) {
    if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
        $url = wp_get_attachment_image_url( (int) $image_id, 'full' );
        if ( $url ) {
            return $url;
        }
    }

    return $default;
};

$iga_hero_default_slides = array(
    array(
        'background_image' => $iga_theme_uri . '/assets/images/cover_1.jpg',
        'eyebrow'           => 'The Brotherhood',
        'title'             => 'IRON GORILLA',
        'line_2'            => 'ARMY',
        'description'       => "Cape Town's most serious training community is enlisting. Built around iron, faith, and the belief that strength is forged — not born.",
        'button_text'       => 'Book Free Assessment',
        'button_url'        => home_url( '/book/' ),
    ),
    array(
        'background_image' => $iga_theme_uri . '/assets/images/forge-gym.png',
        'eyebrow'           => 'The Forge',
        'title'             => 'STRENGTH',
        'line_2'            => 'FORGED DAILY',
        'description'       => 'Open access training, hybrid group classes, and squads led by professional coaches. Walk in soft. Walk out steel.',
        'button_text'       => 'Book Free Assessment',
        'button_url'        => home_url( '/book/' ),
    ),
    array(
        'background_image' => $iga_theme_uri . '/assets/images/cover_3.jpg',
        'eyebrow'           => 'The Standard',
        'title'             => 'DISCIPLINE',
        'line_2'            => 'OVER MOOD',
        'description'       => "We don't chase motivation. We build standards. Every rep, every class, every member held to the same line.",
        'button_text'       => 'Book Free Assessment',
        'button_url'        => home_url( '/book/' ),
    ),
);

$slides = get_field( 'slides' );
$layout = get_field( 'layout' ) ?: 'left';

if ( empty( $slides ) ) {
    $slides = $iga_hero_default_slides;
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
                $image_id  = $slide['background_image'];
                $image_url = is_numeric( $image_id ) ? $iga_hero_image_url( $image_id ) : $image_id;
                if ( $image_url ) :
                    ?>
                    <img
                        src="<?php echo esc_url( $image_url ); ?>"
                        alt="<?php echo esc_attr( $slide['eyebrow'] ?? '' ); ?>"
                        class="hero-slide-image"
                        decoding="async"
                        <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?>
                    >
                    <?php
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
