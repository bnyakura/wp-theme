<?php
/**
 * Default Repeater rows for the Forge block, mirrored from the fallback
 * arrays in blocks/forge/render.php so the block editor form isn't blank
 * the first time it's opened.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_forge_pillars' => array(
		array(
			'icon'  => 'fa-dumbbell',
			'title' => 'Movement',
			'body'  => 'Strength & Conditioning, Hybrid Group Classes, Open Studio. Every session is coach-led — movements are scaled so anyone can train.',
		),
		array(
			'icon'  => 'fa-brain',
			'title' => 'Holistic Wellness',
			'body'  => 'Physical training is one part of the equation. We integrate mental resilience, nutrition guidance, and spiritual grounding into everything.',
		),
		array(
			'icon'  => 'fa-users',
			'title' => 'Brotherhood',
			'body'  => 'Small squads trained under professional guidance. You belong here. You are held accountable. You do not train alone.',
		),
	),
);
