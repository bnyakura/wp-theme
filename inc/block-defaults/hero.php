<?php
/**
 * Default Repeater rows for the Hero block, mirrored from the fallback
 * slides in blocks/hero/render.php so the block editor form isn't blank
 * the first time it's opened.
 *
 * Background Image sub-fields are intentionally omitted — there is no
 * attachment ID to point to, so those inputs stay empty (matching the
 * theme's convention for Image/File fields).
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

$book_url = home_url( '/book/' );

return array(
	'field_hero_slides' => array(
		array(
			'eyebrow'     => 'The Brotherhood',
			'title'       => 'IRON GORILLA',
			'line_2'      => 'ARMY',
			'description' => "Cape Town's most serious training community is enlisting. Built around iron, faith, and the belief that strength is forged — not born.",
			'button_text' => 'Book Free Assessment',
			'button_url'  => $book_url,
			'secondary_button_text' => 'Enlist Now',
		),
		array(
			'eyebrow'     => 'The Forge',
			'title'       => 'STRENGTH',
			'line_2'      => 'FORGED DAILY',
			'description' => 'Open access training, hybrid group classes, and squads led by professional coaches. Walk in soft. Walk out steel.',
			'button_text' => 'Book Free Assessment',
			'button_url'  => $book_url,
			'secondary_button_text' => 'Enlist Now',
		),
		array(
			'eyebrow'     => 'The Standard',
			'title'       => 'DISCIPLINE',
			'line_2'      => 'OVER MOOD',
			'description' => "We don't chase motivation. We build standards. Every rep, every class, every member held to the same line.",
			'button_text' => 'Book Free Assessment',
			'button_url'  => $book_url,
			'secondary_button_text' => 'Enlist Now',
		),
	),
);
