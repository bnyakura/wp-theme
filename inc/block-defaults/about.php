<?php
/**
 * Default Repeater rows for the About block, mirrored from the fallback
 * arrays in blocks/about/render.php so the block editor form isn't blank
 * the first time it's opened.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

return array(
	'field_about_origin_paragraphs' => array(
		array(
			'paragraph' => "Iron Gorilla didn't start with a business plan. It started with a friendship.",
		),
		array(
			'paragraph' => 'Paul and Rhema met as friends and colleagues — two men from different worlds who found common ground in the relentless pursuit of physical excellence. What started as early morning gym sessions slowly became something neither of them could ignore. The floor became a boardroom. The barbells became mirrors. And somewhere in the silence between sets, a vision took shape.',
		),
		array(
			'paragraph' => 'They called it a sacred space — a place where iron genuinely sharpened iron. Not just the body, but the character, the purpose, the brotherhood. The gym sessions became a proving ground. Accountability replaced excuses. And the seed of something bigger was planted.',
		),
		array(
			'paragraph' => "The vision crystallised when they met Bongi at a community camp. Looking around at the men who showed up — hungry for structure, starved of direction — the need was undeniable. This wasn't just about training. It was about building something that could carry men forward.",
		),
		array(
			'paragraph' => 'Othniel joined the mission. Then Junior. Each one arriving with exactly what the army needed. From Salt River, Cape Town — Iron Gorilla Army was born. Not as a gym. As a movement.',
		),
	),
	'field_about_values'             => array(
		array(
			'icon'  => 'dumbbell',
			'title' => 'Iron Discipline',
			'desc'  => 'We show up when it is hard. We do the work when no one is watching. Discipline is not motivation — it is commitment.',
		),
		array(
			'icon'  => 'heart',
			'title' => 'Faith First',
			'desc'  => 'Our values are rooted in scripture. We believe that strength begins in the spirit before it shows in the body.',
		),
		array(
			'icon'  => 'users',
			'title' => 'Brotherhood',
			'desc'  => "We do not train alone. We hold each other accountable. We celebrate each other's victories and carry each other's weight.",
		),
	),
	'field_about_coaches'            => array(
		array(
			'initials' => 'PA',
			'name'     => 'Paul',
			'role'     => 'Entrepreneur & Business Coach · Co-Founder',
			'bio'      => 'With over 20 years at CFO level across corporate South Africa, Paul knows the weight that comes with leading — and the cost of neglecting the body while doing it. He brings executive experience and physical discipline together, running entrepreneurship and business classes fused with fitness. Stress management, business strategy, personal accountability — Paul trains the whole person.',
			'position' => 'center center',
		),
		array(
			'initials' => 'RH',
			'name'     => 'Rhema',
			'role'     => 'Boxing Coach · Co-Founder',
			'bio'      => 'Rhema is an amateur boxer and certified boxing coach who built Iron Gorilla alongside Paul from the ground up. He runs the boxing programme at The Forge — teaching technique, discipline, and the mental edge that only combat sports develop. Inside these walls, Rhema is where aggression meets purpose.',
			'position' => 'center 22%',
		),
		array(
			'initials' => 'OT',
			'name'     => 'Othniel',
			'role'     => 'Personal Trainer · Strength & Conditioning',
			'bio'      => 'Othniel is a certified personal trainer with over 5 years of hands-on experience in strength and conditioning. He specialises in building physical foundations — movement quality, progressive overload, and the consistency that produces lasting results. If you want to get stronger and move better, Othniel builds the programme.',
			'position' => 'center 25%',
		),
		array(
			'initials' => 'BG',
			'name'     => 'Bongi',
			'role'     => 'Strength & Conditioning Specialist',
			'bio'      => "Bongi brings a biotech background and a deep specialisation in strength and conditioning. His science-first approach to training has attracted major clients who demand real results — not guesswork. Bongi's coaching is built on precision: understanding how the body adapts, and pushing it further than it thought possible.",
			'position' => 'center 20%',
		),
		array(
			'initials' => 'JR',
			'name'     => 'Junior',
			'role'     => 'Calisthenics Coach',
			'bio'      => "Junior is Iron Gorilla's calisthenics coach — specialising in bodyweight movement, relative strength, and functional fitness that travels with you anywhere. His approach strips training back to its foundation: master your own body before you touch a weight. Every rep is intentional. Every session builds the base.",
			'position' => 'center center',
		),
	),
);
