<?php
/**
 * Default Repeater rows for the Cilla Skyn Shop by Concern block, so the
 * block editor form isn't blank the first time it's opened.
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
			'title'    => 'Dryness & Dehydration',
			'subtitle' => 'Replenish. Restore. Rebalance.',
		),
		array(
			'title'    => 'Uneven Tone',
			'subtitle' => 'A more even, radiant you.',
		),
		array(
			'title'    => 'Blemishes & Congestion',
			'subtitle' => 'Clearer skin, calmer days.',
		),
		array(
			'title'    => 'Sensitive Barrier Care',
			'subtitle' => 'Kind care. Lasting strength.',
		),
		array(
			'title'    => 'Dullness & Texture',
			'subtitle' => 'Smoother. Brighter. Renewed.',
		),
		array(
			'title'    => 'Body Nourishment',
			'subtitle' => 'Head to toe hydration.',
		),
	),
);
