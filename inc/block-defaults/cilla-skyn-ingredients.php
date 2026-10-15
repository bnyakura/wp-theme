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
 * Description and Benefits are WYSIWYG (rich-text) fields, so their defaults
 * are HTML: a paragraph for the description and a bullet list for the
 * benefits, which is how the editor stores and render.php prints them.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_cilla_skyn_ingredients_ingredients' => array(
		array(
			'name'        => 'Bakuchiol',
			'description' => '<p>A botanical-derived active used to improve the appearance of uneven texture, dullness and early signs of ageing. It offers a considered approach to skin renewal and works especially well in nourishing evening formulas.</p>',
			'benefits'    => "<ul>\n<li>Renewal</li>\n<li>Smoothing</li>\n<li>Radiance</li>\n</ul>",
			'best_for'    => 'Dull • Uneven • Mature-Looking Skin',
			'find_in'     => 'Bakuchi Renewal',
		),
		array(
			'name'        => 'Rosehip Oil',
			'description' => '<p>A botanical oil naturally rich in essential fatty acids and carotenoid compounds. It helps nourish depleted skin while supporting smoother texture and a more radiant-looking complexion.</p>',
			'benefits'    => "<ul>\n<li>Renewal</li>\n<li>Nourishing</li>\n<li>Radiance</li>\n</ul>",
			'best_for'    => 'Dry • Dull • Uneven-Looking • Mature Skin',
			'find_in'     => 'Pure Rosehip Oil, Bakuchi Renewal, Silhouette Therapy',
		),
		array(
			'name'        => 'Argan Oil',
			'description' => '<p>A Moroccan botanical oil naturally rich in fatty acids and vitamin E. It helps nourish dry skin and hair while supporting softness and suppleness.</p>',
			'benefits'    => "<ul>\n<li>Nourishing</li>\n<li>Softening</li>\n<li>Conditioning</li>\n</ul>",
			'best_for'    => 'Dry • Dehydrated • Normal • Mature Skin',
			'find_in'     => 'Pure Argan Oil',
		),
		array(
			'name'        => 'Ceramides',
			'description' => "<p>Lipids naturally found within the skin barrier. In skincare, they help reinforce the skin's protective lipid structure, reduce moisture loss and support smoother, more comfortable-feeling skin.</p>",
			'benefits'    => "<ul>\n<li>Barrier Support</li>\n<li>Moisture Retention</li>\n<li>Comfort</li>\n</ul>",
			'best_for'    => 'Dry • Very Dry • Sensitive • Barrier-Impaired Skin',
			'find_in'     => 'Ceramide Cocoon, Cera-Ectoin Barrier Balance Mist',
		),
		array(
			'name'        => 'Rhassoul Clay',
			'description' => '<p>A naturally occurring Moroccan clay traditionally used in skin and hair rituals. It absorbs excess oils while helping leave the skin feeling smooth, soft and polished.</p>',
			'benefits'    => "<ul>\n<li>Purifying</li>\n<li>Smoothing</li>\n<li>Mineral-Rich</li>\n</ul>",
			'best_for'    => 'Normal • Combination • Oily Skin',
			'find_in'     => 'Rhassoul Clay Polish',
		),
		array(
			'name'        => 'Squalane',
			'description' => '<p>A highly skin-compatible emollient that helps replenish softness and reduce moisture loss without an overly greasy feel. Its elegant texture makes it particularly useful across facial and body care formulas.</p>',
			'benefits'    => "<ul>\n<li>Barrier Support</li>\n<li>Softening</li>\n<li>Lightweight Lipid</li>\n</ul>",
			'best_for'    => 'All Skin Types',
			'find_in'     => '',
		),
	),
);
