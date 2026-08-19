<?php
/**
 * Default Repeater rows for the Distinction block, mirrored from the
 * fallback arrays in blocks/distinction/render.php so the block editor form
 * isn't blank the first time it's opened.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

$training_url = home_url( '/training/' );

return array(
	'field_distinction_cards' => array(
		array(
			'tag'        => 'The Movement',
			'tag_icon'   => 'fa-users',
			'title'      => 'Iron Gorilla Army',
			'body'       => 'We are a community built around iron and faith. The Army is the overarching culture, the standard, and the movement committed to growth and complete self-mastery.',
			'featured'   => 0,
			'cta_label'  => 'Join Community',
			'cta_icon'   => 'fa-medal',
			'cta_action' => 'whatsapp-group',
			'cta_url'    => '',
		),
		array(
			'tag'        => 'The Facility',
			'tag_icon'   => 'fa-dumbbell',
			'title'      => 'The Forge Gym',
			'body'       => 'The Forge is the proving ground where the Army trains. Open access, studio classes, and coach-led sessions. This is where the work gets done.',
			'featured'   => 1,
			'cta_label'  => 'View Training Programs',
			'cta_icon'   => 'fa-dumbbell',
			'cta_action' => 'link',
			'cta_url'    => $training_url,
		),
		array(
			'tag'        => 'Headquarters',
			'tag_icon'   => 'fa-location-dot',
			'title'      => 'Where To Find Us',
			'body'       => 'Unit 209 Salt Circle, Kent Str, Salt River, Cape Town. Mon–Sat: 6AM–9PM. Sunday: Closed.',
			'featured'   => 0,
			'cta_label'  => 'Get Directions',
			'cta_icon'   => 'fa-map-location-dot',
			'cta_action' => 'directions',
			'cta_url'    => '',
		),
	),
);
