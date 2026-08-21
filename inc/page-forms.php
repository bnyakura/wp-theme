<?php
/**
 * Form handlers + shared data for the Book Assessment and Contact page blocks.
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
 * Book Assessment block — shared data
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'iga_assessment_genders' ) ) {
	/**
	 * Gender select options, keyed by the value submitted from the form.
	 *
	 * @return array<string, string>
	 */
	function iga_assessment_genders() {
		return array(
			'male'             => 'Male',
			'female'           => 'Female',
			'prefer_not_to_say' => 'Prefer not to say',
		);
	}
}

/* -------------------------------------------------------------------------
 * Book Assessment block — state
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'iga_assessment_form_state' ) ) {
	/**
	 * Current assessment booking form state: success record, validation
	 * error, posted values.
	 *
	 * Runs early on `template_redirect` so a POST submission is processed
	 * (and redirected) before any output is sent.
	 *
	 * @return array<string, mixed>
	 */
	function iga_assessment_form_state() {
		static $state = null;

		if ( null !== $state ) {
			return $state;
		}

		$state = array(
			'success' => null,
			'error'   => '',
			'posted'  => array(
				'first_name' => '',
				'last_name'  => '',
				'email'      => '',
				'phone'      => '',
				'dob'        => '',
				'gender'     => '',
			),
		);

		/* Success screen — reads the transient stored on the redirect. */
		if ( isset( $_GET['assessment'], $_GET['assessment_ref'] ) && 'success' === sanitize_key( wp_unslash( $_GET['assessment'] ) ) ) {
			$reference = sanitize_text_field( wp_unslash( $_GET['assessment_ref'] ) );
			$booking   = get_transient( 'iga_assessment_' . md5( $reference ) );

			if ( is_array( $booking ) ) {
				$state['success'] = $booking;
			}
		}

		if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) || empty( $_POST['iga_assessment_submit'] ) ) {
			return $state;
		}

		$nonce    = isset( $_POST['iga_assessment_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['iga_assessment_nonce'] ) ) : '';
		$honeypot = isset( $_POST['website'] ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'iga_submit_assessment' ) ) {
			$state['error'] = 'Your session expired. Please refresh the page and try again.';
			return $state;
		}

		if ( $honeypot ) {
			$state['error'] = 'Unable to submit this booking.';
			return $state;
		}

		$first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
		$last_name  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
		$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$dob        = isset( $_POST['dob'] ) ? sanitize_text_field( wp_unslash( $_POST['dob'] ) ) : '';
		$gender     = isset( $_POST['gender'] ) ? sanitize_key( wp_unslash( $_POST['gender'] ) ) : '';

		$state['posted'] = array(
			'first_name' => substr( $first_name, 0, 100 ),
			'last_name'  => substr( $last_name, 0, 100 ),
			'email'      => $email,
			'phone'      => substr( $phone, 0, 30 ),
			'dob'        => $dob,
			'gender'     => $gender,
		);

		$genders   = iga_assessment_genders();
		$dob_object = preg_match( '/^\d{4}-\d{2}-\d{2}$/', $dob )
			? DateTimeImmutable::createFromFormat( '!Y-m-d', $dob, wp_timezone() )
			: false;
		$today      = new DateTimeImmutable( 'today', wp_timezone() );

		if ( ! $first_name || ! $last_name || ! is_email( $email ) || ! $phone ) {
			$state['error'] = 'Please complete your name, email, and phone number.';
			return $state;
		}

		if ( ! $dob_object || $dob_object > $today || $dob_object < $today->modify( '-100 years' ) ) {
			$state['error'] = 'Please enter a valid date of birth.';
			return $state;
		}

		if ( ! isset( $genders[ $gender ] ) ) {
			$state['error'] = 'Please select a gender.';
			return $state;
		}

		$booking = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'email'      => $email,
			'phone'      => $phone,
			'dob'        => $dob_object->format( 'j F Y' ),
			'gender'     => $genders[ $gender ],
		);

		/* Save to Google Sheets via an Apps Script Web App webhook (best effort). */
		$sheet_webhook = iga_get_assessment_sheet_webhook_url();
		if ( $sheet_webhook ) {
			$sheet_response = wp_remote_post(
				$sheet_webhook,
				array(
					'timeout' => 8,
					'body'    => array(
						'first_name' => $booking['first_name'],
						'last_name'  => $booking['last_name'],
						'email'      => $booking['email'],
						'phone'      => $booking['phone'],
						'dob'        => $booking['dob'],
						'gender'     => $booking['gender'],
						'submitted'  => current_time( 'mysql' ),
					),
				)
			);
			do_action( 'iga_assessment_sheet_synced', $booking, $sheet_response );
		}

		$whatsapp_message = "Hi Iron Gorilla Army, I'd like to book a free assessment.\n\n";
		$whatsapp_message .= "Name: {$booking['first_name']} {$booking['last_name']}\n";
		$whatsapp_message .= "Email: {$booking['email']}\n";
		$whatsapp_message .= "Phone: {$booking['phone']}\n";
		$whatsapp_message .= "Date of birth: {$booking['dob']}\n";
		$whatsapp_message .= "Gender: {$booking['gender']}\n";

		$booking['whatsapp_url'] = iga_get_whatsapp_number_url( $whatsapp_message );

		do_action( 'iga_assessment_submitted', $booking );

		$reference = wp_generate_uuid4();
		set_transient( 'iga_assessment_' . md5( $reference ), $booking, 15 * MINUTE_IN_SECONDS );

		$redirect_to = get_permalink();
		if ( ! $redirect_to ) {
			$redirect_to = home_url( '/' );
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'assessment'     => 'success',
					'assessment_ref' => $reference,
				),
				$redirect_to
			)
		);
		exit;
	}
}
add_action( 'template_redirect', 'iga_assessment_form_state', 10 );

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
