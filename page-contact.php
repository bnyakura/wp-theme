<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Tailwind WordPress version of the Iron Gorilla Army /contact page.
 * Includes a self-contained WordPress contact form and email handler.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

$iga_contact_details = array(
	'email'     => 'info@irongorilla.co.za',
	'phone'     => '+27790614906',
	'phone_text'=> '+27 79 061 4906',
	'whatsapp'  => '27790614906',
	'instagram' => 'https://www.instagram.com/irongorillaarmy',
	'address'   => 'Unit 209 Salt Circle, Kent Str., Salt River, Cape Town',
);

$iga_contact_subjects = array(
	'enlistment' => 'Membership Enquiry',
	'dropin'     => 'Book a Drop-In',
	'armory'     => 'Armory / Product Order',
	'event'      => 'Event Enquiry',
	'league'     => 'League of Legends',
	'operations' => 'Operations List',
	'other'      => 'Other',
);

/* Map links used by the other converted page templates to contact subjects. */
$iga_contact_subject_aliases = array(
	'enlist'               => 'enlistment',
	'platoons'             => 'enlistment',
	'squads'               => 'enlistment',
	'studio-access'        => 'enlistment',
	'armory-early-access'  => 'armory',
	'league-of-legends'    => 'league',
	'operations-list'      => 'operations',
);

$iga_contact_error  = '';
$iga_contact_posted = array(
	'name'    => '',
	'email'   => '',
	'phone'   => '',
	'subject' => '',
	'message' => '',
);

