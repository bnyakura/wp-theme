<?php
/**
 * Default Repeater rows for the FAQ page's split sub-blocks (faq-list).
 * Field keys are unchanged from the original monolithic faq block, so
 * this entry didn't need to move. Testimonials now come from the reused
 * wp-theme/testimonials block — see its own inc/block-defaults/ file.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_faq_categories'    => array(
		array(
			'category' => 'Getting Started',
			'icon'     => 'door',
			'faqs'     => array(
				array(
					'question' => 'Do I need to be fit to join?',
					'answer'   => 'No. Everyone who walks through our doors starts somewhere. Our coaches assess where you are and build your programme from there. The only requirement is that you show up ready to work.',
				),
				array(
					'question' => 'Can I do a Drop-In before committing?',
					'answer'   => 'Absolutely. We encourage it. Book a Drop-In session using the button on this page, come experience the floor and the people, and make your decision from there. No pressure.',
				),
				array(
					'question' => 'What should I bring to my first session?',
					'answer'   => 'Training shoes, a water bottle, and the right attitude. We have all the equipment. Arrive 15 minutes early for your first session so a coach can walk you through the facility.',
				),
			),
		),
		array(
			'category' => 'Training & Programs',
			'icon'     => 'dumbbell',
			'faqs'     => array(
				array(
					'question' => 'What does a typical session look like?',
					'answer'   => 'Sessions run 60 minutes. They begin with a structured warm-up, move into strength or conditioning work, and close with a cool-down and debrief with your squad. Every session has a purpose and a coach on the floor.',
				),
				array(
					'question' => 'How many times per week should I train?',
					'answer'   => 'For most members starting out, 3–4 sessions per week is optimal. Your coach will help you build a schedule that balances training, recovery, and lifestyle. Consistency over volume — always.',
				),
				array(
					'question' => 'Do you offer personal training?',
					'answer'   => 'Yes. Personal training is available through our Squads tier — 4 personalized 1-on-1 sessions per block with tailored programming and progress tracking.',
				),
			),
		),
		array(
			'category' => 'Membership & Pricing',
			'icon'     => 'medal',
			'faqs'     => array(
				array(
					'question' => 'Are there lock-in contracts?',
					'answer'   => 'No lock-in contracts. We believe if we do our job right, you stay because you want to — not because you have to. Month-to-month on all plans.',
				),
				array(
					'question' => 'Can I freeze or pause my membership?',
					'answer'   => 'Yes. Life happens. Contact us directly to discuss a membership pause. We work with our members — we are not a faceless gym chain.',
				),
			),
		),
		array(
			'category' => 'Location & Hours',
			'icon'     => 'location',
			'faqs'     => array(
				array(
					'question' => 'Where are you located?',
					'answer'   => 'Unit 209 Salt Circle, Kent Street, Salt River, Cape Town. Arrive 15 minutes early for your first visit and a coach will walk you through the facility.',
				),
				array(
					'question' => 'What are your operating hours?',
					'answer'   => 'Doors open at 6AM Monday to Saturday and close at 9PM. Sunday is a rest day — we practice what we preach.',
				),
			),
		),
		array(
			'category' => 'Culture & Faith',
			'icon'     => 'heart',
			'faqs'     => array(
				array(
					'question' => 'Is this a Christian gym? Do I have to share your beliefs?',
					'answer'   => 'Iron Gorilla is faith-inspired but not a church. Our values are rooted in scripture, but we welcome everyone who respects the culture of growth, discipline, and community.',
				),
				array(
					'question' => "What does 'brotherhood' actually mean here?",
					'answer'   => "It means you don't train alone. It means someone notices when you don't show up. It means you're held accountable — not policed. The brotherhood is real and it is earned through consistency.",
				),
			),
		),
	),
);
