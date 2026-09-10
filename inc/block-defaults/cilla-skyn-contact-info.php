<?php
/**
 * Default Repeater rows for the Cilla Skyn Contact Info block, so the
 * block editor form isn't blank the first time it's opened.
 *
 * Values are the WhatsApp/Instagram/Email details from
 * NewProject/Cilla Skyn Website Layout.docx's "Contact Information"
 * section.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_contact_info_methods' => array(
		array(
			'type'  => 'whatsapp',
			'label' => 'WhatsApp',
			'value' => '+27 64 911 1932',
			'url'   => 'https://wa.me/27649111932',
		),
		array(
			'type'  => 'instagram',
			'label' => 'Instagram',
			'value' => '@Cillaskyn',
			'url'   => 'https://www.instagram.com/Cillaskyn',
		),
		array(
			'type'  => 'email',
			'label' => 'Email',
			'value' => 'Info@cillaskyn.co.za',
			'url'   => 'mailto:Info@cillaskyn.co.za',
		),
	),
);
