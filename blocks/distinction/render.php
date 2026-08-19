<?php
$iga_theme_uri = get_stylesheet_directory_uri();

$iga_distinction_defaults = array(
    array(
        'featured'   => false,
        'image'      => $iga_theme_uri . '/assets/images/cover_2.jpg',
        'tag'        => 'The Movement',
        'tag_icon'   => 'fa-users',
        'title'      => 'Iron Gorilla Army',
        'body'       => 'We are a community built around iron and faith. The Army is the overarching culture, the standard, and the movement committed to growth and complete self-mastery.',
        'cta_label'  => 'Join Community',
        'cta_icon'   => 'fa-medal',
        'cta_url'    => '',
        'cta_action' => 'whatsapp-group',
    ),
    array(
        'featured'   => true,
        'image'      => $iga_theme_uri . '/assets/images/forge-gym.png',
        'tag'        => 'The Facility',
        'tag_icon'   => 'fa-dumbbell',
        'title'      => 'The Forge Gym',
        'body'       => 'The Forge is the proving ground where the Army trains. Open access, studio classes, and coach-led sessions. This is where the work gets done.',
        'cta_label'  => 'View Training Programs',
        'cta_icon'   => 'fa-dumbbell',
        'cta_url'    => '/training',
        'cta_action' => 'link',
    ),
    array(
        'featured'   => false,
        'image'      => '',
        'tag'        => 'Headquarters',
        'tag_icon'   => 'fa-location-dot',
        'title'      => 'Where To Find Us',
        'body'       => 'Unit 209 Salt Circle, Kent Str, Salt River, Cape Town. Mon–Sat: 6AM–9PM. Sunday: Closed.',
        'cta_label'  => 'Get Directions',
        'cta_icon'   => 'fa-map-location-dot',
        'cta_url'    => '',
        'cta_action' => 'directions',
    ),
);

$cards = get_field( 'cards' );

