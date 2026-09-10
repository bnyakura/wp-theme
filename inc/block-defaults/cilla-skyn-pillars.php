<?php
/**
 * Default Repeater rows for the Cilla Skyn Pillars block, so the block
 * editor form isn't blank the first time it's opened.
 *
 * These are intentionally generic, non-specific placeholder commitments —
 * sustainability wasn't part of NewProject/Cilla Skyn Website Layout.docx,
 * so nothing here was supplied or verified by the client. Deliberately
 * avoids concrete/regulated claims (e.g. "cruelty-free", "recyclable",
 * "carbon neutral") that would need to be factually verified before
 * publishing — replace every row with real, verified commitments before
 * launch. See the block's own README.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_pillars_pillars' => array(
		array(
			'icon'        => 'leaf',
			'title'       => 'Thoughtful Sourcing',
			'description' => 'We choose botanical ingredients with care, favouring suppliers who share our respect for the land they come from.',
		),
		array(
			'icon'        => 'recycle',
			'title'       => 'Considered Packaging',
			'description' => "We're working towards packaging that's kinder to the planet, step by step, without compromising on product integrity.",
		),
		array(
			'icon'        => 'heart',
			'title'       => 'Community First',
			'description' => "Cilla Skyn is rooted in African heritage — we're committed to supporting the communities and growers behind our ingredients.",
		),
		array(
			'icon'        => 'drop',
			'title'       => 'Made to Last',
			'description' => 'We formulate for real results, so a little goes a long way and nothing sits unused on a shelf.',
		),
	),
);
