<?php
/**
 * Default Repeater rows for the Cilla Skyn Editorial Grid block, so the
 * block editor form isn't blank the first time it's opened.
 *
 * These are example teaser titles/excerpts written for this block, not
 * real articles — there's no blog/journal content in
 * NewProject/Cilla Skyn Website Layout.docx. No default `url` is set, so
 * these tiles render without a "Read More" link until a real article
 * exists to point at. Review/replace before launch.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_editorial_grid_articles' => array(
		array(
			'tag'     => 'Rituals',
			'title'   => 'The Barrier-First Approach to Skincare',
			'excerpt' => "Why every Cilla Skyn formula starts with supporting your skin's natural defences.",
		),
		array(
			'tag'     => 'Rituals',
			'title'   => 'Five Minutes to a Considered Morning Ritual',
			'excerpt' => 'Simple, purposeful steps to start your day with skin that feels balanced and cared for.',
		),
		array(
			'tag'     => 'Skin Wisdom',
			'title'   => "Understanding Your Skin's Changing Needs",
			'excerpt' => 'How to adjust your routine through the seasons without overcomplicating your shelf.',
		),
	),
);
