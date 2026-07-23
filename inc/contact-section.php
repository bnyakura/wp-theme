<?php
/**
 * Contact section — dashboard-editable HQ info + the dispatch form handler.
 *
 * Content:  Appearance → Customize → Contact Section (header, HQ details,
 *           form recipient).
 * Form:     classic admin-post.php submission (no JS required) → wp_mail() →
 *           redirect back to #contact with ?iga-contact=sent|error.
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Format +27 phone numbers for display: "+27790614906" → "079 061 4906".
 */
function iga_format_phone_display( $phone ) {
	$display = preg_replace( '/^\+27/', '0', (string) $phone );
	$grouped = preg_replace( '/(\d{2})(\d{3})(\d{4})/', '$1 $2 $3', preg_replace( '/\s/', '', $display ) );
	return $grouped ? $grouped : $display;
}

/**
 * Get the Contact section content (header + HQ card).
 */
function iga_get_contact_section() {
	return apply_filters(
		'iga_contact_section',
		[
			'header' => [
				'eyebrow'  => get_theme_mod( 'iga_contact_eyebrow', __( 'Dispatch', 'iga' ) ),
				'title'    => get_theme_mod( 'iga_contact_title', __( 'Establish Contact', 'iga' ) ),
				'subtitle' => get_theme_mod( 'iga_contact_subtitle', __( 'Have questions about enlistment, want to join the community, or need intel on the Armory? Send a dispatch and our team will get back to you.', 'iga' ) ),
			],
			'hq'     => [
				'location' => get_theme_mod( 'iga_contact_location', "Unit 209 Salt Circle, Kent Str.\nSalt River, Cape Town" ),
				'email'    => get_theme_mod( 'iga_contact_email', 'info@irongorilla.co.za' ),
				'phone'    => get_theme_mod( 'iga_contact_phone', '+27790614906' ),
			],
		]
	);
}

/**
 * Customizer panel.
 */
function iga_contact_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'iga_contact',
		[
			'title'    => __( 'Contact Section', 'iga' ),
			'priority' => 35,
		]
	);

	$fields = [
		'iga_contact_eyebrow'   => [
			'label'    => __( 'Eyebrow', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => __( 'Dispatch', 'iga' ),
		],
		'iga_contact_title'     => [
			'label'    => __( 'Heading', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => __( 'Establish Contact', 'iga' ),
		],
		'iga_contact_subtitle'  => [
			'label'    => __( 'Subtitle', 'iga' ),
			'type'     => 'textarea',
			'sanitize' => 'sanitize_textarea_field',
			'default'  => __( 'Have questions about enlistment, want to join the community, or need intel on the Armory? Send a dispatch and our team will get back to you.', 'iga' ),
		],
		'iga_contact_location'  => [
			'label'    => __( 'HQ location', 'iga' ),
			'type'     => 'textarea',
			'sanitize' => 'sanitize_textarea_field',
			'desc'     => __( 'Line breaks are kept.', 'iga' ),
			'default'  => "Unit 209 Salt Circle, Kent Str.\nSalt River, Cape Town",
		],
		'iga_contact_email'     => [
			'label'    => __( 'HQ email (displayed)', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_email',
			'default'  => 'info@irongorilla.co.za',
		],
		'iga_contact_phone'     => [
			'label'    => __( 'HQ phone', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => '+27790614906',
		],
		'iga_contact_recipient' => [
			'label'    => __( 'Form recipient email', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_email',
			'desc'     => __( 'Where dispatch form submissions are emailed. Defaults to the site admin email.', 'iga' ),
			'default'  => '',
		],
	];

	foreach ( $fields as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			[
				'default'           => $field['default'],
				'sanitize_callback' => $field['sanitize'],
			]
		);

		$wp_customize->add_control(
			$key,
			[
				'label'       => $field['label'],
				'description' => $field['desc'] ?? '',
				'section'     => 'iga_contact',
				'type'        => $field['type'],
			]
		);
	}
}
add_action( 'customize_register', 'iga_contact_customize_register' );

/**
 * Redirect helper — back to the #contact section with a status flag.
 */
function iga_contact_redirect( $url, $status ) {
	wp_safe_redirect( add_query_arg( 'iga-contact', $status, $url ) . '#contact' );
	exit;
}

/**
 * Form handler (logged-in and anonymous submissions).
 */
function iga_handle_contact_form() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	// Honeypot — bots that fill the hidden field get a fake success.
	if ( ! empty( $_POST['iga_company'] ) ) {
		iga_contact_redirect( $redirect, 'sent' );
	}

	if (
		! isset( $_POST['iga_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iga_contact_nonce'] ) ), 'iga_contact_send' )
	) {
		iga_contact_redirect( $redirect, 'error' );
	}

	$name    = isset( $_POST['iga_name'] ) ? sanitize_text_field( wp_unslash( $_POST['iga_name'] ) ) : '';
	$email   = isset( $_POST['iga_email'] ) ? sanitize_email( wp_unslash( $_POST['iga_email'] ) ) : '';
	$message = isset( $_POST['iga_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['iga_message'] ) ) : '';

	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		iga_contact_redirect( $redirect, 'error' );
	}

	$to = get_theme_mod( 'iga_contact_recipient', '' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = sprintf(
		/* translators: %s: sender name. */
		__( 'Website dispatch from %s', 'iga' ),
		$name
	);

	$body    = sprintf( "Name: %s\nEmail: %s\n\nMessage:\n%s\n", $name, $email, $message );
	$headers = [ sprintf( 'Reply-To: %s <%s>', $name, $email ) ];

	$sent = wp_mail( $to, $subject, $body, $headers );

	iga_contact_redirect( $redirect, $sent ? 'sent' : 'error' );
}
add_action( 'admin_post_iga_contact', 'iga_handle_contact_form' );
add_action( 'admin_post_nopriv_iga_contact', 'iga_handle_contact_form' );
