<?php
/**
 * Contact block — render template.
 *
 * Reads ACF fields and falls back to the original Iron Gorilla content, so
 * the page looks complete the moment the theme is activated.
 *
 * Form state (success / error / posted values / subject preselection) comes
 * from the shared handler in inc/page-forms.php, which runs on
 * `template_redirect` so redirects keep working even though this block
 * renders after the header.
 *
 * @package Iron_Gorilla
 */

$state            = iga_contact_form_state();
$iga_success      = $state['success'];
$iga_error        = $state['error'];
$iga_posted       = $state['posted'];

$iga_contact_details = iga_contact_details();
$iga_contact_subjects = iga_contact_subjects();

$iga_contact_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title'    => get_field( 'hero_title' ),
	'subtitle' => get_field( 'hero_subtitle' ),
);

$iga_contact_hero['eyebrow']  = $iga_contact_hero['eyebrow'] ?: 'Dispatch';
$iga_contact_hero['title']    = $iga_contact_hero['title'] ?: 'Establish Contact';
$iga_contact_hero['subtitle'] = $iga_contact_hero['subtitle'] ?: 'Questions about training, enlistment, or the Armory? Send a dispatch. Our team responds within 24 hours.';

$iga_contact_hours = get_field( 'hours' );
$iga_contact_hours = $iga_contact_hours ?: 'Mon – Sat: 6AM – 9PM | Sunday: Closed';

$iga_testimonials = array(
	array(
		'initials' => 'K',
		'name'     => 'Kamva',
		'location' => 'Fisantekraal',
		'quote'    => 'Iron Gorilla is more than a brotherhood. The community pushes me to stay fit and always want to be better. We are an amalgam of aggression and compassion — exactly what I needed. I feel safe. I feel part of something.',
		'result'   => 'Member since age 18',
	),
	array(
		'initials' => 'D',
		'name'     => 'Deogracias',
		'location' => 'Observatory',
		'quote'    => "I've lost 10kg being part of this community. What kept me going was knowing everyone here is on their own journey of self-betterment. It's not about the weight — it's about the journey everyone is on.",
		'result'   => 'Lost 10kg · Since 2020',
	),
	array(
		'initials' => 'M',
		'name'     => 'Micah',
		'location' => 'Khayelitsha',
		'quote'    => "I sometimes feel misunderstood. But Iron Gorilla has challenged me — not just physically in the boxing classes, but mentally too. That's the difference that keeps me coming back.",
		'result'   => 'Physically & Mentally Challenged',
	),
);

$iga_testimonials_acf = get_field( 'testimonials' );
if ( is_array( $iga_testimonials_acf ) && ! empty( $iga_testimonials_acf ) ) {
	$iga_testimonials = array();
	foreach ( $iga_testimonials_acf as $testimonial ) {
		if ( empty( $testimonial['quote'] ) ) {
			continue;
		}
		$iga_testimonials[] = array(
			'initials' => ! empty( $testimonial['initials'] ) ? $testimonial['initials'] : '',
			'name'     => isset( $testimonial['name'] ) ? $testimonial['name'] : '',
			'location' => isset( $testimonial['location'] ) ? $testimonial['location'] : '',
			'quote'    => $testimonial['quote'],
			'result'   => isset( $testimonial['result'] ) ? $testimonial['result'] : '',
		);
	}
}

$iga_contact_cta = array(
	'eyebrow'   => get_field( 'cta_eyebrow' ),
	'title'     => get_field( 'cta_title' ),
	'subtitle'  => get_field( 'cta_subtitle' ),
);

