<?php
/**
 * Form handlers + shared data for the Book a Drop-In and Contact page blocks.
 *
 * The Book and Contact blocks render inside `the_content()`, i.e. after the
 * header has already been output. Classic POST processing therefore has to run
 * before any output so the existing redirects keep working. Both handlers are
 * hooked on `template_redirect` (fires after the main query is set up and
 * before the template loads), and expose their state through getter functions
 * the block render templates read.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
 * Booking block — shared data (filterable, ships with the original content)
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'iga_booking_quick_classes' ) ) {
	/**
	 * Quick sign-up class cards.
	 *
	 * @return array<int|string, array<string, mixed>>
	 */
	function iga_booking_quick_classes() {
		return apply_filters(
			'iga_booking_quick_classes',
			array(
				'entrepreneurship' => array(
					'name'        => 'Entrepreneurship Class',
					'coach'       => 'Paul O',
					'schedule'    => 'Mondays · 18:00',
					'duration'    => '90 min',
					'icon'        => 'brain',
					'card_class'  => 'border-white/[0.09] hover:border-[#5AC2A8]/40 hover:bg-[#5AC2A8]/[0.06]',
					'icon_class'  => 'border-[#5AC2A8]/30 bg-[#5AC2A8]/10 text-[#5AC2A8]',
				),
				'boxing'           => array(
					'name'        => 'Boxing',
					'coach'       => 'Rhema M',
					'schedule'    => 'Mon · Tue · Thu evenings',
					'duration'    => '60 min',
					'icon'        => 'boxing',
					'card_class'  => 'border-white/[0.09] hover:border-[#5A7EC2]/40 hover:bg-[#5A7EC2]/[0.06]',
					'icon_class'  => 'border-[#5A7EC2]/30 bg-[#5A7EC2]/10 text-[#5A7EC2]',
				),
				'strength'         => array(
					'name'        => 'Strength & Muscle',
					'coach'       => 'Abongile M',
					'schedule'    => 'Mon – Fri · 06:00 & 07:00',
					'duration'    => '60 min',
					'icon'        => 'dumbbell',
					'card_class'  => 'border-white/[0.09] hover:border-[#4E9E5A]/40 hover:bg-[#4E9E5A]/[0.06]',
					'icon_class'  => 'border-[#4E9E5A]/30 bg-[#4E9E5A]/10 text-[#4E9E5A]',
				),
				'hiit'             => array(
					'name'        => 'Strength & HIIT',
					'coach'       => 'Othniel M',
					'schedule'    => 'Mon · Wed · 18:30 & 19:30',
					'duration'    => '60 min',
					'icon'        => 'bolt',
					'card_class'  => 'border-white/[0.09] hover:border-[#C25A5A]/40 hover:bg-[#C25A5A]/[0.06]',
					'icon_class'  => 'border-[#C25A5A]/30 bg-[#C25A5A]/10 text-[#C25A5A]',
				),
			)
		);
	}
}

if ( ! function_exists( 'iga_booking_schedule' ) ) {
	/**
	 * Weekly timetable. Keys are ISO weekday numbers (1 = Monday).
	 *
	 * @return array<int, array<int, array<string, mixed>>>
	 */
	function iga_booking_schedule() {
		return apply_filters(
			'iga_booking_schedule',
			array(
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
			)
		);
	}
}

if ( ! function_exists( 'iga_booking_next_dates' ) ) {
	/**
	 * The next 28 bookable weekdays (Monday–Friday) as DateTimeImmutable objects.
	 *
	 * @return array<int, DateTimeImmutable>
	 */
	function iga_booking_next_dates() {
		$dates         = array();
		$today         = new DateTimeImmutable( 'today', wp_timezone() );
		$cursor        = $today;
		$max           = 60;
		$date_attempts = 0;

		while ( count( $dates ) < 28 && $date_attempts < $max ) {
			if ( 0 !== (int) $cursor->format( 'w' ) ) {
				$dates[] = $cursor;
			}
			$cursor        = $cursor->modify( '+1 day' );
			$date_attempts++;
		}

		return $dates;
	}
}

