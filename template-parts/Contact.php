<?php
/**
 * Contact section — HQ card + dispatch form.
 *
 * Content from Appearance → Customize → Contact Section. The form posts to
 * admin-post.php (see inc/contact-section.php); success/error state comes
 * back via the ?iga-contact= query flag after redirect.
 *
 * @package IGA
 */

$section = iga_get_contact_section();
$header  = $section['header'];
$hq      = $section['hq'];
$email   = is_email( $hq['email'] ) ? $hq['email'] : '';

$status = isset( $_GET['iga-contact'] ) ? sanitize_key( wp_unslash( $_GET['iga-contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only display flag.

$card_classes  = 'rounded-[18px] border border-line px-[18px] py-6 text-left min-[481px]:px-6 min-[481px]:py-8 min-[769px]:p-[50px]';
$icon_classes  = 'flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[rgba(58,125,68,0.35)] bg-[rgba(58,125,68,0.15)] text-[1rem] text-green-l min-[481px]:h-[50px] min-[481px]:w-[50px] min-[481px]:text-[1.2rem]';
$input_classes = 'w-full rounded-[12px] border border-line bg-s1 px-5 py-4 font-sans text-[0.95rem] text-white transition-all duration-300 placeholder:text-white/30 focus:border-green-l focus:shadow-[0_0_0_2px_rgba(58,125,68,0.2)] focus:outline-none';
?>

<section
	id="contact"
	data-reveal
	class="translate-y-6 border-y border-line bg-s1 px-[5vw] py-[100px] opacity-0 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] motion-reduce:translate-y-0 motion-reduce:opacity-100 [&.is-revealed]:translate-y-0 [&.is-revealed]:opacity-100"
>
	<?php get_template_part( 'template-parts/section-header', null, $header ); ?>

	<div class="mx-auto grid max-w-[1200px] grid-cols-1 gap-10 min-[1081px]:grid-cols-2">

		<!-- Headquarters -->
		<div class="<?php echo esc_attr( $card_classes ); ?> bg-s2">
			<h3 class="mb-[30px] font-display text-[2.2rem] tracking-[1px] text-white">
				<?php esc_html_e( 'Headquarters', 'iga' ); ?>
			</h3>

			<?php if ( ! empty( $hq['location'] ) ) : ?>
				<div class="mb-[30px] flex items-start gap-[14px] min-[481px]:gap-5">
					<div class="<?php echo esc_attr( $icon_classes ); ?>">
						<i class="fa-solid fa-location-dot" aria-hidden="true"></i>
					</div>
					<div>
						<strong class="mb-[5px] block text-[0.9rem] font-bold uppercase tracking-[1px] text-white"><?php esc_html_e( 'Location', 'iga' ); ?></strong>
						<span class="inline-block text-[0.95rem] leading-[1.5] text-muted"><?php echo nl2br( esc_html( $hq['location'] ) ); ?></span>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $email ) : ?>
				<div class="mb-[30px] flex items-start gap-[14px] min-[481px]:gap-5">
					<div class="<?php echo esc_attr( $icon_classes ); ?>">
						<i class="fa-solid fa-envelope" aria-hidden="true"></i>
					</div>
					<div>
						<strong class="mb-[5px] block text-[0.9rem] font-bold uppercase tracking-[1px] text-white"><?php esc_html_e( 'Email', 'iga' ); ?></strong>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" class="inline-block text-[0.95rem] leading-[1.5] text-muted no-underline transition-colors duration-300 hover:text-green-l"><?php echo esc_html( $email ); ?></a>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $hq['phone'] ) ) : ?>
				<div class="flex items-start gap-[14px] min-[481px]:gap-5">
					<div class="<?php echo esc_attr( $icon_classes ); ?>">
						<i class="fa-solid fa-phone" aria-hidden="true"></i>
					</div>
					<div>
						<strong class="mb-[5px] block text-[0.9rem] font-bold uppercase tracking-[1px] text-white"><?php esc_html_e( 'Comm-Line', 'iga' ); ?></strong>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', $hq['phone'] ) ); ?>" class="inline-block text-[0.95rem] leading-[1.5] text-muted no-underline transition-colors duration-300 hover:text-green-l"><?php echo esc_html( iga_format_phone_display( $hq['phone'] ) ); ?></a>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Dispatch form -->
		<div class="<?php echo esc_attr( $card_classes ); ?> bg-s3">
			<?php if ( 'sent' === $status ) : ?>
				<div class="flex h-full flex-col items-center justify-center gap-4 text-center">
					<i class="fa-solid fa-check-circle text-[3rem] text-green-l" aria-hidden="true"></i>
					<h3 class="font-display text-[2rem] text-white"><?php esc_html_e( 'Dispatch Received', 'iga' ); ?></h3>
					<p class="text-muted"><?php esc_html_e( "We'll be in contact shortly. Prepare to enlist.", 'iga' ); ?></p>
				</div>
			<?php else : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="iga_contact" />
					<?php wp_nonce_field( 'iga_contact_send', 'iga_contact_nonce' ); ?>

					<!-- Honeypot — hidden from humans, filled by bots -->
					<div class="hidden" aria-hidden="true">
						<label><?php esc_html_e( 'Company', 'iga' ); ?>
							<input type="text" name="iga_company" tabindex="-1" autocomplete="off" />
						</label>
					</div>

					<div class="mb-5">
						<input type="text" name="iga_name" required placeholder="<?php esc_attr_e( 'Your Name', 'iga' ); ?>" aria-label="<?php esc_attr_e( 'Your Name', 'iga' ); ?>" class="<?php echo esc_attr( $input_classes ); ?>" />
					</div>
					<div class="mb-5">
						<input type="email" name="iga_email" required placeholder="<?php esc_attr_e( 'Your Email', 'iga' ); ?>" aria-label="<?php esc_attr_e( 'Your Email', 'iga' ); ?>" class="<?php echo esc_attr( $input_classes ); ?>" />
					</div>
					<div class="mb-5">
						<textarea name="iga_message" required placeholder="<?php esc_attr_e( 'I want to join the community / My question is...', 'iga' ); ?>" aria-label="<?php esc_attr_e( 'Your message', 'iga' ); ?>" class="<?php echo esc_attr( $input_classes ); ?> min-h-[120px] resize-y"></textarea>
					</div>

					<?php if ( 'error' === $status ) : ?>
						<p class="mb-3 text-[0.85rem] leading-[1.5] text-[#E05A5A]">
							<?php
							printf(
								/* translators: %s: contact email address linked with mailto. */
								esc_html__( 'Something went wrong. Email us directly at %s', 'iga' ),
								$email
									? '<a href="mailto:' . esc_attr( $email ) . '" class="underline">' . esc_html( $email ) . '</a>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
									: esc_html__( 'the gym', 'iga' )
							);
							?>
						</p>
					<?php endif; ?>

					<button type="submit" class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border border-transparent bg-green px-[26px] py-[11px] font-sans text-[0.85rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)]">
						<?php esc_html_e( 'Send Dispatch', 'iga' ); ?>
						<i class="fa-solid fa-paper-plane ml-[5px] shrink-0 text-[0.9em] leading-none" aria-hidden="true"></i>
					</button>
				</form>
			<?php endif; ?>
		</div>

	</div>
</section>