$iga_contact_cta['eyebrow']  = $iga_contact_cta['eyebrow'] ?: '';
$iga_contact_cta['title']    = $iga_contact_cta['title'] ?: 'Ready To Move?';
$iga_contact_cta['subtitle'] = $iga_contact_cta['subtitle'] ?: "Don't wait for a reply — choose your membership or book your first drop-in session directly.";

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
	<div class="mx-auto mb-12 max-w-3xl text-center">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-green"></span>
			<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l"><?php echo esc_html( $eyebrow ); ?></span>
			<span class="h-px w-10 bg-green"></span>
		</div>
		<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl"><?php echo esc_html( $title ); ?></h2>
		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
	<?php
};

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-contact overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Page hero -->
	<section class="border-b border-line bg-s1 px-4.5 pt-15 pb-12 text-center min-[481px]:px-[5vw] min-[481px]:pt-20 min-[481px]:pb-16">
		<div class="mx-auto max-w-3xl">
			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-green"></span>
				<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l"><?php echo esc_html( $iga_contact_hero['eyebrow'] ); ?></span>
				<span class="h-px w-10 bg-green"></span>
			</div>
			<h1 class="font-display text-5xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl"><?php echo esc_html( $iga_contact_hero['title'] ); ?></h1>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base"><?php echo esc_html( $iga_contact_hero['subtitle'] ); ?></p>
		</div>
	</section>

	<!-- Contact information and form -->
	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto grid max-w-[1200px] grid-cols-1 gap-10 min-[1081px]:grid-cols-2">
			<!-- Headquarters -->
			<div class="rounded-2xl border border-line bg-s2 px-[18px] py-6 min-[481px]:px-6 min-[481px]:py-8 min-[769px]:p-[50px]">
				<h2 class="mb-8 font-display text-4xl uppercase tracking-wide text-white">Headquarters</h2>

				<?php
				$info_rows = array(
					array( 'location', 'Location', $iga_contact_details['address'], '' ),
					array( 'email', 'Email', $iga_contact_details['email'], 'mailto:' . $iga_contact_details['email'] ),
					array( 'phone', 'Comm-Line', $iga_contact_details['phone_text'], 'tel:' . $iga_contact_details['phone'] ),
					array( 'whatsapp', 'WhatsApp', $iga_contact_details['phone_text'], 'https://wa.me/' . $iga_contact_details['whatsapp'] ),
					array( 'clock', 'Hours', $iga_contact_hours, '' ),
				);
				foreach ( $info_rows as $row ) :
					?>
					<div class="mb-7 flex items-start gap-[14px] last:mb-0 min-[481px]:gap-5">
						<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-green/40 bg-green/10 text-green-l min-[481px]:h-[50px] min-[481px]:w-[50px]">
							<?php echo $iga_contact_icon( $row[0], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="min-w-0 pt-1">
							<strong class="mb-1 block text-[10px] font-bold uppercase tracking-[0.16em] text-white"><?php echo esc_html( $row[1] ); ?></strong>
							<?php if ( $row[3] ) : ?>
								<a href="<?php echo esc_url( $row[3] ); ?>" <?php echo 'whatsapp' === $row[0] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="text-sm leading-6 text-white/50 transition hover:text-green-l"><?php echo esc_html( $row[2] ); ?></a>
							<?php else : ?>
								<span class="block text-sm leading-6 text-white/50"><?php echo esc_html( $row[2] ); ?></span>
							<?php endif; ?>
						</span>
					</div>
				<?php endforeach; ?>

				<div class="mt-8 border-t border-line pt-6">
					<p class="mb-4 text-[10px] font-bold uppercase tracking-[0.18em] text-white/35">Follow The Army</p>
					<a href="<?php echo esc_url( $iga_contact_details['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Follow Iron Gorilla Army on Instagram" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-white/40 transition hover:border-white/30 hover:bg-white/5 hover:text-white">
						<?php echo $iga_contact_icon( 'instagram', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
			</div>

			<!-- Dispatch form -->
			<div class="rounded-2xl border border-line bg-s3 px-[18px] py-6 min-[481px]:px-6 min-[481px]:py-8 min-[769px]:p-[50px]">
				<?php if ( $iga_success ) : ?>
					<div class="flex h-full min-h-[420px] flex-col items-center justify-center text-center">
						<span class="mb-5 flex h-16 w-16 items-center justify-center rounded-full border border-green/50 bg-green/10 text-green-l">
							<?php echo $iga_contact_icon( 'check', 'h-9 w-9' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<h2 class="font-display text-4xl uppercase tracking-wide text-white">Dispatch Received</h2>
						<p class="mt-3 max-w-sm text-sm leading-7 text-white/45">We'll be in contact within 24 hours. Prepare to enlist.</p>
					</div>
				<?php else : ?>
					<h2 class="mb-7 font-display text-4xl uppercase tracking-wide text-white">Send a Dispatch</h2>

					<?php if ( $iga_error ) : ?>
						<div class="mb-5 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm leading-6 text-red-300" role="alert"><?php echo esc_html( $iga_error ); ?></div>
					<?php endif; ?>

					<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="space-y-5">
						<?php wp_nonce_field( 'iga_submit_contact', 'iga_contact_nonce' ); ?>
						<input type="hidden" name="iga_contact_submit" value="1">
						<div class="absolute -left-[9999px]" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

						<div>
							<label for="contact-name" class="sr-only">Your Name</label>
							<input id="contact-name" type="text" name="contact_name" value="<?php echo esc_attr( $iga_posted['name'] ); ?>" placeholder="Your Name" autocomplete="name" maxlength="100" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-green-l focus:ring-2 focus:ring-green/20">
						</div>
						<div>
							<label for="contact-email" class="sr-only">Your Email</label>
							<input id="contact-email" type="email" name="contact_email" value="<?php echo esc_attr( $iga_posted['email'] ); ?>" placeholder="Your Email" autocomplete="email" maxlength="254" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-green-l focus:ring-2 focus:ring-green/20">
						</div>
						<div>
							<label for="contact-phone" class="sr-only">Phone Number</label>
							<input id="contact-phone" type="tel" name="contact_phone" value="<?php echo esc_attr( $iga_posted['phone'] ); ?>" placeholder="Phone Number (optional)" autocomplete="tel" maxlength="30" class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-green-l focus:ring-2 focus:ring-green/20">
						</div>
						<div>
							<label for="contact-subject" class="sr-only">Subject</label>
							<select id="contact-subject" name="contact_subject" class="w-full cursor-pointer rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white/70 outline-none transition focus:border-green-l focus:ring-2 focus:ring-green/20">
								<option value="">Subject — What's this about?</option>
								<?php foreach ( $iga_contact_subjects as $key => $label ) : ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $iga_posted['subject'], $key ); ?>><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div>
							<label for="contact-message" class="sr-only">Your Message</label>
							<textarea id="contact-message" name="contact_message" placeholder="Your message..." rows="6" maxlength="2000" required class="w-full resize-y rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/25 focus:border-green-l focus:ring-2 focus:ring-green/20"><?php echo esc_textarea( $iga_posted['message'] ); ?></textarea>
						</div>
						<button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
							Send Dispatch <?php echo $iga_contact_icon( 'send', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Testimonials -->
	<section id="testimonials" class="border-y border-line bg-s1 px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[1280px]">
			<?php $iga_contact_section_header( 'What Members Say', 'The Brotherhood Speaks', 'Not endorsements — honest accounts from members who showed up and did the work.' ); ?>
			<div class="grid grid-cols-1 gap-3 min-[768px]:grid-cols-1 min-[481px]:grid-cols-2 min-[769px]:gap-4 min-[1081px]:grid-cols-3">
				<?php foreach ( $iga_testimonials as $testimonial ) : ?>
					<article class="flex h-full flex-col rounded-2xl border border-line bg-s2 p-7">
						<div class="mb-5 text-green-l/50"><?php echo $iga_contact_icon( 'quote', 'h-8 w-8' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<blockquote class="flex-1 text-sm italic leading-7 text-white/65">&ldquo;<?php echo esc_html( $testimonial['quote'] ); ?>&rdquo;</blockquote>
						<div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-5">
							<div class="flex items-center gap-3">
								<span class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-s3 font-display text-lg text-white"><?php echo esc_html( $testimonial['initials'] ); ?></span>
								<span><strong class="block text-sm text-white"><?php echo esc_html( $testimonial['name'] ); ?></strong><small class="block text-[10px] uppercase tracking-[0.12em] text-white/35"><?php echo esc_html( $testimonial['location'] ); ?></small></span>
							</div>
							<span class="rounded-full border border-green/40 bg-green/10 px-3 py-1 text-[9px] font-bold uppercase tracking-[0.1em] text-green-l"><?php echo esc_html( $testimonial['result'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="bg-s1 px-4.5 py-15 text-center min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-3xl">
			<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl"><?php echo esc_html( $iga_contact_cta['title'] ); ?></h2>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base"><?php echo esc_html( $iga_contact_cta['subtitle'] ); ?></p>
			<div class="mt-8 flex flex-wrap justify-center gap-3">
				<a href="<?php echo esc_url( iga_get_whatsapp_group_url() ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
					<?php echo $iga_contact_icon( 'medal', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> Join Community
				</a>
				<a href="<?php echo esc_url( home_url( '/book/' ) ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:border-white/30 hover:bg-white/5">
					<?php echo $iga_contact_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> Book a Drop-In
				</a>
			</div>
		</div>
	</section>
</div>
