<?php
/**
 * Homepage Contact block — render template.
 *
 * Condensed contact section for the homepage: section header, a
 * headquarters card, and the dispatch form. Headquarters data and form
 * handling are shared with the Contact page block (blocks/contact) via
 * inc/page-forms.php, so both stay in sync from a single source.
 *
 * @package Iron_Gorilla
 */

$eyebrow  = get_field( 'eyebrow' ) ?: 'Dispatch';
$title    = get_field( 'title' ) ?: 'Establish Contact';
$subtitle = get_field( 'subtitle' ) ?: 'Have questions about enlistment, want to join the community, or need intel on the Armory? Send a dispatch and our team will get back to you.';

$hq_defaults = iga_contact_details();
$hq          = array(
    'address' => get_field( 'location' ) ?: $hq_defaults['address'],
    'email'   => get_field( 'email' ) ?: $hq_defaults['email'],
    'phone'   => get_field( 'phone' ) ?: $hq_defaults['phone'],
);

$state   = iga_contact_form_state();
$success = $state['success'];
$error   = $state['error'];
$posted  = $state['posted'];

$card_classes  = 'rounded-[18px] border border-line px-[18px] py-6 text-left min-[481px]:px-6 min-[481px]:py-8 min-[769px]:p-[50px]';
$icon_classes  = 'flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[rgba(58,125,68,0.35)] bg-[rgba(58,125,68,0.15)] text-[1rem] text-green-l min-[481px]:h-[50px] min-[481px]:w-[50px] min-[481px]:text-[1.2rem]';
$input_classes = 'w-full rounded-[12px] border border-line bg-s1 px-5 py-4 font-sans text-[0.95rem] text-white transition-all duration-300 placeholder:text-white/30 focus:border-green-l focus:shadow-[0_0_0_2px_rgba(58,125,68,0.2)] focus:outline-none';

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => 'translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100',
) );
?>
<section <?php echo $wrapper_attributes; ?> id="contact" data-reveal>

    <div class="section-header">
        <div class="mb-[14px] flex items-center justify-center gap-3 before:h-px before:max-w-10 before:flex-1 before:bg-green before:content-[''] after:h-px after:max-w-10 after:flex-1 after:bg-green after:content-['']">
            <span class="text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l"><?php echo esc_html( $eyebrow ); ?></span>
        </div>
        <h2 class="mb-5 text-center font-display text-[clamp(2rem,4vw,3.5rem)] leading-[1.05] tracking-[2px] text-white"><?php echo esc_html( $title ); ?></h2>
        <?php if ( $subtitle ) : ?>
            <p class="mx-auto mb-12 max-w-[600px] text-center text-[1rem] leading-[1.7] text-muted"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
    </div>

    <div class="mx-auto grid max-w-[1200px] grid-cols-1 gap-10 min-[1081px]:grid-cols-2">

        <!-- Headquarters -->
        <div class="<?php echo esc_attr( $card_classes ); ?> bg-s2">
            <h3 class="mb-[30px] font-display text-[2.2rem] tracking-[1px] text-white">Headquarters</h3>

            <div class="mb-[30px] flex items-start gap-[14px] min-[481px]:gap-5">
                <div class="<?php echo esc_attr( $icon_classes ); ?>">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                </div>
                <div>
                    <strong class="mb-[5px] block text-[0.9rem] font-bold uppercase tracking-[1px] text-white">Location</strong>
                    <span class="inline-block text-[0.95rem] leading-[1.5] text-muted"><?php echo esc_html( $hq['address'] ); ?></span>
                </div>
            </div>

            <div class="mb-[30px] flex items-start gap-[14px] min-[481px]:gap-5">
                <div class="<?php echo esc_attr( $icon_classes ); ?>">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                </div>
                <div>
                    <strong class="mb-[5px] block text-[0.9rem] font-bold uppercase tracking-[1px] text-white">Email</strong>
                    <a href="mailto:<?php echo esc_attr( $hq['email'] ); ?>" class="inline-block text-[0.95rem] leading-[1.5] text-muted no-underline transition-colors duration-300 hover:text-green-l"><?php echo esc_html( $hq['email'] ); ?></a>
                </div>
            </div>

            <div class="flex items-start gap-[14px] min-[481px]:gap-5">
                <div class="<?php echo esc_attr( $icon_classes ); ?>">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                </div>
                <div>
                    <strong class="mb-[5px] block text-[0.9rem] font-bold uppercase tracking-[1px] text-white">Comm-Line</strong>
                    <a href="tel:<?php echo esc_attr( $hq['phone'] ); ?>" class="inline-block text-[0.95rem] leading-[1.5] text-muted no-underline transition-colors duration-300 hover:text-green-l"><?php echo esc_html( iga_format_phone_display( $hq['phone'] ) ); ?></a>
                </div>
            </div>
        </div>

        <!-- Dispatch form -->
        <div class="<?php echo esc_attr( $card_classes ); ?> bg-s3">
            <?php if ( $success ) : ?>
                <div class="flex h-full min-h-[300px] flex-col items-center justify-center gap-4 text-center">
                    <i class="fa-solid fa-check-circle text-[3rem] text-green-l" aria-hidden="true"></i>
                    <h3 class="font-display text-[2rem] text-white">Dispatch Received</h3>
                    <p class="text-muted">We'll be in contact shortly. Prepare to enlist.</p>
                </div>
            <?php else : ?>
                <form method="post" action="<?php echo esc_url( get_permalink() ); ?>">
                    <?php wp_nonce_field( 'iga_submit_contact', 'iga_contact_nonce' ); ?>
                    <input type="hidden" name="iga_contact_submit" value="1">

                    <!-- Honeypot — hidden from humans, filled by bots -->
                    <div class="hidden" aria-hidden="true">
                        <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <div class="mb-5">
                        <input type="text" name="contact_name" value="<?php echo esc_attr( $posted['name'] ); ?>" required maxlength="100" autocomplete="name" placeholder="Your Name" aria-label="Your Name" class="<?php echo esc_attr( $input_classes ); ?>">
                    </div>
                    <div class="mb-5">
                        <input type="email" name="contact_email" value="<?php echo esc_attr( $posted['email'] ); ?>" required maxlength="254" autocomplete="email" placeholder="Your Email" aria-label="Your Email" class="<?php echo esc_attr( $input_classes ); ?>">
                    </div>
                    <div class="mb-5">
                        <textarea name="contact_message" required maxlength="2000" placeholder="I want to join the community / My question is..." aria-label="Your message" class="<?php echo esc_attr( $input_classes ); ?> min-h-[120px] resize-y"><?php echo esc_textarea( $posted['message'] ); ?></textarea>
                    </div>

                    <?php if ( $error ) : ?>
                        <p class="mb-3 text-[0.85rem] leading-[1.5] text-[#E05A5A]"><?php echo esc_html( $error ); ?></p>
                    <?php endif; ?>

                    <button type="submit" class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border border-transparent bg-green px-[26px] py-[11px] font-sans text-[0.85rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]">
                        Send Dispatch
                        <i class="fa-solid fa-paper-plane ml-[5px] shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
                    </button>
                </form>
            <?php endif; ?>
        </div>

    </div>
</section>
