<?php
/**
 * Template Name: Book a Drop-In
 * Template Post Type: page
 *
 * Tailwind WordPress version of the Iron Gorilla Army /book page.
 * Includes a self-contained WordPress booking form and email handler.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

$iga_quick_classes = array(
	'entrepreneurship' => array(
		'name'        => 'Entrepreneurship Class',
		'coach'       => 'Paul O',
		'schedule'    => 'Mondays · 18:00',
		'duration'    => '90 min',
		'icon'        => 'brain',
		'card_class'  => 'border-white/[0.09] hover:border-[#5AC2A8]/40 hover:bg-[#5AC2A8]/[0.06]',
		'icon_class'  => 'border-[#5AC2A8]/30 bg-[#5AC2A8]/10 text-[#5AC2A8]',
	),
	'boxing' => array(
		'name'        => 'Boxing',
		'coach'       => 'Rhema M',
		'schedule'    => 'Mon · Tue · Thu evenings',
		'duration'    => '60 min',
		'icon'        => 'boxing',
		'card_class'  => 'border-white/[0.09] hover:border-[#5A7EC2]/40 hover:bg-[#5A7EC2]/[0.06]',
		'icon_class'  => 'border-[#5A7EC2]/30 bg-[#5A7EC2]/10 text-[#5A7EC2]',
	),
	'strength' => array(
		'name'        => 'Strength & Muscle',
		'coach'       => 'Abongile M',
		'schedule'    => 'Mon – Fri · 06:00 & 07:00',
		'duration'    => '60 min',
		'icon'        => 'dumbbell',
		'card_class'  => 'border-white/[0.09] hover:border-[#4E9E5A]/40 hover:bg-[#4E9E5A]/[0.06]',
		'icon_class'  => 'border-[#4E9E5A]/30 bg-[#4E9E5A]/10 text-[#4E9E5A]',
	),
	'hiit' => array(
		'name'        => 'Strength & HIIT',
		'coach'       => 'Othniel M',
		'schedule'    => 'Mon · Wed · 18:30 & 19:30',
		'duration'    => '60 min',
		'icon'        => 'bolt',
		'card_class'  => 'border-white/[0.09] hover:border-[#C25A5A]/40 hover:bg-[#C25A5A]/[0.06]',
		'icon_class'  => 'border-[#C25A5A]/30 bg-[#C25A5A]/10 text-[#C25A5A]',
	),
);

$iga_weekly_schedule = array(
	1 => array(
		array( 'time' => '06:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 6, 'type' => 'strength' ),
		array( 'time' => '07:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 5, 'type' => 'strength' ),
		array( 'time' => '18:00', 'duration' => 90, 'name' => 'Entrepreneurship Class', 'coach' => 'Paul O', 'capacity' => 10, 'type' => 'entrepreneurship' ),
		array( 'time' => '18:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
		array( 'time' => '18:30', 'duration' => 60, 'name' => 'Strength & HIIT', 'coach' => 'Othniel M', 'capacity' => 5, 'type' => 'hiit' ),
		array( 'time' => '19:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
		array( 'time' => '19:30', 'duration' => 60, 'name' => 'Strength & HIIT', 'coach' => 'Othniel M', 'capacity' => 5, 'type' => 'hiit' ),
		array( 'time' => '20:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
	),
	2 => array(
		array( 'time' => '06:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 6, 'type' => 'strength' ),
		array( 'time' => '07:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 5, 'type' => 'strength' ),
		array( 'time' => '18:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
		array( 'time' => '19:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
		array( 'time' => '20:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
	),
	3 => array(
		array( 'time' => '06:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 6, 'type' => 'strength' ),
		array( 'time' => '07:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 5, 'type' => 'strength' ),
		array( 'time' => '18:30', 'duration' => 60, 'name' => 'Strength & HIIT', 'coach' => 'Othniel M', 'capacity' => 5, 'type' => 'hiit' ),
		array( 'time' => '19:30', 'duration' => 60, 'name' => 'Strength & HIIT', 'coach' => 'Othniel M', 'capacity' => 5, 'type' => 'hiit' ),
	),
	4 => array(
		array( 'time' => '06:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 6, 'type' => 'strength' ),
		array( 'time' => '07:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 5, 'type' => 'strength' ),
		array( 'time' => '18:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
		array( 'time' => '19:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
		array( 'time' => '20:00', 'duration' => 60, 'name' => 'Boxing', 'coach' => 'Rhema M', 'capacity' => 5, 'type' => 'boxing' ),
	),
	5 => array(
		array( 'time' => '06:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 6, 'type' => 'strength' ),
		array( 'time' => '07:00', 'duration' => 60, 'name' => 'Strength & Muscle', 'coach' => 'Abongile M', 'capacity' => 5, 'type' => 'strength' ),
	),
	6 => array(),
);

$iga_weekly_schedule = apply_filters( 'iga_booking_schedule', $iga_weekly_schedule );
$iga_booking_error   = '';

/* Process the booking before header output, allowing a safe redirect. */
if ( 'POST' === strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) && isset( $_POST['iga_booking_submit'] ) ) {
	$nonce      = isset( $_POST['iga_booking_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iga_booking_nonce'] ) ) : '';
	$honeypot   = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, 'iga_submit_booking' ) ) {
		$iga_booking_error = 'Your session expired. Please refresh the page and try again.';
	} elseif ( $honeypot ) {
		$iga_booking_error = 'Unable to submit this booking.';
	} else {
		$mode  = isset( $_POST['booking_mode'] ) ? sanitize_key( wp_unslash( $_POST['booking_mode'] ) ) : '';
		$name  = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
		$phone = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

		if ( ! $name || ! $phone || ! is_email( $email ) || ! in_array( $mode, array( 'quick', 'calendar' ), true ) ) {
			$iga_booking_error = 'Please complete your name, WhatsApp number, and a valid email address.';
		} else {
			$booking = array(
				'mode'     => $mode,
				'name'     => $name,
				'phone'    => $phone,
				'email'    => $email,
				'date'     => '',
				'session'  => '',
				'coach'    => '',
				'time'     => '',
				'duration' => '',
			);

			if ( 'quick' === $mode ) {
				$class_id = isset( $_POST['booking_class'] ) ? sanitize_key( wp_unslash( $_POST['booking_class'] ) ) : '';
				if ( ! isset( $iga_quick_classes[ $class_id ] ) ) {
					$iga_booking_error = 'Please choose a class before submitting.';
				} else {
					$class               = $iga_quick_classes[ $class_id ];
					$booking['session']  = $class['name'];
					$booking['coach']    = $class['coach'];
					$booking['date']     = $class['schedule'];
					$booking['duration'] = $class['duration'];
					$booking['time']     = 'Confirmed via WhatsApp';
				}
			} else {
				$submitted_date    = isset( $_POST['booking_date'] ) ? sanitize_text_field( wp_unslash( $_POST['booking_date'] ) ) : '';
				$submitted_session = isset( $_POST['booking_session'] ) ? sanitize_text_field( wp_unslash( $_POST['booking_session'] ) ) : '';
				$submitted_time    = isset( $_POST['booking_time'] ) ? sanitize_text_field( wp_unslash( $_POST['booking_time'] ) ) : '';
				$date_object       = preg_match( '/^\d{4}-\d{2}-\d{2}$/', $submitted_date )
					? DateTimeImmutable::createFromFormat( '!Y-m-d', $submitted_date, wp_timezone() )
					: false;
				$today             = new DateTimeImmutable( 'today', wp_timezone() );
				$last_booking_day  = $today->modify( '+35 days' );
				$valid_session     = null;

				if ( $date_object && $date_object >= $today && $date_object <= $last_booking_day && 0 !== (int) $date_object->format( 'w' ) ) {
					$day_schedule = isset( $iga_weekly_schedule[ (int) $date_object->format( 'w' ) ] )
						? $iga_weekly_schedule[ (int) $date_object->format( 'w' ) ]
						: array();

					foreach ( $day_schedule as $scheduled_session ) {
						$session_time = DateTimeImmutable::createFromFormat( 'H:i', $scheduled_session['time'], wp_timezone() );
						$display_time = $session_time ? $session_time->format( 'g:i A' ) : $scheduled_session['time'];
						if ( $submitted_session === $scheduled_session['name'] && $submitted_time === $display_time ) {
							$valid_session = $scheduled_session;
							break;
						}
					}
				}

				if ( ! $valid_session ) {
					$iga_booking_error = 'Please select a valid upcoming date and session before submitting.';
				} else {
					$booking['date']     = $date_object->format( 'l, j F Y' );
					$booking['session']  = $valid_session['name'];
					$booking['coach']    = $valid_session['coach'];
					$booking['time']     = $submitted_time;
					$booking['duration'] = $valid_session['duration'] . ' min';
				}
			}

			if ( ! $iga_booking_error ) {
				$recipient = apply_filters( 'iga_booking_recipient', get_option( 'admin_email' ) );
				$subject   = sprintf( 'New Forge booking: %s — %s', $booking['session'], $booking['name'] );
				$message   = "A new booking was submitted from the Iron Gorilla Army website.\n\n";
				$message  .= "Name: {$booking['name']}\n";
				$message  .= "WhatsApp: {$booking['phone']}\n";
				$message  .= "Email: {$booking['email']}\n";
				$message  .= "Booking type: {$booking['mode']}\n";
				$message  .= "Session: {$booking['session']}\n";
				$message  .= "Coach: {$booking['coach']}\n";
				$message  .= "Date / schedule: {$booking['date']}\n";
				$message  .= "Time: {$booking['time']}\n";
				$message  .= "Duration: {$booking['duration']}\n";
				$headers   = array( 'Reply-To: ' . $booking['name'] . ' <' . $booking['email'] . '>' );

				$mail_sent = wp_mail( $recipient, $subject, $message, $headers );
				do_action( 'iga_booking_submitted', $booking, $mail_sent );

				if ( $mail_sent ) {
					$reference = wp_generate_uuid4();
					set_transient( 'iga_booking_' . md5( $reference ), $booking, 15 * MINUTE_IN_SECONDS );
					wp_safe_redirect(
						add_query_arg(
							array(
								'booking'     => 'success',
								'booking_ref' => $reference,
							),
							get_permalink()
						)
					);
					exit;
				}

				$iga_booking_error = 'Something went wrong. Please try again or contact us on WhatsApp.';
			}
		}
	}
}

