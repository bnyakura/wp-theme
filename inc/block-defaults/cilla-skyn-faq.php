<?php
/**
 * Default Repeater rows for the Cilla Skyn FAQ block, so the block editor
 * form isn't blank the first time it's opened.
 *
 * These are example questions, not content supplied by the client — FAQs
 * weren't part of NewProject/Cilla Skyn Website Layout.docx. Review and
 * replace with real questions before launch.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_faq_faqs' => array(
		array(
			'question' => 'How do I know which products are right for my skin?',
			'answer'   => "Start with our Shop by Concern page, or reach out to us directly via WhatsApp or email — we're happy to help you build a routine.",
		),
		array(
			'question' => 'Are Cilla Skyn products suitable for sensitive skin?',
			'answer'   => "Many of our formulations are designed with barrier support in mind. Check each product's description for specific skin-type guidance, or contact us if you're unsure.",
		),
		array(
			'question' => 'How long will my order take to arrive?',
			'answer'   => 'Please see our Shipping & Delivery page for full details on processing and delivery times.',
		),
		array(
			'question' => 'What is your returns policy?',
			'answer'   => 'Please see our Returns & Exchanges page for full details on how to return or exchange an item.',
		),
		array(
			'question' => 'Do you ship internationally?',
			'answer'   => 'We currently ship within South Africa only.',
		),
	),
);