if ( empty( $cards ) ) {
    $cards = $iga_distinction_defaults;
}

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'translate-y-6 px-[3vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100',
) );
?>
<section <?php echo $wrapper_attributes; ?> id="distinction" data-reveal>
    <div class="mx-auto grid w-full max-w-[1400px] grid-cols-1 items-stretch gap-8 min-[1081px]:grid-cols-3">

        <?php foreach ( $cards as $card ) : ?>
            <?php
            $is_featured = ! empty( $card['featured'] );

            $article_classes = $is_featured
                ? 'border-green bg-[linear-gradient(to_bottom,#172a1a,#141414)] shadow-[0_0_0_1px_#3A7D44,0_0_40px_-4px_rgba(58,125,68,0.35)]'
                : 'border-line bg-s1';

            $cta_classes = 'mt-5 inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border px-[26px] py-[11px] font-sans text-[0.85rem] font-bold uppercase tracking-[1px] no-underline transition-all duration-[250ms] '
                . ( $is_featured
                    ? 'border-transparent bg-green text-white hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]'
                    : 'border-line-strong bg-transparent text-off hover:border-white/[0.32] hover:bg-white/[0.05]' );

            $cta_url   = $card['cta_url'] ?? '';
            $cta_action = $card['cta_action'] ?? 'link';

            if ( ! empty( $cta_url ) && 0 === strpos( $cta_url, '/' ) ) {
                $cta_url = home_url( $cta_url );
            }

            $image_id = $card['image'] ?? null;

            if ( is_numeric( $image_id ) ) {
                $image_url = wp_get_attachment_image_url( (int) $image_id, 'large' );
            } elseif ( is_string( $image_id ) && $image_id ) {
                $image_url = $image_id;
            } else {
                $image_url = null;
            }

            $image_alt = is_numeric( $image_id ) ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '';
            ?>
            <article class="flex flex-col overflow-hidden rounded-[18px] border <?php echo esc_attr( $article_classes ); ?>">
                <div class="relative h-[200px] w-full shrink-0 overflow-hidden">
                    <?php if ( $image_url ) : ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="absolute inset-0 h-full w-full object-cover" loading="lazy" decoding="async" />
                        <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(0,0,0,0.05),rgba(0,0,0,0.55))]"></div>
                        <?php if ( ! empty( $card['tag'] ) ) : ?>
                            <div class="absolute bottom-[14px] left-4 inline-flex items-center gap-1.5 rounded-[20px] border border-[rgba(78,158,90,0.35)] bg-black/50 px-2.5 py-[5px] text-[0.68rem] uppercase tracking-[3px] text-green-l backdrop-blur-[4px]">
                                <?php if ( ! empty( $card['tag_icon'] ) ) : ?>
                                    <i class="fa-solid <?php echo esc_attr( $card['tag_icon'] ); ?>" aria-hidden="true"></i>
                                <?php endif; ?>
                                <?php echo esc_html( $card['tag'] ); ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <iframe src="https://maps.google.com/maps?q=Salt+Circle,+Kent+Street,+Salt+River,+Cape+Town,+South+Africa&output=embed" class="block h-[200px] w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Iron Gorilla Army location"></iframe>
                    <?php endif; ?>
                </div>

                <div class="flex flex-1 flex-col px-6 pb-7 pt-6">
                    <?php if ( ! $image_url && ! empty( $card['tag'] ) ) : ?>
                        <div class="mb-2.5 inline-flex items-center gap-1.5 text-[0.68rem] uppercase tracking-[3px] text-green-l">
                            <?php if ( ! empty( $card['tag_icon'] ) ) : ?>
                                <i class="fa-solid <?php echo esc_attr( $card['tag_icon'] ); ?>" aria-hidden="true"></i>
                            <?php endif; ?>
                            <?php echo esc_html( $card['tag'] ); ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="mb-2.5 font-display text-[2rem] leading-[1.1] tracking-[2px] text-white">
                        <?php echo esc_html( $card['title'] ); ?>
                    </h3>

                    <p class="flex-1 text-[0.92rem] leading-[1.8] <?php echo $is_featured ? 'text-muted-l' : 'text-muted'; ?>">
                        <?php echo esc_html( $card['body'] ); ?>
                    </p>

                    <?php if ( ! empty( $card['cta_label'] ) ) : ?>
                        <?php $cta_icon_html = ! empty( $card['cta_icon'] ) ? '<i class="fa-solid ' . esc_attr( $card['cta_icon'] ) . ' shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>' : ''; ?>

                        <?php if ( 'directions' === $cta_action ) : ?>
                            <a href="https://maps.google.com/maps?q=Salt+Circle,+Kent+Street,+Salt+River,+Cape+Town,+South+Africa" target="_blank" rel="noopener noreferrer" class="<?php echo esc_attr( $cta_classes ); ?>">
                                <?php echo $cta_icon_html; ?>
                                <?php echo esc_html( $card['cta_label'] ); ?>
                            </a>
                        <?php elseif ( 'link' === $cta_action && $cta_url ) : ?>
                            <a href="<?php echo esc_url( $cta_url ); ?>" class="<?php echo esc_attr( $cta_classes ); ?>">
                                <?php echo $cta_icon_html; ?>
                                <?php echo esc_html( $card['cta_label'] ); ?>
                            </a>
                        <?php elseif ( 'whatsapp-group' === $cta_action || 'enlist-modal' === $cta_action ) : ?>
                            <a href="<?php echo esc_url( iga_get_whatsapp_group_url() ); ?>" target="_blank" rel="noopener noreferrer" class="<?php echo esc_attr( $cta_classes ); ?>">
                                <?php echo $cta_icon_html; ?>
                                <?php echo esc_html( $card['cta_label'] ); ?>
                            </a>
                        <?php else : ?>
                            <button type="button" data-modal-open="<?php echo esc_attr( $cta_action ); ?>" class="<?php echo esc_attr( $cta_classes ); ?>">
                                <?php echo $cta_icon_html; ?>
                                <?php echo esc_html( $card['cta_label'] ); ?>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>

    </div>
</section>