$iga_success_booking = null;
if ( isset( $_GET['booking'], $_GET['booking_ref'] ) && 'success' === sanitize_key( wp_unslash( $_GET['booking'] ) ) ) {
	$reference           = sanitize_text_field( wp_unslash( $_GET['booking_ref'] ) );
	$iga_success_booking = get_transient( 'iga_booking_' . md5( $reference ) );
}

wp_enqueue_style(
	'iga-book-fonts',
	'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
	array(),
	null
);

get_header();

$iga_booking_icon = static function ( $name, $classes = 'h-5 w-5' ) {
	$paths = array(
		'bolt'     => '<path stroke-linecap="round" stroke-linejoin="round" d="m13.5 2.25-8.25 11.5h6l-.75 8 8.25-12h-6l.75-7.5Z"/>',
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
		'brain'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.5 4.5A3 3 0 0 0 4 6.25a3 3 0 0 0-.25 5.5A3.5 3.5 0 0 0 7 17.5V18a3 3 0 0 0 5 2.25V3.75A3 3 0 0 0 9.5 4.5Zm5 0A3 3 0 0 1 20 6.25a3 3 0 0 1 .25 5.5A3.5 3.5 0 0 1 17 17.5V18a3 3 0 0 1-5 2.25V3.75a3 3 0 0 1 2.5.75Z"/>',
		'boxing'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.25 11.25V7.5A2.25 2.25 0 0 1 9.75 7v-1a2.25 2.25 0 0 1 4.5 0v1a2.25 2.25 0 0 1 4.5.5v5.25c0 4.5-2.75 8.25-7.5 8.25-4 0-7.5-3-7.5-7.5v-1.25a1.5 1.5 0 0 1 1.5-1.5Z"/>',
		'dumbbell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'chevron'  => '<path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>',
		'check'    => '<path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4.25 4.25L19 6.5"/>',
		'user'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Z"/>',
		'clock'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',
		'info'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m0-9h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',
		'arrow'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m5-5-5 5 5 5"/>',
		'whatsapp' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 11.6a8.25 8.25 0 0 1-12.2 7.25L3.75 20l1.15-4.15A8.25 8.25 0 1 1 20.25 11.6Zm-11-4.1c.2 3.7 3.1 6.6 6.8 6.8"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['check'];
	return sprintf( '<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>', esc_attr( $classes ), $path );
};

$iga_booking_dates = array();
$iga_today_date    = new DateTimeImmutable( 'today', wp_timezone() );
$cursor            = $iga_today_date;
while ( count( $iga_booking_dates ) < 28 ) {
	if ( 0 !== (int) $cursor->format( 'w' ) ) {
		$iga_booking_dates[] = $cursor;
	}
	$cursor = $cursor->modify( '+1 day' );
}
$iga_default_date = $iga_booking_dates[0]->format( 'Y-m-d' );
?>

<main id="primary" class="overflow-hidden bg-[#0A0A0A] font-['DM_Sans'] text-[#F2F2F2] antialiased">
	<!-- Page hero -->
	<section class="border-b border-white/[0.07] bg-[#141414] px-6 py-20 text-center sm:px-10 lg:px-20 lg:py-24 xl:px-28">
		<div class="mx-auto max-w-4xl">
			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-[#3A7D44]"></span>
				<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]">Book a Drop-In</span>
				<span class="h-px w-10 bg-[#3A7D44]"></span>
			</div>
			<h1 class="font-['Bebas_Neue'] text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl">Claim Your Spot. Show Up Ready.</h1>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">Your first session is free. Fill in your details and we'll confirm your booking personally within 24 hours.</p>
		</div>
	</section>

	<section class="px-6 py-20 sm:px-10 lg:px-20 lg:py-24 xl:px-28">
		<div class="mx-auto max-w-xl">
			<?php if ( is_array( $iga_success_booking ) ) : ?>
				<!-- Success screen -->
				<div class="text-center">
					<div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full border border-[#3A7D44]/50 bg-[#3A7D44]/10 text-[#4E9E5A]">
						<?php echo $iga_booking_icon( 'check', 'h-9 w-9' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<h2 class="font-['Bebas_Neue'] text-5xl uppercase tracking-wide text-white">You're On The List.</h2>
					<p class="mx-auto mt-4 max-w-md text-sm leading-7 text-white/50 sm:text-base">We'll confirm your spot personally via WhatsApp. Show up ready.</p>

					<div class="mt-8 rounded-xl border border-[#3A7D44]/40 bg-[#0F1F11] p-6 text-left">
						<p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-[#4E9E5A]">Your Booking</p>
						<?php
						$success_rows = array(
							array( 'calendar', $iga_success_booking['date'] ),
							array( 'dumbbell', $iga_success_booking['session'] ),
							array( 'user', $iga_success_booking['coach'] ),
							array( 'clock', trim( $iga_success_booking['time'] . ' · ' . $iga_success_booking['duration'], ' ·' ) ),
						);
						foreach ( $success_rows as $row ) :
							if ( ! $row[1] ) {
								continue;
							}
							?>
							<div class="mt-3 flex items-center gap-3 text-sm text-white/65">
								<span class="text-[#4E9E5A]"><?php echo $iga_booking_icon( $row[0], 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<?php echo esc_html( $row[1] ); ?>
							</div>
						<?php endforeach; ?>
					</div>

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-8 inline-flex min-h-11 items-center justify-center gap-2 rounded-full border border-white/15 px-6 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:border-white/30 hover:bg-white/5">
						<?php echo $iga_booking_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Back to Home
					</a>
				</div>
			<?php else : ?>
				<?php if ( $iga_booking_error ) : ?>
					<div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm leading-6 text-red-300" role="alert">
						<?php echo esc_html( $iga_booking_error ); ?>
					</div>
				<?php endif; ?>

				<!-- Mode switcher -->
				<div class="mb-9 grid grid-cols-2 gap-1 rounded-xl border border-white/10 bg-[#1C1C1C] p-1">
					<button type="button" data-book-mode="quick" class="flex items-center justify-center gap-2 rounded-lg bg-[#3A7D44] px-3 py-3 text-xs font-bold text-white transition">
						<?php echo $iga_booking_icon( 'bolt', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Quick Sign-Up
					</button>
					<button type="button" data-book-mode="calendar" class="flex items-center justify-center gap-2 rounded-lg px-3 py-3 text-xs font-bold text-white/40 transition hover:text-white">
						<?php echo $iga_booking_icon( 'calendar', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Pick a Date
					</button>
				</div>

				<!-- Quick sign-up -->
				<div data-book-panel="quick">
					<div id="iga-quick-step-one">
						<h2 class="mb-6 font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Which Class?</h2>
						<div class="space-y-3">
							<?php foreach ( $iga_quick_classes as $class_id => $class ) : ?>
								<button type="button" data-quick-class="<?php echo esc_attr( $class_id ); ?>" class="flex w-full items-center gap-4 rounded-xl border bg-[#1C1C1C] p-4 text-left transition <?php echo esc_attr( $class['card_class'] ); ?>">
									<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border <?php echo esc_attr( $class['icon_class'] ); ?>">
										<?php echo $iga_booking_icon( $class['icon'], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</span>
									<span class="min-w-0 flex-1">
										<strong class="block font-['Bebas_Neue'] text-2xl leading-none tracking-wide text-white"><?php echo esc_html( $class['name'] ); ?></strong>
										<small class="mt-1 block text-xs text-white/55">Coach <?php echo esc_html( $class['coach'] . ' · ' . $class['schedule'] ); ?></small>
										<small class="mt-1 block text-[10px] text-white/30"><?php echo esc_html( $class['duration'] ); ?></small>
									</span>
									<span class="text-white/30"><?php echo $iga_booking_icon( 'chevron', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								</button>
							<?php endforeach; ?>
						</div>
					</div>

					<div id="iga-quick-step-two" class="hidden">
						<h2 class="mb-6 font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Almost There.</h2>
						<div class="mb-7 flex items-center gap-4 rounded-xl border border-[#3A7D44]/40 bg-[#0F1F11] p-4">
							<span id="iga-quick-recap-icon" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[#3A7D44]/30 bg-[#3A7D44]/10 text-[#4E9E5A]"></span>
							<span class="min-w-0 flex-1">
								<strong id="iga-quick-recap-name" class="block font-['Bebas_Neue'] text-xl leading-none tracking-wide text-white"></strong>
								<small id="iga-quick-recap-meta" class="mt-1 block text-xs text-white/55"></small>
							</span>
							<button type="button" data-quick-change class="text-xs text-white/40 transition hover:text-white">Change</button>
						</div>

						<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="space-y-5">
							<?php wp_nonce_field( 'iga_submit_booking', 'iga_booking_nonce' ); ?>
							<input type="hidden" name="iga_booking_submit" value="1">
							<input type="hidden" name="booking_mode" value="quick">
							<input type="hidden" id="iga-quick-class-input" name="booking_class" value="">
							<div class="absolute -left-[9999px]" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
							<?php
							$quick_fields = array(
								array( 'Full Name', 'text', 'full_name', 'Your full name', 'name' ),
								array( 'WhatsApp Number', 'tel', 'phone', '+27 XX XXX XXXX', 'tel' ),
								array( 'Email Address', 'email', 'email', 'your@email.com', 'email' ),
							);
							foreach ( $quick_fields as $field ) :
								?>
								<div>
									<label for="quick-<?php echo esc_attr( $field[2] ); ?>" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40"><?php echo esc_html( $field[0] ); ?></label>
									<input id="quick-<?php echo esc_attr( $field[2] ); ?>" type="<?php echo esc_attr( $field[1] ); ?>" name="<?php echo esc_attr( $field[2] ); ?>" placeholder="<?php echo esc_attr( $field[3] ); ?>" autocomplete="<?php echo esc_attr( $field[4] ); ?>" required class="w-full rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20">
								</div>
							<?php endforeach; ?>
							<div class="flex gap-3 rounded-r-xl border-l-2 border-[#3A7D44] bg-[#1C1C1C] px-4 py-3 text-xs leading-6 text-white/40">
								<span class="mt-1 shrink-0 text-[#4E9E5A]"><?php echo $iga_booking_icon( 'info', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								We confirm your spot via WhatsApp within 24 hours.
							</div>
							<button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-[#3A7D44] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:bg-[#4E9E5A] hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
								<?php echo $iga_booking_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								Reserve My Spot
							</button>
							<p class="text-center text-[10px] leading-5 text-white/30">By submitting you agree to receive communications from Iron Gorilla Army.</p>
						</form>
						<button type="button" data-quick-change class="mt-5 inline-flex items-center gap-2 text-xs text-white/40 transition hover:text-white">
							<?php echo $iga_booking_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> Back
						</button>
					</div>
				</div>

				<!-- Calendar booking -->
				<div data-book-panel="calendar" class="hidden">
					<div class="mb-9 flex items-start">
						<div class="flex flex-col items-center gap-2">
							<span id="iga-session-progress" class="flex h-9 w-9 items-center justify-center rounded-full border border-[#3A7D44] bg-[#3A7D44] text-white"><?php echo $iga_booking_icon( 'dumbbell', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<small class="text-[9px] font-bold uppercase tracking-[0.14em] text-white">Session</small>
						</div>
						<span id="iga-progress-line" class="mt-[17px] h-0.5 flex-1 bg-white/10"></span>
						<div class="flex flex-col items-center gap-2">
							<span id="iga-user-progress" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 bg-[#242424] text-white/30"><?php echo $iga_booking_icon( 'user', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<small class="text-[9px] font-bold uppercase tracking-[0.14em] text-white/30">You</small>
						</div>
					</div>

					<div id="iga-calendar-step-one">
						<h2 class="mb-6 font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Pick a Session.</h2>
						<div class="mb-7 overflow-hidden rounded-2xl border border-white/10 bg-[#1C1C1C]">
							<p class="border-b border-white/[0.06] px-4 py-3 text-center text-[9px] font-bold uppercase tracking-[0.16em] text-white/30">Swipe to browse</p>
							<div id="iga-date-strip" class="flex snap-x snap-mandatory gap-1 overflow-x-auto px-[calc(50%-30px)] py-3 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
								<?php foreach ( $iga_booking_dates as $index => $date ) : ?>
									<button type="button" data-book-date="<?php echo esc_attr( $date->format( 'Y-m-d' ) ); ?>" class="flex w-[60px] shrink-0 snap-center flex-col items-center gap-1 rounded-xl px-1 py-2 transition <?php echo 0 === $index ? 'bg-[#3A7D44]/10 opacity-100' : 'opacity-40 hover:opacity-80'; ?>">
										<span class="text-[9px] font-bold uppercase tracking-wide text-[#4E9E5A]"><?php echo esc_html( $date->format( 'D' ) ); ?></span>
										<span class="flex h-10 w-10 items-center justify-center rounded-full font-['Bebas_Neue'] text-xl <?php echo 0 === $index ? 'bg-[#3A7D44] text-white' : 'text-white'; ?>"><?php echo esc_html( $date->format( 'j' ) ); ?></span>
										<span class="text-[8px] font-bold uppercase text-white/30"><?php echo esc_html( $date->format( 'Y-m-d' ) === $iga_today_date->format( 'Y-m-d' ) ? 'Today' : $date->format( 'M' ) ); ?></span>
									</button>
								<?php endforeach; ?>
							</div>
						</div>
						<p id="iga-selected-date-label" class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-[#4E9E5A]"></p>
						<div id="iga-session-list" class="space-y-3"></div>
					</div>

					<div id="iga-calendar-step-two" class="hidden">
						<h2 class="mb-6 font-['Bebas_Neue'] text-4xl uppercase tracking-wide text-white">Almost There.</h2>
						<div class="mb-7 rounded-xl border border-[#3A7D44]/40 bg-[#0F1F11] p-5">
							<p class="mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-[#4E9E5A]">Your Session</p>
							<div id="iga-calendar-recap" class="space-y-2 text-sm text-white/65"></div>
						</div>

						<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="space-y-5">
							<?php wp_nonce_field( 'iga_submit_booking', 'iga_booking_nonce' ); ?>
							<input type="hidden" name="iga_booking_submit" value="1">
							<input type="hidden" name="booking_mode" value="calendar">
							<input type="hidden" id="iga-calendar-date" name="booking_date" value="">
							<input type="hidden" id="iga-calendar-session" name="booking_session" value="">
							<input type="hidden" id="iga-calendar-coach" name="booking_coach" value="">
							<input type="hidden" id="iga-calendar-time" name="booking_time" value="">
							<input type="hidden" id="iga-calendar-duration" name="booking_duration" value="">
							<div class="absolute -left-[9999px]" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
							<?php foreach ( $quick_fields as $field ) : ?>
								<div>
									<label for="calendar-<?php echo esc_attr( $field[2] ); ?>" class="mb-2 block text-[10px] font-bold uppercase tracking-[0.16em] text-white/40"><?php echo esc_html( $field[0] ); ?></label>
									<input id="calendar-<?php echo esc_attr( $field[2] ); ?>" type="<?php echo esc_attr( $field[1] ); ?>" name="<?php echo esc_attr( $field[2] ); ?>" placeholder="<?php echo esc_attr( $field[3] ); ?>" autocomplete="<?php echo esc_attr( $field[4] ); ?>" required class="w-full rounded-xl border border-white/10 bg-[#141414] px-5 py-4 text-sm text-white outline-none transition placeholder:text-white/20 focus:border-[#4E9E5A] focus:ring-2 focus:ring-[#3A7D44]/20">
								</div>
							<?php endforeach; ?>
							<div class="flex gap-3 rounded-r-xl border-l-2 border-[#3A7D44] bg-[#1C1C1C] px-4 py-3 text-xs leading-6 text-white/40">
								<span class="mt-1 shrink-0 text-[#4E9E5A]"><?php echo $iga_booking_icon( 'info', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								First session free. We confirm via WhatsApp within 24 hours.
							</div>
							<button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-full bg-[#3A7D44] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:bg-[#4E9E5A] hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
								<?php echo $iga_booking_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								Book My Free Drop-In
							</button>
							<p class="text-center text-[10px] leading-5 text-white/30">By submitting you agree to receive communications from Iron Gorilla Army.</p>
						</form>
						<button type="button" id="iga-calendar-back" class="mt-5 inline-flex items-center gap-2 text-xs text-white/40 transition hover:text-white">
							<?php echo $iga_booking_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> Back
						</button>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php if ( ! is_array( $iga_success_booking ) ) : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	var quickClasses = <?php echo wp_json_encode( $iga_quick_classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;
	var weeklySchedule = <?php echo wp_json_encode( $iga_weekly_schedule ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;
	var whatsappUrl = 'https://wa.me/27790614906?text=Hi%2C%20I%27d%20like%20to%20book%20a%20Saturday%20session%20at%20The%20Forge.';
	var iconPaths = {
		entrepreneurship: 'brain', boxing: 'boxing', strength: 'dumbbell', hiit: 'bolt'
	};

	function setMode(mode) {
		document.querySelectorAll('[data-book-panel]').forEach(function (panel) {
			panel.classList.toggle('hidden', panel.getAttribute('data-book-panel') !== mode);
		});
		document.querySelectorAll('[data-book-mode]').forEach(function (button) {
			var active = button.getAttribute('data-book-mode') === mode;
			button.classList.toggle('bg-[#3A7D44]', active);
			button.classList.toggle('text-white', active);
			button.classList.toggle('text-white/40', !active);
		});
	}

	document.querySelectorAll('[data-book-mode]').forEach(function (button) {
		button.addEventListener('click', function () { setMode(button.getAttribute('data-book-mode')); });
	});

	var quickOne = document.getElementById('iga-quick-step-one');
	var quickTwo = document.getElementById('iga-quick-step-two');
	var quickInput = document.getElementById('iga-quick-class-input');

	document.querySelectorAll('[data-quick-class]').forEach(function (button) {
		button.addEventListener('click', function () {
			var id = button.getAttribute('data-quick-class');
			var item = quickClasses[id];
			if (!item) return;
			quickInput.value = id;
			document.getElementById('iga-quick-recap-name').textContent = item.name;
			document.getElementById('iga-quick-recap-meta').textContent = 'Coach ' + item.coach + ' · ' + item.schedule;
			document.getElementById('iga-quick-recap-icon').textContent = item.name.charAt(0);
			quickOne.classList.add('hidden');
			quickTwo.classList.remove('hidden');
		});
	});

	document.querySelectorAll('[data-quick-change]').forEach(function (button) {
		button.addEventListener('click', function () {
			quickTwo.classList.add('hidden');
			quickOne.classList.remove('hidden');
		});
	});

	var selectedDate = <?php echo wp_json_encode( $iga_default_date ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;
	var sessionList = document.getElementById('iga-session-list');
	var dateLabel = document.getElementById('iga-selected-date-label');
	var calendarOne = document.getElementById('iga-calendar-step-one');
	var calendarTwo = document.getElementById('iga-calendar-step-two');

	function formatTime(time) {
		var parts = time.split(':');
		var hour = Number(parts[0]);
		return (hour % 12 || 12) + ':' + parts[1] + ' ' + (hour >= 12 ? 'PM' : 'AM');
	}

	function formatDate(date) {
		return new Date(date + 'T12:00:00').toLocaleDateString('en-ZA', {
			weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
		});
	}

	function makeText(tag, classes, text) {
		var element = document.createElement(tag);
		element.className = classes;
		element.textContent = text;
		return element;
	}

	function renderSessions() {
		var day = new Date(selectedDate + 'T12:00:00').getDay();
		var sessions = weeklySchedule[String(day)] || weeklySchedule[day] || [];
		dateLabel.textContent = formatDate(selectedDate);
		sessionList.replaceChildren();

		if (day === 6) {
			var appointment = document.createElement('div');
			appointment.className = 'rounded-xl border border-[#3A7D44]/40 bg-[#1C1C1C] p-5';
			appointment.appendChild(makeText('h3', "font-['Bebas_Neue'] text-2xl tracking-wide text-white", 'Saturday — By Appointment'));
			appointment.appendChild(makeText('p', 'mt-2 text-sm leading-6 text-white/45', "Saturday sessions are arranged personally. WhatsApp us and we'll lock in your time."));
			var link = makeText('a', 'mt-5 inline-flex min-h-11 w-full items-center justify-center rounded-full bg-[#3A7D44] px-6 py-3 text-xs font-bold uppercase tracking-wide text-white hover:bg-[#4E9E5A]', 'WhatsApp to Book');
			link.href = whatsappUrl;
			link.target = '_blank';
			link.rel = 'noopener noreferrer';
			appointment.appendChild(link);
			sessionList.appendChild(appointment);
			return;
		}

		if (!sessions.length) {
			sessionList.appendChild(makeText('div', 'rounded-xl border border-white/10 bg-[#1C1C1C] p-5 text-sm text-white/45', 'No sessions this day. Please try a different date.'));
			return;
		}

		sessions.forEach(function (session) {
			var button = document.createElement('button');
			button.type = 'button';
			button.className = 'flex w-full items-center gap-4 rounded-xl border border-white/10 bg-[#1C1C1C] p-4 text-left transition hover:border-[#3A7D44]/50 hover:bg-[#242424]';
			var icon = makeText('span', 'flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#3A7D44]/30 bg-[#3A7D44]/10 font-bold text-[#4E9E5A]', session.name.charAt(0));
			var body = document.createElement('span');
			body.className = 'min-w-0 flex-1';
			body.appendChild(makeText('strong', "block font-['Bebas_Neue'] text-2xl leading-none tracking-wide text-white", formatTime(session.time)));
			body.appendChild(makeText('small', 'mt-1 block truncate text-xs text-white/55', session.name + ' · ' + session.coach));
			body.appendChild(makeText('small', 'mt-1 block text-[10px] text-white/30', session.duration + ' min · ' + session.capacity + ' spots'));
			button.appendChild(icon);
			button.appendChild(body);
			button.addEventListener('click', function () { selectSession(session); });
			sessionList.appendChild(button);
		});
	}

	function selectSession(session) {
		document.getElementById('iga-calendar-date').value = selectedDate;
		document.getElementById('iga-calendar-session').value = session.name;
		document.getElementById('iga-calendar-coach').value = session.coach;
		document.getElementById('iga-calendar-time').value = formatTime(session.time);
		document.getElementById('iga-calendar-duration').value = session.duration + ' min';

		var recap = document.getElementById('iga-calendar-recap');
		recap.replaceChildren(
			makeText('p', '', formatDate(selectedDate)),
			makeText('p', '', session.name),
			makeText('p', '', 'Coach ' + session.coach),
			makeText('p', '', formatTime(session.time) + ' · ' + session.duration + ' min')
		);
		calendarOne.classList.add('hidden');
		calendarTwo.classList.remove('hidden');
		document.getElementById('iga-progress-line').classList.add('bg-[#3A7D44]');
		document.getElementById('iga-user-progress').className = 'flex h-9 w-9 items-center justify-center rounded-full border border-[#3A7D44] bg-[#3A7D44] text-white';
	}

	document.querySelectorAll('[data-book-date]').forEach(function (button) {
		button.addEventListener('click', function () {
			selectedDate = button.getAttribute('data-book-date');
			document.querySelectorAll('[data-book-date]').forEach(function (dateButton) {
				var active = dateButton === button;
				dateButton.classList.toggle('bg-[#3A7D44]/10', active);
				dateButton.classList.toggle('opacity-100', active);
				dateButton.classList.toggle('opacity-40', !active);
				var circle = dateButton.querySelector('span:nth-child(2)');
				if (circle) {
					circle.classList.toggle('bg-[#3A7D44]', active);
					circle.classList.toggle('text-white', true);
				}
			});
			renderSessions();
		});
	});

	document.getElementById('iga-calendar-back').addEventListener('click', function () {
		calendarTwo.classList.add('hidden');
		calendarOne.classList.remove('hidden');
	});

	renderSessions();
});
</script>
<?php endif; ?>

<?php get_footer(); ?>