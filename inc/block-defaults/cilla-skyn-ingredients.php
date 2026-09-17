<?php
/**
 * Default Repeater rows for the Cilla Skyn Ingredients block, so the block
 * editor form isn't blank the first time it's opened.
 *
 * Content sourced from "Hero Ingredients.xlsx" (the "A–Z Ingredient
 * Library" sheet) — real copy supplied for this project, not placeholder
 * text. No default Link URL is set per row — render.php omits the "Learn
 * More" line until one is added.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_ingredients_ingredients' => array(
		array(
			'name'        => 'Bakuchiol',
			'description' => 'A botanical-derived active used to improve the appearance of uneven texture, dullness and early signs of ageing. It offers a considered approach to skin renewal and works especially well in nourishing evening formulas.',
			'benefits'    => "Renewal\nSmoothing\nRadiance",
			'best_for'    => 'Dull • Uneven • Mature-Looking Skin',
			'find_in'     => 'Bakuchi Renewal',
		),
		array(
			'name'        => 'Rosehip Oil',
			'description' => 'A botanical oil naturally rich in essential fatty acids and carotenoid compounds. It helps nourish depleted skin while supporting smoother texture and a more radiant-looking complexion.',
			'benefits'    => "Renewal\nNourishing\nRadiance",
			'best_for'    => 'Dry • Dull • Uneven-Looking • Mature Skin',
			'find_in'     => 'Pure Rosehip Oil, Bakuchi Renewal, Silhouette Therapy',
		),
		array(
			'name'        => 'Argan Oil',
			'description' => 'A Moroccan botanical oil naturally rich in fatty acids and vitamin E. It helps nourish dry skin and hair while supporting softness and suppleness.',
			'benefits'    => "Nourishing\nSoftening\nConditioning",
			'best_for'    => 'Dry • Dehydrated • Normal • Mature Skin',
			'find_in'     => 'Pure Argan Oil',
		),
		array(
			'name'        => 'Ceramides',
			'description' => "Lipids naturally found within the skin barrier. In skincare, they help reinforce the skin's protective lipid structure, reduce moisture loss and support smoother, more comfortable-feeling skin.",
			'benefits'    => "Barrier Support\nMoisture Retention\nComfort",
			'best_for'    => 'Dry • Very Dry • Sensitive • Barrier-Impaired Skin',
			'find_in'     => 'Ceramide Cocoon, Cera-Ectoin Barrier Balance Mist',
		),
		array(
			'name'        => 'Rhassoul Clay',
			'description' => 'A naturally occurring Moroccan clay traditionally used in skin and hair rituals. It absorbs excess oils while helping leave the skin feeling smooth, soft and polished.',
			'benefits'    => "Purifying\nSmoothing\nMineral-Rich",
			'best_for'    => 'Normal • Combination • Oily Skin',
			'find_in'     => 'Rhassoul Clay Polish',
		),
		array(
			'name'        => 'Squalane',
			'description' => 'A highly skin-compatible emollient that helps replenish softness and reduce moisture loss without an overly greasy feel. Its elegant texture makes it particularly useful across facial and body care formulas.',
			'benefits'    => "Barrier Support\nSoftening\nLightweight Lipid",
			'best_for'    => 'All Skin Types',
			'find_in'     => '',
		),
	),
);
