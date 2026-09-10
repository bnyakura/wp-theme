<?php
/**
 * Default Repeater rows for the Cilla Skyn Ingredients block, so the block
 * editor form isn't blank the first time it's opened.
 *
 * These ingredient picks and descriptions were written for this block,
 * not supplied by the client — NewProject/Cilla Skyn Website Layout.docx
 * only mentions ingredients as part of product names (e.g. "Bakuchi
 * Renewal Facial Oil", "Pure Rosehip Oil"), with no standalone ingredient
 * copy. Review and replace before launch. No default `image` is set per
 * row — render.php falls back to a plain colour swatch until one is
 * uploaded.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_ingredients_ingredients' => array(
		array(
			'name'        => 'Bakuchiol',
			'description' => 'A gentle, plant-based alternative to retinol that supports visible renewal without compromising the skin barrier.',
		),
		array(
			'name'        => 'Rosehip Oil',
			'description' => 'Rich in essential fatty acids and antioxidants, prized for nourishing dry, dull and uneven-looking skin.',
		),
		array(
			'name'        => 'Argan Oil',
			'description' => "A nutrient-dense oil that conditions and softens while helping to reinforce the skin's natural barrier.",
		),
		array(
			'name'        => 'Ceramides',
			'description' => 'Lipids that help restore and maintain a healthy, resilient skin barrier.',
		),
		array(
			'name'        => 'Rhassoul Clay',
			'description' => 'A mineral-rich clay used to gently polish and clarify without stripping the skin.',
		),
		array(
			'name'        => 'Squalane',
			'description' => "A lightweight, non-greasy emollient that mimics the skin's own natural oils for deep hydration.",
		),
	),
);
