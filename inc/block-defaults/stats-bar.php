<?php
/**
 * Default Repeater rows for the Stats Bar block, mirrored from the fallback
 * array in blocks/stats-bar/render.php so the block editor form isn't blank
 * the first time it's opened.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_stats_bar_items' => array(
		array(
			'value' => '120+',
			'label' => 'Active Members',
		),
		array(
			'value' => '3 Yrs',
			'label' => 'Iron-Tested Since 2022',
		),
		array(
			'value' => '6AM',
			'label' => 'Doors Open Daily',
		),
		array(
			'value' => '1 Unit',
			'label' => 'Brotherhood. No Excuses.',
		),
	),
);
