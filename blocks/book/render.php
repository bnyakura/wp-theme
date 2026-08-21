<?php
/**
 * Book Assessment block — render template.
 *
 * A short lead-capture form (name, email, phone, DOB, gender). On submit the
 * details are saved to a Google Sheet (via the Apps Script webhook set in
 * Appearance → Customize → Site Identity) and the visitor is handed off to
 * WhatsApp with the details pre-filled, so a coach can confirm the booking.
 *
 * Form state (success / error / posted values) comes from the shared handler
 * in inc/page-forms.php, which runs on `template_redirect` so redirects keep
 * working even though this block renders after the header.
 *
 * @package Iron_Gorilla
 */

$state                = iga_assessment_form_state();
$iga_success_booking  = $state['success'];
$iga_assessment_error = $state['error'];
$iga_posted           = $state['posted'];
$iga_genders          = iga_assessment_genders();

$iga_book_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title'    => get_field( 'hero_title' ),
	'subtitle' => get_field( 'hero_subtitle' ),
);

$iga_book_hero['eyebrow']  = $iga_book_hero['eyebrow'] ?: 'Book Assessment';
$iga_book_hero['title']    = $iga_book_hero['title'] ?: 'Claim Your Spot. Show Up Ready.';
$iga_book_hero['subtitle'] = $iga_book_hero['subtitle'] ?: "Your first session is free. Fill in your details and we'll confirm your booking personally on WhatsApp.";

