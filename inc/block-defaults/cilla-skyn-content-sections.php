<?php
/**
 * Default Repeater rows for the Cilla Skyn Content Sections block, so the
 * block editor form isn't blank the first time it's opened.
 *
 * This is example Shipping & Delivery copy, not content supplied by the
 * client — there's no shipping/returns policy in
 * NewProject/Cilla Skyn Website Layout.docx. Review and replace with the
 * real policy before launch; duplicate this block for a Returns &
 * Exchanges page and replace these rows with the real returns policy.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_content_sections_sections' => array(
		array(
			'title' => 'Processing Time',
			'body'  => "Orders are processed within 1–2 business days. You'll receive an email with tracking information as soon as your order ships.",
		),
		array(
			'title' => 'Delivery Times',
			'body'  => 'Standard delivery within South Africa takes 2–5 business days depending on your location. Major metro areas typically receive orders faster than outlying regions.',
		),
		array(
			'title' => 'Delivery Fees',
			'body'  => 'A flat delivery fee applies at checkout, calculated based on your delivery address. Free delivery is available on qualifying orders — the threshold is shown at checkout.',
		),
		array(
			'title' => 'International Shipping',
			'body'  => 'We currently ship within South Africa only. Please check back as we expand to more regions.',
		),
	),
);
