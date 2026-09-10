<?php
/**
 * Form handler for the Cilla Skyn Contact Form block.
 *
 * A fresh, Cilla Skyn-specific handler — not a revival of the gym-era
 * `iga_contact_*` functions in inc/page-forms.php (§13 of the theme
 * README), whose subject options ("Membership Enquiry", "Armory / Product
 * Order", "League of Legends", ...) belong to the old gym brand and don't
 * fit a skincare store. Follows the same proven shape (nonce + honeypot,
 * processed on `template_redirect` so a redirect can happen before any
 * output is sent, state exposed via a getter the block's render.php
 * reads) since that pattern already works well in this theme.
 *
 * @package Cilla_Skyn
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'cilla_skyn_contact_form_subjects' ) ) {
	/**
	 * Dispatch subject options for the form's Subject select.
	 *
	 * @return array<string, string>
	 */
	function cilla_skyn_contact_form_subjects() {
		return array(
			'order'       => __( 'Order Enquiry', 'custom-theme' ),
			'product'     => __( 'Product Question', 'custom-theme' ),
			'returns'     => __( 'Returns & Exchanges', 'custom-theme' ),
			'wholesale'   => __( 'Wholesale / Stockist', 'custom-theme' ),
			'press'       => __( 'Press / Collaboration', 'custom-theme' ),
			'other'       => __( 'Other', 'custom-theme' ),
		);
	}
}

if ( ! function_exists( 'cilla_skyn_contact_form_state' ) ) {
	/**
	 * Current contact form state: success flag, validation error, posted
	 * values. Runs once per request on `template_redirect` so a POST
	 * submission is processed (and redirected) before any output is sent.
	 *
	 * @return array<string, mixed>
	 */
	function cilla_skyn_contact_form_state() {
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

		$state['success'] = isset( $_GET['cilla_skyn_contact'] ) && 'sent' === sanitize_key( wp_unslash( $_GET['cilla_skyn_contact'] ) );

		$is_post = 'POST' === strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' );

		if ( ! $is_post || empty( $_POST['cilla_skyn_contact_submit'] ) ) {
			return $state;
		}

		$nonce    = isset( $_POST['cilla_skyn_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cilla_skyn_contact_nonce'] ) ) : '';
		$honeypot = isset( $_POST['cilla_skyn_website'] ) ? sanitize_text_field( wp_unslash( $_POST['cilla_skyn_website'] ) ) : '';

		$state['posted']['name']    = isset( $_POST['contact_name'] ) ? substr( sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ), 0, 100 ) : '';
		$state['posted']['email']   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
		$state['posted']['phone']   = isset( $_POST['contact_phone'] ) ? substr( sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ), 0, 30 ) : '';
		$state['posted']['subject'] = isset( $_POST['contact_subject'] ) ? sanitize_key( wp_unslash( $_POST['contact_subject'] ) ) : '';
		$state['posted']['message'] = isset( $_POST['contact_message'] ) ? substr( sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ), 0, 2000 ) : '';

		if ( ! wp_verify_nonce( $nonce, 'cilla_skyn_submit_contact' ) ) {
			$state['error'] = __( 'Your session expired. Please refresh the page and try again.', 'custom-theme' );
			return $state;
		}

		if ( $honeypot ) {
			$state['error'] = __( 'Unable to submit this message.', 'custom-theme' );
			return $state;
		}

		if ( ! $state['posted']['name'] ) {
			$state['error'] = __( 'Please enter your name.', 'custom-theme' );
			return $state;
		}

		if ( ! is_email( $state['posted']['email'] ) ) {
			$state['error'] = __( 'Please enter a valid email address.', 'custom-theme' );
			return $state;
		}

		if ( ! $state['posted']['message'] ) {
			$state['error'] = __( 'Please enter your message.', 'custom-theme' );
			return $state;
		}

		$subjects      = cilla_skyn_contact_form_subjects();
		$subject_key   = isset( $subjects[ $state['posted']['subject'] ] ) ? $state['posted']['subject'] : 'other';
		$subject_label = $subjects[ $subject_key ];

		$submission = array(
			'name'    => $state['posted']['name'],
			'email'   => $state['posted']['email'],
			'phone'   => $state['posted']['phone'],
			'subject' => $subject_label,
			'message' => $state['posted']['message'],
		);

		$recipient = apply_filters( 'cilla_skyn_contact_recipient', get_option( 'admin_email' ) );

		$mail_subject  = sprintf(
			/* translators: 1: subject label, 2: sender name. */
			__( 'Cilla Skyn website message: %1$s — %2$s', 'custom-theme' ),
			$subject_label,
			$submission['name']
		);
		$mail_message  = "A new message was submitted from the Cilla Skyn website contact form.\n\n";
		$mail_message .= "Name: {$submission['name']}\n";
		$mail_message .= "Email: {$submission['email']}\n";
		$mail_message .= 'Phone: ' . ( $submission['phone'] ? $submission['phone'] : 'Not supplied' ) . "\n";
		$mail_message .= "Subject: {$submission['subject']}\n\n";
		$mail_message .= "Message:\n{$submission['message']}\n";
		$headers       = array( 'Reply-To: ' . $submission['name'] . ' <' . $submission['email'] . '>' );

		$mail_sent = wp_mail( $recipient, $mail_subject, $mail_message, $headers );

		do_action( 'cilla_skyn_contact_submitted', $submission, $mail_sent );

		if ( ! $mail_sent ) {
			$state['error'] = __( 'Something went wrong sending your message. Please try again or contact us directly.', 'custom-theme' );
			return $state;
		}

		$redirect_to = get_permalink();
		if ( ! $redirect_to ) {
			$redirect_to = home_url( '/' );
		}

		wp_safe_redirect( add_query_arg( 'cilla_skyn_contact', 'sent', $redirect_to ) );
		exit;
	}
}
add_action( 'template_redirect', 'cilla_skyn_contact_form_state', 10 );