/* Process the form before get_header(), allowing a safe redirect on success. */
if ( 'POST' === strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) && isset( $_POST['iga_contact_submit'] ) ) {
	$nonce    = isset( $_POST['iga_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iga_contact_nonce'] ) ) : '';
	$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';

	$iga_contact_posted['name']    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$iga_contact_posted['email']   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$iga_contact_posted['phone']   = isset( $_POST['contact_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ) : '';
	$iga_contact_posted['subject'] = isset( $_POST['contact_subject'] ) ? sanitize_key( wp_unslash( $_POST['contact_subject'] ) ) : '';
	$iga_contact_posted['message'] = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	$iga_contact_posted['name']    = substr( $iga_contact_posted['name'], 0, 100 );
	$iga_contact_posted['phone']   = substr( $iga_contact_posted['phone'], 0, 30 );
	$iga_contact_posted['message'] = substr( $iga_contact_posted['message'], 0, 2000 );

	if ( ! wp_verify_nonce( $nonce, 'iga_submit_contact' ) ) {
		$iga_contact_error = 'Your session expired. Please refresh the page and try again.';
	} elseif ( $honeypot ) {
		$iga_contact_error = 'Unable to submit this dispatch.';
	} elseif ( ! $iga_contact_posted['name'] ) {
		$iga_contact_error = 'Please enter your name.';
	} elseif ( ! is_email( $iga_contact_posted['email'] ) ) {
		$iga_contact_error = 'Please enter a valid email address.';
	} elseif ( ! $iga_contact_posted['message'] ) {
		$iga_contact_error = 'Please enter your message.';
	} else {
		$subject_key   = isset( $iga_contact_subjects[ $iga_contact_posted['subject'] ] ) ? $iga_contact_posted['subject'] : 'other';
		$subject_label = $iga_contact_subjects[ $subject_key ];
		$submission    = array(
			'name'    => $iga_contact_posted['name'],
			'email'   => $iga_contact_posted['email'],
			'phone'   => $iga_contact_posted['phone'],
			'subject' => $subject_label,
			'message' => $iga_contact_posted['message'],
		);
		$recipient     = apply_filters( 'iga_contact_recipient', get_option( 'admin_email' ) );
		$mail_subject  = sprintf( 'Iron Gorilla dispatch: %s — %s', $subject_label, $submission['name'] );
		$mail_message  = "A new dispatch was submitted from the Iron Gorilla Army website.\n\n";
		$mail_message .= "Name: {$submission['name']}\n";
		$mail_message .= "Email: {$submission['email']}\n";
		$mail_message .= "Phone: " . ( $submission['phone'] ? $submission['phone'] : 'Not supplied' ) . "\n";
		$mail_message .= "Subject: {$submission['subject']}\n\n";
		$mail_message .= "Message:\n{$submission['message']}\n";
		$headers       = array( 'Reply-To: ' . $submission['name'] . ' <' . $submission['email'] . '>' );
		$mail_sent     = wp_mail( $recipient, $mail_subject, $mail_message, $headers );

		do_action( 'iga_contact_submitted', $submission, $mail_sent );

		if ( $mail_sent ) {
			wp_safe_redirect( add_query_arg( 'dispatch', 'received', get_permalink() ) );
			exit;
		}

		$iga_contact_error = 'Something went wrong. Please try again or WhatsApp us directly.';
	}
}

/* Preselect a subject when another page links here with ?subject=... or ?plan=... */
if ( ! $iga_contact_posted['subject'] ) {
	$query_subject = isset( $_GET['subject'] ) ? sanitize_key( wp_unslash( $_GET['subject'] ) ) : '';
	$query_plan    = isset( $_GET['plan'] ) ? sanitize_key( wp_unslash( $_GET['plan'] ) ) : '';
	$query_value   = $query_subject ? $query_subject : $query_plan;

	if ( isset( $iga_contact_subject_aliases[ $query_value ] ) ) {
		$iga_contact_posted['subject'] = $iga_contact_subject_aliases[ $query_value ];
	} elseif ( isset( $iga_contact_subjects[ $query_value ] ) ) {
		$iga_contact_posted['subject'] = $query_value;
	}
}

$iga_contact_success = isset( $_GET['dispatch'] ) && 'received' === sanitize_key( wp_unslash( $_GET['dispatch'] ) );

wp_enqueue_style(
	'iga-contact-fonts',
	'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
	array(),
	null
);

get_header();

$iga_contact_icon = static function ( $name, $classes = 'h-5 w-5' ) {
	$paths = array(
		'location'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 5.25-7.5 11.25-7.5 11.25S4.5 15.75 4.5 10.5a7.5 7.5 0 1 1 15 0Zm-5.25 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
		'email'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A1.5 1.5 0 0 1 5.25 5.25h13.5a1.5 1.5 0 0 1 1.5 1.5v10.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6.75Zm.5-.5L12 12l7.75-5.75"/>',
		'phone'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5c0 8.7 7.05 15.75 15.75 15.75h.75a1.5 1.5 0 0 0 1.5-1.5v-2.6a1.5 1.5 0 0 0-1.1-1.45l-3.2-.9a1.5 1.5 0 0 0-1.55.48l-.7.85a12.05 12.05 0 0 1-6.33-6.33l.85-.7a1.5 1.5 0 0 0 .48-1.55l-.9-3.2A1.5 1.5 0 0 0 7.65 2.25h-2.4a1.5 1.5 0 0 0-1.5 1.5v.75Z"/>',
		'whatsapp'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 11.6a8.25 8.25 0 0 1-12.2 7.25L3.75 20l1.15-4.15A8.25 8.25 0 1 1 20.25 11.6Zm-11-4.1c.2 3.7 3.1 6.6 6.8 6.8"/>',
		'clock'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".75" fill="currentColor" stroke="none"/>',
		'send'      => '<path stroke-linecap="round" stroke-linejoin="round" d="m3.75 3.75 16.5 8.25-16.5 8.25 3-8.25-3-8.25Zm3 8.25h7.5"/>',
		'check'     => '<path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4.25 4.25L19 6.5"/>',
		'quote'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 11.25H3.75V7.5A3.75 3.75 0 0 1 7.5 3.75v7.5Zm12.75 0H16.5V7.5a3.75 3.75 0 0 1 3.75-3.75v7.5Z"/>',
		'medal'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'calendar'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['send'];
	return sprintf( '<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>', esc_attr( $classes ), $path );
};

$iga_contact_section_header = static function ( $eyebrow, $title, $subtitle = '' ) {
	?>
	<div class="mx-auto mb-12 max-w-3xl text-center lg:mb-14">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-[#3A7D44]"></span>
			<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]"><?php echo esc_html( $eyebrow ); ?></span>
			<span class="h-px w-10 bg-[#3A7D44]"></span>
		</div>
		<h2 class="font-['Bebas_Neue'] text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl"><?php echo esc_html( $title ); ?></h2>
		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
	<?php
};

$iga_testimonials = array(
	array(
		'initials' => 'K', 'name' => 'Kamva', 'location' => 'Fisantekraal',
		'quote' => 'Iron Gorilla is more than a brotherhood. The community pushes me to stay fit and always want to be better. We are an amalgam of aggression and compassion — exactly what I needed. I feel safe. I feel part of something.',
		'result' => 'Member since age 18',
	),
	array(
		'initials' => 'D', 'name' => 'Deogracias', 'location' => 'Observatory',
		'quote' => "I've lost 10kg being part of this community. What kept me going was knowing everyone here is on their own journey of self-betterment. It's not about the weight — it's about the journey everyone is on.",
		'result' => 'Lost 10kg · Since 2020',
	),
	array(
		'initials' => 'M', 'name' => 'Micah', 'location' => 'Khayelitsha',
		'quote' => "I sometimes feel misunderstood. But Iron Gorilla has challenged me — not just physically in the boxing classes, but mentally too. That's the difference that keeps me coming back.",
		'result' => 'Physically & Mentally Challenged',
	),
);
?>

<main id="primary" class="overflow-hidden bg-[#0A0A0A] font-['DM_Sans'] text-[#F2F2F2] antialiased">
	<!-- Page hero -->
	<section class="border-b border-white/[0.07] bg-[#141414] px-6 py-20 text-center sm:px-10 lg:px-20 lg:py-24 xl:px-28">
		<div class="mx-auto max-w-3xl">
			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-[#3A7D44]"></span>
				<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]">Dispatch</span>
				<span class="h-px w-10 bg-[#3A7D44]"></span>
			</div>
			<h1 class="font-['Bebas_Neue'] text-5xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl">Establish Contact</h1>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">Questions about training, enlistment, or the Armory? Send a dispatch. Our team responds within 24 hours.</p>
		</div>
	</section>

	<!-- Contact information and form -->
	<section class="px-6 py-20 sm:px-10 lg:px-20 lg:py-28 xl:px-28">
		<div class="mx-auto grid max-w-[1200px] gap-8 lg:grid-cols-2 lg:gap-10">
			<!-- Headquarters -->
			<div class="rounded-2xl border border-white/[0.07] bg-[#1C1C1C] p-6 sm:p-10 lg:p-12">
				<h2 class="mb-8 font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Headquarters</h2>

				<?php
				$info_rows = array(
					array( 'location', 'Location', $iga_contact_details['address'], '' ),
					array( 'email', 'Email', $iga_contact_details['email'], 'mailto:' . $iga_contact_details['email'] ),
					array( 'phone', 'Comm-Line', $iga_contact_details['phone_text'], 'tel:' . $iga_contact_details['phone'] ),
					array( 'whatsapp', 'WhatsApp', $iga_contact_details['phone_text'], 'https://wa.me/' . $iga_contact_details['whatsapp'] ),
					array( 'clock', 'Hours', 'Mon – Sat: 6AM – 9PM | Sunday: Closed', '' ),
				);
				foreach ( $info_rows as $row ) :
					?>
					<div class="mb-7 flex items-start gap-4 last:mb-0">
						<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-[#3A7D44]/40 bg-[#3A7D44]/10 text-[#4E9E5A]">
							<?php echo $iga_contact_icon( $row[0], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="min-w-0 pt-1">
							<strong class="mb-1 block text-[10px] font-bold uppercase tracking-[0.16em] text-white"><?php echo esc_html( $row[1] ); ?></strong>
							<?php if ( $row[3] ) : ?>
								<a href="<?php echo esc_url( $row[3] ); ?>" <?php echo 'whatsapp' === $row[0] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="text-sm leading-6 text-white/50 transition hover:text-[#4E9E5A]"><?php echo esc_html( $row[2] ); ?></a>
							<?php else : ?>
								<span class="block text-sm leading-6 text-white/50"><?php echo esc_html( $row[2] ); ?></span>
							<?php endif; ?>
						</span>
					</div>
				<?php endforeach; ?>

				<div class="mt-8 border-t border-white/[0.07] pt-6">
					<p class="mb-4 text-[10px] font-bold uppercase tracking-[0.18em] text-white/35">Follow The Army</p>
					<a href="<?php echo esc_url( $iga_contact_details['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Follow Iron Gorilla Army on Instagram" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-white/40 transition hover:border-white/30 hover:bg-white/5 hover:text-white">
						<?php echo $iga_contact_icon( 'instagram', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
			</div>

			<!-- Dispatch form -->
			<div class="rounded-2xl border border-white/[0.07] bg-[#242424] p-6 sm:p-10 lg:p-12">
				<?php if ( $iga_contact_success ) : ?>
					<div class="flex h-full min-h-[420px] flex-col items-center justify-center text-center">
						<span class="mb-5 flex h-16 w-16 items-center justify-center rounded-full border border-[#3A7D44]/50 bg-[#3A7D44]/10 text-[#4E9E5A]">
							<?php echo $iga_contact_icon( 'check', 'h-9 w-9' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<h2 class="font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Dispatch Received</h2>
						<p class="mt-3 max-w-sm text-sm leading-7 text-white/45">We'll be in contact within 24 hours. Prepare to enlist.</p>
					</div>
				<?php else : ?>
					<h2 class="mb-7 font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Send a Dispatch</h2>

					<?php if ( $iga_contact_error ) : ?>
						<div class="mb-5 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm leading-6 text-red-300" role="alert"><?php echo esc_html( $iga_contact_error ); ?></div>
					<?php endif; ?>

					<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="space-y-5">
						<?php wp_nonce_field( 'iga_submit_contact', 'iga_contact_nonce' ); ?>
						<input type="hidden" name="iga_contact_submit" value="1">
						<div class="absolute -left-[9999px]" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

						<div>
							<label for="contact-name" class="sr-only">Your Name</label>
							<input id="contact-name" type="text" name="contact_name" value="<?php echo esc_attr( $iga_contact_posted['name'] ); ?>" placeholder="Your Name" autocomplete="name" maxlength="100" required class="w-full rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20">
						</div>
						<div>
							<label for="contact-email" class="sr-only">Your Email</label>
							<input id="contact-email" type="email" name="contact_email" value="<?php echo esc_attr( $iga_contact_posted['email'] ); ?>" placeholder="Your Email" autocomplete="email" maxlength="254" required class="w-full rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20">
						</div>
						<div>
							<label for="contact-phone" class="sr-only">Phone Number</label>
							<input id="contact-phone" type="tel" name="contact_phone" value="<?php echo esc_attr( $iga_contact_posted['phone'] ); ?>" placeholder="Phone Number (optional)" autocomplete="tel" maxlength="30" class="w-full rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20">
						</div>
						<div>
							<label for="contact-subject" class="sr-only">Subject</label>
							<select id="contact-subject" name="contact_subject" class="w-full cursor-pointer rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white/70 outline-none transition focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20">
								<option value="">Subject — What's this about?</option>
								<?php foreach ( $iga_contact_subjects as $key => $label ) : ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $iga_contact_posted['subject'], $key ); ?>><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div>
							<label for="contact-message" class="sr-only">Your Message</label>
							<textarea id="contact-message" name="contact_message" placeholder="Your message..." rows="6" maxlength="2000" required class="w-full resize-y rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20"><?php echo esc_textarea( $iga_contact_posted['message'] ); ?></textarea>
						</div>
						<button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-[#3A7D44] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:bg-[#4E9E5A] hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
							Send Dispatch <?php echo $iga_contact_icon( 'send', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Testimonials -->
	<section id="testimonials" class="border-y border-white/[0.07] bg-[#141414] px-6 py-20 sm:px-10 lg:px-20 lg:py-28 xl:px-28">
		<div class="mx-auto max-w-[1280px]">
			<?php $iga_contact_section_header( 'What Members Say', 'The Brotherhood Speaks', 'Not endorsements — honest accounts from members who showed up and did the work.' ); ?>
			<div class="grid gap-4 lg:grid-cols-3">
				<?php foreach ( $iga_testimonials as $testimonial ) : ?>
					<article class="flex h-full flex-col rounded-2xl border border-white/[0.07] bg-[#1C1C1C] p-7">
						<div class="mb-5 text-[#4E9E5A]/50"><?php echo $iga_contact_icon( 'quote', 'h-8 w-8' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<blockquote class="flex-1 text-sm italic leading-7 text-white/65">“<?php echo esc_html( $testimonial['quote'] ); ?>”</blockquote>
						<div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-white/[0.07] pt-5">
							<div class="flex items-center gap-3">
								<span class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-[#242424] font-['Bebas_Neue'] text-lg text-white"><?php echo esc_html( $testimonial['initials'] ); ?></span>
								<span><strong class="block text-sm text-white"><?php echo esc_html( $testimonial['name'] ); ?></strong><small class="block text-[10px] uppercase tracking-[0.12em] text-white/35"><?php echo esc_html( $testimonial['location'] ); ?></small></span>
							</div>
							<span class="rounded-full border border-[#3A7D44]/40 bg-[#3A7D44]/10 px-3 py-1 text-[9px] font-bold uppercase tracking-[0.1em] text-[#4E9E5A]"><?php echo esc_html( $testimonial['result'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="bg-[#141414] px-6 py-20 text-center sm:px-10 lg:px-20 lg:py-28 xl:px-28">
		<div class="mx-auto max-w-3xl">
			<h2 class="font-['Bebas_Neue'] text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">Ready To Move?</h2>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">Don't wait for a reply — choose your membership or book your first drop-in session directly.</p>
			<div class="mt-8 flex flex-wrap justify-center gap-3">
				<a href="<?php echo esc_url( home_url( '/training/' ) . '#pricing' ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#3A7D44] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-[#4E9E5A] hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
					<?php echo $iga_contact_icon( 'medal', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> Enlist Now
				</a>
				<a href="<?php echo esc_url( home_url( '/book/' ) ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:border-white/30 hover:bg-white/5">
					<?php echo $iga_contact_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> Book a Drop-In
				</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>