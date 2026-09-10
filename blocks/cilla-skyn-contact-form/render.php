<?php
/**
 * Cilla Skyn Contact Form block — render template.
 *
 * A working contact form (name, email, phone, subject, message) that
 * emails the site admin via inc/cilla-skyn-contact-form.php — for the
 * Contact Us page, alongside the Contact Info block (WhatsApp/Instagram/
 * Email cards). No-JS: a normal POST handled on `template_redirect`,
 * nonce + honeypot spam protection, redirect-on-success so refreshing the
 * page never resubmits.
 *
 * @package custom-theme
 */

$heading         = get_field( 'heading' ) ?: 'Send Us a Message';
$description     = get_field( 'description' ) ?: "Have a question about an order, a product, or anything else? Fill in the form below and we'll get back to you within 1–2 business days.";
$success_message = get_field( 'success_message' ) ?: "Thanks for reaching out — we'll get back to you within 1–2 business days.";

$state    = function_exists( 'cilla_skyn_contact_form_state' ) ? cilla_skyn_contact_form_state() : array(
	'success' => false,
	'error'   => '',
	'posted'  => array(
		'name'    => '',
		'email'   => '',
		'phone'   => '',
		'subject' => '',
		'message' => '',
	),
);
$posted   = $state['posted'];
$subjects = function_exists( 'cilla_skyn_contact_form_subjects' ) ? cilla_skyn_contact_form_subjects() : array( 'other' => __( 'Other', 'custom-theme' ) );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-contact-form bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-xl px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $heading ) : ?>
			<h2 class="mb-3 text-center font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="mb-10 text-center leading-relaxed text-cs-ink/70"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $state['success'] ) : ?>

			<div class="border border-cs-ink/15 bg-cream-dark px-6 py-8 text-center">
				<p class="leading-relaxed"><?php echo esc_html( $success_message ); ?></p>
			</div>

		<?php else : ?>

			<?php if ( $state['error'] ) : ?>
				<p class="mb-6 border border-red-800/30 bg-red-800/5 px-4 py-3 text-sm text-red-900"><?php echo esc_html( $state['error'] ); ?></p>
			<?php endif; ?>

			<form method="post" class="space-y-5" novalidate>

				<div aria-hidden="true" style="position:absolute; left:-9999px; top:-9999px;">
					<label for="cilla-skyn-contact-website"><?php esc_html_e( 'Leave this field empty', 'custom-theme' ); ?></label>
					<input type="text" id="cilla-skyn-contact-website" name="cilla_skyn_website" tabindex="-1" autocomplete="off" value="">
				</div>

				<?php wp_nonce_field( 'cilla_skyn_submit_contact', 'cilla_skyn_contact_nonce' ); ?>

				<div class="grid grid-cols-1 gap-5 min-[640px]:grid-cols-2">
					<div>
						<label for="cilla-skyn-contact-name" class="mb-1.5 block text-[11px] uppercase tracking-[0.18em] text-cs-ink/60"><?php esc_html_e( 'Name', 'custom-theme' ); ?></label>
						<input id="cilla-skyn-contact-name" type="text" name="contact_name" required value="<?php echo esc_attr( $posted['name'] ); ?>" class="w-full border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm focus:border-cs-ink focus:outline-none">
					</div>
					<div>
						<label for="cilla-skyn-contact-email" class="mb-1.5 block text-[11px] uppercase tracking-[0.18em] text-cs-ink/60"><?php esc_html_e( 'Email', 'custom-theme' ); ?></label>
						<input id="cilla-skyn-contact-email" type="email" name="contact_email" required value="<?php echo esc_attr( $posted['email'] ); ?>" class="w-full border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm focus:border-cs-ink focus:outline-none">
					</div>
				</div>

				<div class="grid grid-cols-1 gap-5 min-[640px]:grid-cols-2">
					<div>
						<label for="cilla-skyn-contact-phone" class="mb-1.5 block text-[11px] uppercase tracking-[0.18em] text-cs-ink/60"><?php esc_html_e( 'Phone (optional)', 'custom-theme' ); ?></label>
						<input id="cilla-skyn-contact-phone" type="tel" name="contact_phone" value="<?php echo esc_attr( $posted['phone'] ); ?>" class="w-full border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm focus:border-cs-ink focus:outline-none">
					</div>
					<div>
						<label for="cilla-skyn-contact-subject" class="mb-1.5 block text-[11px] uppercase tracking-[0.18em] text-cs-ink/60"><?php esc_html_e( 'Subject', 'custom-theme' ); ?></label>
						<select id="cilla-skyn-contact-subject" name="contact_subject" class="w-full border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm focus:border-cs-ink focus:outline-none">
							<?php foreach ( $subjects as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $posted['subject'], $key ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div>
					<label for="cilla-skyn-contact-message" class="mb-1.5 block text-[11px] uppercase tracking-[0.18em] text-cs-ink/60"><?php esc_html_e( 'Message', 'custom-theme' ); ?></label>
					<textarea id="cilla-skyn-contact-message" name="contact_message" rows="5" required class="w-full border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm focus:border-cs-ink focus:outline-none"><?php echo esc_textarea( $posted['message'] ); ?></textarea>
				</div>

				<button type="submit" name="cilla_skyn_contact_submit" value="1" class="w-full bg-cs-ink px-7 py-3.5 text-[13px] tracking-wide text-cream transition hover:bg-cs-ink/85 min-[640px]:w-auto">
					<?php esc_html_e( 'Send Message', 'custom-theme' ); ?>
				</button>

			</form>

		<?php endif; ?>

	</div>
</section>
