<?php
/**
 * Default Repeater rows for the Mission block, mirrored from the fallback
 * arrays in blocks/mission/render.php so the block editor form isn't blank
 * the first time it's opened.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_mission_paragraphs' => array(
		array(
			'paragraph' => "Iron Gorilla Army wasn't built in a boardroom. It started with a group of men in Cape Town who were tired of going through the motions — training alone, winning and losing alone, with no one who truly held them to a higher standard.",
		),
		array(
			'paragraph' => 'We believed that iron sharpens iron — that you become who you are in the company you keep. So we built a space where physical training is the vehicle, not the destination. You come for the weights. You stay for the community.',
		),
	),
	'field_mission_values'     => array(
		array(
			'icon'  => 'fa-dumbbell',
			'label' => 'Iron Discipline',
		),
		array(
			'icon'  => 'fa-heart',
			'label' => 'Faith First',
		),
		array(
			'icon'  => 'fa-users',
			'label' => 'Brotherhood',
		),
	),
);