/* -------------------------------------------------------------------------
 * Booking block — state
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'iga_booking_form_state' ) ) {
	/**
	 * Current booking form state: success booking, validation error, posted values.
	 *
	 * Runs early on `template_redirect` so a POST submission is processed (and
	 * redirected) before any output is sent.
	 *
	 * @return array<string, mixed>
	 */
	function iga_booking_form_state() {
		static $state = null;

		if ( null !== $state ) {
			return $state;
		}

		$state = array(
			'success' => null,
			'error'   => '',
			'posted'  => array(
				'name'    => '',
				'phone'   => '',
				'email'   => '',
				'mode'    => '',
				'class'   => '',
				'date'    => '',
				'session' => '',
				'time'    => '',
			),
		);

		/* Success screen — reads the transient stored on the redirect. */
		if ( isset( $_GET['booking'], $_GET['booking_ref'] ) && 'success' === sanitize_key( wp_unslash( $_GET['booking'] ) ) ) {
			$reference = sanitize_text_field( wp_unslash( $_GET['booking_ref'] ) );
			$booking   = get_transient( 'iga_booking_' . md5( $reference ) );

			if ( is_array( $booking ) ) {
				$state['success'] = $booking;
			}
		}

		if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) || empty( $_POST['iga_booking_submit'] ) ) {
			return $state;
		}

		$nonce    = isset( $_POST['iga_booking_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iga_booking_nonce'] ) ) : '';
		$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'iga_submit_booking' ) ) {
			$state['error'] = 'Your session expired. Please refresh the page and try again.';
			return $state;
		}

		if ( $honeypot ) {
			$state['error'] = 'Unable to submit this booking.';
			return $state;
		}

		$mode  = isset( $_POST['booking_mode'] ) ? sanitize_key( wp_unslash( $_POST['booking_mode'] ) ) : '';
		$name  = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
		$phone = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

		$state['posted'] = array(
			'name'    => $name,
			'phone'   => $phone,
			'email'   => $email,
			'mode'    => $mode,
			'class'   => '',
			'date'    => '',
			'session' => '',
			'time'    => '',
		);

		if ( ! $name || ! $phone || ! is_email( $email ) || ! in_array( $mode, array( 'quick', 'calendar' ), true ) ) {
			$state['error'] = 'Please complete your name, WhatsApp number, and a valid email address.';
			return $state;
		}

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
			$class_id  = isset( $_POST['booking_class'] ) ? sanitize_key( wp_unslash( $_POST['booking_class'] ) ) : '';
			$classes   = iga_booking_quick_classes();

			if ( ! isset( $classes[ $class_id ] ) ) {
				$state['error'] = 'Please choose a class before submitting.';
				return $state;
			}

			$class              = $classes[ $class_id ];
			$booking['session'] = $class['name'];
			$booking['coach']   = $class['coach'];
			$booking['date']    = $class['schedule'];
			$booking['time']    = 'Confirmed via WhatsApp';
			$booking['duration'] = $class['duration'];

			$state['posted']['class'] = $class_id;
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
				$day_schedule = iga_booking_schedule();
				$day_schedule = isset( $day_schedule[ (int) $date_object->format( 'w' ) ] ) ? $day_schedule[ (int) $date_object->format( 'w' ) ] : array();

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
				$state['error'] = 'Please select a valid upcoming date and session before submitting.';
				return $state;
			}

			$booking['date']     = $date_object->format( 'l, j F Y' );
			$booking['session']  = $valid_session['name'];
			$booking['coach']    = $valid_session['coach'];
			$booking['time']     = $submitted_time;
			$booking['duration'] = $valid_session['duration'] . ' min';

			$state['posted']['date']    = $submitted_date;
			$state['posted']['session'] = $submitted_session;
			$state['posted']['time']    = $submitted_time;
		}

		if ( ! $state['error'] ) {
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

				$redirect_to = get_permalink();
				if ( ! $redirect_to ) {
					$redirect_to = home_url( '/' );
				}

				wp_safe_redirect(
					add_query_arg(
						array(
							'booking'     => 'success',
							'booking_ref' => $reference,
						),
						$redirect_to
					)
				);
				exit;
			}

			$state['error'] = 'Something went wrong. Please try again or contact us on WhatsApp.';
		}

		return $state;
	}
}
add_action( 'template_redirect', 'iga_booking_form_state', 10 );

/* -------------------------------------------------------------------------
 * Contact block — shared data
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'iga_contact_details' ) ) {
	/**
	 * Headquarters contact details.
	 *
	 * @return array<string, string>
	 */
	function iga_contact_details() {
		return apply_filters(
			'iga_contact_details',
			array(
				'email'      => 'info@irongorilla.co.za',
				'phone'      => '+27790614906',
				'phone_text' => '+27 79 061 4906',
				'whatsapp'   => '27790614906',
				'instagram'  => 'https://www.instagram.com/irongorillaarmy',
				'address'    => 'Unit 209 Salt Circle, Kent Str., Salt River, Cape Town',
			)
		);
	}
}

