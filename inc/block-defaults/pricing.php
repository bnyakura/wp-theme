<?php
/**
 * Default Repeater rows for the Pricing block, mirrored from the fallback
 * arrays in blocks/pricing/render.php so the block editor form isn't blank
 * the first time it's opened.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

$book_url = home_url( '/book/' );

return array(
	'field_pricing_monthly_tiers' => array(
		array(
			'rank'        => 'Studio Access',
			'sub'         => 'Open Gym · Monthly',
			'price'       => 'R 200',
			'cadence'     => 'per month',
			'desc'        => 'Open gym access on your own terms. No coach required — just you, the equipment, and the iron.',
			'features'    => "Unlimited studio access\nSelf-directed training\nFull equipment use\nNo lock-in contract",
			'badge'       => '',
			'primary'     => 0,
			'cta_label'   => 'Get Access',
			'cta_action'  => 'packages-modal',
		),
		array(
			'rank'        => 'Platoons',
			'sub'         => 'Group Training · Monthly',
			'price'       => 'R 800',
			'cadence'     => 'per month',
			'desc'        => 'Structured group training every week. The core membership for committed members who want community and accountability.',
			'features'    => "Unlimited group sessions\nCoach-led programming\nCommunity events access\nNo lock-in contract",
			'badge'       => 'Most Popular',
			'primary'     => 1,
			'cta_label'   => 'Join Community',
			'cta_action'  => 'whatsapp-group',
		),
		array(
			'rank'        => 'Squads',
			'sub'         => 'Personal Sessions · Pack of 4',
			'price'       => 'R 950',
			'cadence'     => 'per pack',
			'desc'        => 'Four personalized 1-on-1 sessions in one block. Serious coaching for serious results — R238 per session.',
			'features'    => "4 personalized sessions\n1-on-1 coaching\nFlexible scheduling\nProgress tracking",
			'badge'       => '',
			'primary'     => 0,
			'cta_label'   => 'Get Started',
			'cta_action'  => 'packages-modal',
		),
	),
	'field_pricing_dropin_tiers'  => array(
		array(
			'rank'        => 'Platoon Drop-In',
			'sub'         => 'Group Session · Single',
			'price'       => 'R 100',
			'cadence'     => 'per session',
			'desc'        => 'Drop in for a single group session. Coach-supervised, full equipment access. No strings attached.',
			'features'    => "Single group session\nCoach-supervised\nFull equipment use\nNo contract required",
			'badge'       => 'Most Popular',
			'primary'     => 1,
			'cta_label'   => 'Book Drop-In',
			'cta_action'  => 'link',
			'cta_url'     => $book_url,
		),
		array(
			'rank'        => 'Squad Drop-In',
			'sub'         => 'Personal Session · Single',
			'price'       => 'R 200',
			'cadence'     => 'per session',
			'desc'        => 'A single personalized session with focused 1-on-1 coaching. Test the experience before committing.',
			'features'    => "Single personalized session\n1-on-1 coaching\nTailored to your goals\nNo contract required",
			'badge'       => '',
			'primary'     => 0,
			'cta_label'   => 'Book Session',
			'cta_action'  => 'link',
			'cta_url'     => $book_url,
		),
	),
);
