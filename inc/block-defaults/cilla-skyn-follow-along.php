<?php
/**
 * Default Repeater rows for the Cilla Skyn Follow Along block, so the
 * block editor form isn't blank the first time it's opened.
 *
 * Caption tiles point at real Cilla Skyn products (by ID) so the grid
 * shows actual product photography instead of flat colour blocks. Swap
 * these IDs for different products, or clear "Product" on a row in the
 * block editor to fall back to a manual Caption + Color tile.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_follow_along_tiles' => array(
		array(
			'type'        => 'caption',
			'product'     => 434, // Clarity Reset Clarifying Gel Face Wash 200ml.
			'color'       => '#DED0B4',
			'caption'     => '',
			'show_icon'   => true,
			'quote'       => '',
			'attribution' => '',
		),
		array(
			'type'        => 'quote',
			'color'       => '#E7DCC7',
			'caption'     => '',
			'show_icon'   => false,
			'quote'       => 'Skincare is a form of self-respect.',
			'attribution' => 'Cilla Skyn',
		),
		array(
			'type'        => 'caption',
			'product'     => 445, // Bakuchi Gentle Renewal Facial Oil 30ml.
			'color'       => '#C7A98C',
			'caption'     => '',
			'show_icon'   => true,
			'quote'       => '',
			'attribution' => '',
		),
		array(
			'type'        => 'caption',
			'product'     => 452, // Manketti Melt Whipped Oil Butter 250ml.
			'color'       => '#EDE4D2',
			'caption'     => '',
			'show_icon'   => true,
			'quote'       => '',
			'attribution' => '',
		),
		array(
			'type'        => 'caption',
			'product'     => 449, // Ceramide Cocoon Barrier Repair Body Lotion 500ml.
			'color'       => '#D9E0C6',
			'caption'     => '',
			'show_icon'   => false,
			'quote'       => '',
			'attribution' => '',
		),
		array(
			'type'        => 'caption',
			'product'     => 465, // Serenity Bath Soak 400ml.
			'color'       => '#DFCBAE',
			'caption'     => '',
			'show_icon'   => true,
			'quote'       => '',
			'attribution' => '',
		),
	),
);