if ( ! function_exists( 'iga_contact_subjects' ) ) {
	/**
	 * Dispatch subject options for the form select.
	 *
	 * @return array<string, string>
	 */
	function iga_contact_subjects() {
		return array(
			'enlistment' => 'Membership Enquiry',
			'dropin'     => 'Book a Drop-In',
			'armory'     => 'Armory / Product Order',
			'event'      => 'Event Enquiry',
			'league'     => 'League of Legends',
			'operations' => 'Operations List',
			'other'      => 'Other',
		);
	}
}

if ( ! function_exists( 'iga_contact_subject_aliases' ) ) {
	/**
	 * Map the ?subject= / ?plan= values used by the other page templates to
	 * the contact form's subject keys.
	 *
	 * @return array<string, string>
	 */
	function iga_contact_subject_aliases() {
		return array(
			'enlist'              => 'enlistment',
			'platoons'            => 'enlistment',
			'squads'              => 'enlistment',
			'studio-access'       => 'enlistment',
			'armory-early-access' => 'armory',
			'league-of-legends'   => 'league',
			'operations-list'     => 'operations',
		);
	}
}

/* -------------------------------------------------------------------------
 * Contact block — state
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'iga_contact_form_state' ) ) {
	/**
	 * Current contact form state: success flag, validation error, posted values.
	 *
	 * @return array<string, mixed>
	 */
	function iga_contact_form_state() {
		static $state = null;

		if ( null !== $state ) {
			return $state;
		}

		$state = array(
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

		if ( 'POST' === strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) && isset( $_POST['iga_contact_submit'] ) ) {
			$nonce    = isset( $_POST['iga_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iga_contact_nonce'] ) ) : '';
			$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';

			$state['posted']['name']    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
			$state['posted']['email']   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
			$state['posted']['phone']   = isset( $_POST['contact_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ) : '';
			$state['posted']['subject'] = isset( $_POST['contact_subject'] ) ? sanitize_key( wp_unslash( $_POST['contact_subject'] ) ) : '';
			$state['posted']['message'] = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

			$state['posted']['name']    = substr( $state['posted']['name'], 0, 100 );
			$state['posted']['phone']   = substr( $state['posted']['phone'], 0, 30 );
			$state['posted']['message'] = substr( $state['posted']['message'], 0, 2000 );

			if ( ! wp_verify_nonce( $nonce, 'iga_submit_contact' ) ) {
				$state['error'] = 'Your session expired. Please refresh the page and try again.';
			} elseif ( $honeypot ) {
				$state['error'] = 'Unable to submit this dispatch.';
			} elseif ( ! $state['posted']['name'] ) {
				$state['error'] = 'Please enter your name.';
			} elseif ( ! is_email( $state['posted']['email'] ) ) {
				$state['error'] = 'Please enter a valid email address.';
			} elseif ( ! $state['posted']['message'] ) {
				$state['error'] = 'Please enter your message.';
			} else {
				$subjects      = iga_contact_subjects();
				$subject_key   = isset( $subjects[ $state['posted']['subject'] ] ) ? $state['posted']['subject'] : 'other';
				$subject_label = $subjects[ $subject_key ];
				$submission    = array(
					'name'    => $state['posted']['name'],
					'email'   => $state['posted']['email'],
					'phone'   => $state['posted']['phone'],
					'subject' => $subject_label,
					'message' => $state['posted']['message'],
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
					$redirect_to = get_permalink();
					if ( ! $redirect_to ) {
						$redirect_to = home_url( '/' );
					}

					wp_safe_redirect( add_query_arg( 'dispatch', 'received', $redirect_to ) );
					exit;
				}

				$state['error'] = 'Something went wrong. Please try again or WhatsApp us directly.';
			}
		}

		/* Preselect a subject when another page links here with ?subject=... or ?plan=... */
		if ( ! $state['posted']['subject'] ) {
			$query_subject = isset( $_GET['subject'] ) ? sanitize_key( wp_unslash( $_GET['subject'] ) ) : '';
			$query_plan    = isset( $_GET['plan'] ) ? sanitize_key( wp_unslash( $_GET['plan'] ) ) : '';
			$query_value   = $query_subject ? $query_subject : $query_plan;
			$aliases       = iga_contact_subject_aliases();
			$subjects      = iga_contact_subjects();

			if ( isset( $aliases[ $query_value ] ) ) {
				$state['posted']['subject'] = $aliases[ $query_value ];
			} elseif ( isset( $subjects[ $query_value ] ) ) {
				$state['posted']['subject'] = $query_value;
			}
		}

		$state['success'] = isset( $_GET['dispatch'] ) && 'received' === sanitize_key( wp_unslash( $_GET['dispatch'] ) );

		return $state;
	}
}
add_action( 'template_redirect', 'iga_contact_form_state', 10 );