$iga_booking_icon = static function ( $name, $classes = 'h-5 w-5' ) {
	$paths = array(
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
		'check'    => '<path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4.25 4.25L19 6.5"/>',
		'user'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Z"/>',
		'mail'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Zm0 0 9.75 6.75 9.75-6.75"/>',
		'phone'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 0 0 2.25-2.25v-1.372a1.5 1.5 0 0 0-1.061-1.435l-4.05-1.215a1.5 1.5 0 0 0-1.559.44l-.812 1a12.03 12.03 0 0 1-5.235-5.235l1-.812a1.5 1.5 0 0 0 .44-1.559L8.508 4.311A1.5 1.5 0 0 0 7.073 3.25H5.7a2.25 2.25 0 0 0-2.25 2.25v1.25Z"/>',
		'arrow'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m5-5-5 5 5 5"/>',
		'whatsapp' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 11.6a8.25 8.25 0 0 1-12.2 7.25L3.75 20l1.15-4.15A8.25 8.25 0 1 1 20.25 11.6Zm-11-4.1c.2 3.7 3.1 6.6 6.8 6.8"/>',
		'chevron-down' => '<path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['check'];
	return sprintf( '<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>', esc_attr( $classes ), $path );
};

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-book overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Page hero -->
	<section class="border-b border-line bg-s1 px-4.5 pb-12 pt-15 text-center min-[481px]:px-[5vw] min-[481px]:pb-16 min-[481px]:pt-20">
		<div class="mx-auto max-w-4xl">
			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-green"></span>
				<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l"><?php echo esc_html( $iga_book_hero['eyebrow'] ); ?></span>
				<span class="h-px w-10 bg-green"></span>
			</div>
			<h1 class="font-display uppercase leading-none tracking-[0.04em] text-white text-[clamp(1.8rem,8vw,2.6rem)] min-[481px]:text-[clamp(2rem,4vw,3.5rem)]"><?php echo esc_html( $iga_book_hero['title'] ); ?></h1>
			<p class="mx-auto mt-5 max-w-2xl leading-7 text-white/50 text-[0.93rem] min-[481px]:text-[0.95rem] min-[769px]:text-base"><?php echo esc_html( $iga_book_hero['subtitle'] ); ?></p>
		</div>
	</section>

	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-xl">
			<?php if ( is_array( $iga_success_booking ) ) : ?>
				<!-- Success screen -->
				<div class="text-center">
					<div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full border border-green/50 bg-green/10 text-green-l">
						<?php echo $iga_booking_icon( 'check', 'h-9 w-9' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<h2 class="font-display text-5xl uppercase tracking-wide text-white">You're On The List.</h2>
					<p class="mx-auto mt-4 max-w-md text-base leading-7 text-white/50">Taking you to WhatsApp to confirm your booking with a coach&hellip;</p>

					<div class="mt-8 rounded-xl border border-green/40 bg-[#0F1F11] p-6 text-left">
						<p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-green-l">Your Details</p>
						<?php
						$success_rows = array(
							array( 'user', trim( $iga_success_booking['first_name'] . ' ' . $iga_success_booking['last_name'] ) ),
							array( 'mail', $iga_success_booking['email'] ),
							array( 'phone', $iga_success_booking['phone'] ),
							array( 'calendar', $iga_success_booking['dob'] . ' · ' . $iga_success_booking['gender'] ),
						);
						foreach ( $success_rows as $row ) :
							if ( ! $row[1] ) {
								continue;
							}
							?>
							<div class="mt-3 flex items-center gap-3 text-sm text-white/65">
								<span class="text-green-l"><?php echo $iga_booking_icon( $row[0], 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<?php echo esc_html( $row[1] ); ?>
							</div>
						<?php endforeach; ?>
					</div>

					<a id="iga-assessment-whatsapp" href="<?php echo esc_url( $iga_success_booking['whatsapp_url'] ); ?>" class="mt-8 inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
						<?php echo $iga_booking_icon( 'whatsapp', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Continue to WhatsApp
					</a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-4 inline-flex min-h-11 items-center justify-center gap-2 rounded-full border border-white/15 px-6 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:border-white/30 hover:bg-white/5">
						<?php echo $iga_booking_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Back to Home
					</a>
				</div>
				<script>
				document.addEventListener('DOMContentLoaded', function () {
					var link = document.getElementById('iga-assessment-whatsapp');
					if (!link) return;
					window.setTimeout(function () {
						window.location.href = link.href;
					}, 1200);
				});
				</script>
			<?php else : ?>
				<?php if ( $iga_assessment_error ) : ?>
					<div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm leading-6 text-red-300" role="alert">
						<?php echo esc_html( $iga_assessment_error ); ?>
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="space-y-5">
					<?php wp_nonce_field( 'iga_submit_assessment', 'iga_assessment_nonce' ); ?>
					<input type="hidden" name="iga_assessment_submit" value="1">
					<div class="absolute -left-[9999px]" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

					<div class="grid grid-cols-1 gap-5 min-[481px]:grid-cols-2">
						<div>
							<label for="assessment-first-name" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">First Name</label>
							<input id="assessment-first-name" type="text" name="first_name" value="<?php echo esc_attr( $iga_posted['first_name'] ); ?>" placeholder="Your first name" autocomplete="given-name" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-green-l focus:ring-2 focus:ring-green/20">
						</div>
						<div>
							<label for="assessment-last-name" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">Last Name</label>
							<input id="assessment-last-name" type="text" name="last_name" value="<?php echo esc_attr( $iga_posted['last_name'] ); ?>" placeholder="Your last name" autocomplete="family-name" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-green-l focus:ring-2 focus:ring-green/20">
						</div>
					</div>

					<div>
						<label for="assessment-email" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">Email Address</label>
						<input id="assessment-email" type="email" name="email" value="<?php echo esc_attr( $iga_posted['email'] ); ?>" placeholder="your@email.com" autocomplete="email" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-green-l focus:ring-2 focus:ring-green/20">
					</div>

					<div>
						<label for="assessment-phone" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">Phone Number</label>
						<input id="assessment-phone" type="tel" name="phone" value="<?php echo esc_attr( $iga_posted['phone'] ); ?>" placeholder="+27 XX XXX XXXX" autocomplete="tel" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-green-l focus:ring-2 focus:ring-green/20">
					</div>

					<div>
						<label for="assessment-dob" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">Date of Birth</label>
						<input id="assessment-dob" type="date" name="dob" value="<?php echo esc_attr( $iga_posted['dob'] ); ?>" max="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>" autocomplete="bday" required class="w-full rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-green-l focus:ring-2 focus:ring-green/20 [color-scheme:dark]">
					</div>

					<div>
						<label for="assessment-gender" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">Gender</label>
						<div class="relative">
							<select id="assessment-gender" name="gender" required class="w-full appearance-none rounded-xl border border-white/10 bg-s1 px-5 py-4 text-sm text-white outline-none transition focus:border-green-l focus:ring-2 focus:ring-green/20 [color-scheme:dark]">
								<option value="" disabled <?php selected( $iga_posted['gender'], '' ); ?>>Select gender</option>
								<?php foreach ( $iga_genders as $gender_value => $gender_label ) : ?>
									<option value="<?php echo esc_attr( $gender_value ); ?>" <?php selected( $iga_posted['gender'], $gender_value ); ?>><?php echo esc_html( $gender_label ); ?></option>
								<?php endforeach; ?>
							</select>
							<span class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-white/40">
								<?php echo $iga_booking_icon( 'chevron-down', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</div>
					</div>

					<div class="flex gap-3 rounded-r-xl border-l-2 border-green bg-s2 px-4 py-3 text-xs leading-6 text-white/40">
						<span class="mt-1 shrink-0 text-green-l"><?php echo $iga_booking_icon( 'whatsapp', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						After you press Book, we'll open WhatsApp with your details so a coach can confirm your slot.
					</div>

					<button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
						<?php echo $iga_booking_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Book
					</button>
					<p class="text-center text-[10px] leading-5 text-white/30">By submitting you agree to receive communications from Iron Gorilla Army.</p>
				</form>
			<?php endif; ?>
		</div>
	</section>
</div>
