<?php
/**
 * Default Repeater rows for the Cilla Skyn Shop by Concern block, so the
 * block editor form isn't blank the first time it's opened.
 *
 * Titles match the 6-category list under "Recommended website 'Shop by
 * Concern'" in NewProject/Cilla Skyn Website Layout.docx (the client's own
 * spec for this section's homepage/navigation tiles); subtitles summarise
 * that same document's per-category product tables.
 *
 * No default `product` is set per row — that's a real WooCommerce product
 * ID, which doesn't exist yet on a fresh install. render.php falls back to
 * WooCommerce's own placeholder image until a product is picked for a row.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_shop_by_concern_concerns' => array(
		array(
			'title'    => 'Oily & Acne Prone',
			'subtitle' => 'Clearer skin, calmer days.',
		),
		array(
			'title'    => 'Sensitive & Eczema Prone',
			'subtitle' => 'Kind care. Lasting strength.',
		),
		array(
			'title'    => 'Dry & Dehydrated',
			'subtitle' => 'Replenish. Restore. Rebalance.',
		),
		array(
			'title'    => 'Uneven Tone & Dark Marks',
			'subtitle' => 'A more even, radiant you.',
		),
		array(
			'title'    => 'Texture & Ageing',
			'subtitle' => 'Smoother. Brighter. Renewed.',
		),
		array(
			'title'    => 'Firmness & Body Texture',
			'subtitle' => 'Firmness, elasticity & tone.',
		),
	),
);
