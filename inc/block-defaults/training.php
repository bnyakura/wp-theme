<?php
/**
 * Default Repeater rows for the Training page's split sub-blocks
 * (training-pillars, training-tracks, training-schedule,
 * training-coaches, training-steps). Field keys are unchanged from the
 * original monolithic training block, so this file didn't need to move.
 * Testimonials and pricing now come from the reused wp-theme/testimonials
 * and wp-theme/pricing blocks — see their own inc/block-defaults/ files.
 *
 * @package custom-theme
 */

defined( 'ABSPATH' ) || exit;

$book_url = home_url( '/book/' );

return array(
	'field_training_pillars' => array(
		array(
			'icon'  => 'dumbbell',
			'title' => 'Movement',
			'desc'  => 'Strength & Conditioning, Hybrid Group Classes, and Open Studio access. Every session is coach-led — not just supervised.',
			'items' => "Strength & Conditioning\nHybrid Group Classes\nOpen Studio Access",
		),
		array(
			'icon'  => 'heart',
			'title' => 'Holistic Wellness',
			'desc'  => 'Physical transformation is the byproduct of a deeper work. We train body, mind, and spirit together.',
			'items' => "Mindset Coaching\nNutrition Guidance\nRecovery Protocols",
		),
		array(
			'icon'  => 'users',
			'title' => 'Brotherhood',
			'desc'  => 'We do not train alone. The community extends beyond the gym floor — into retreats, events, and daily accountability.',
			'items' => "Community Events\nRetreats & WODs\nAccountability Groups",
		),
	),
	'field_training_tracks'   => array(
		array(
			'number'          => '01',
			'tier'            => 'For All Members',
			'title'           => 'Group Training',
			'description'     => 'Coach-led strength and conditioning sessions built for anyone willing to do the work. You are pushed, coached, and held accountable every session.',
			'plan'            => 'Platoons · R800/mo — See plan',
			'tab'             => 'monthly',
			'icon'            => 'users',
			'reverse'         => 0,
			'primary_label'   => 'Book a Drop-In',
			'primary_url'     => $book_url,
			'secondary_label' => 'View Monthly Plans',
		),
		array(
			'number'          => '02',
			'tier'            => 'Squads Tier',
			'title'           => 'Personal Coaching',
			'description'     => "Dedicated 1-on-1 time with a head coach. Custom programming, mindset work, and nutrition guidance — all built around who you're becoming, not just what you can lift.",
			'plan'            => 'Squads · R950 / 4 sessions — See plan',
			'tab'             => 'monthly',
			'icon'            => 'shield',
			'reverse'         => 1,
			'primary_label'   => 'Book Assessment',
			'primary_url'     => $book_url,
			'secondary_label' => 'View Squads Pack',
		),
		array(
			'number'          => '03',
			'tier'            => 'Self-Directed',
			'title'           => 'Open Studio',
			'description'     => 'Full facility access from 6AM to 9PM, Monday to Saturday. Run your own programme, use every piece of equipment, and check in with coaches when you need them.',
			'plan'            => 'Studio Access · R200/mo — See plan',
			'tab'             => 'monthly',
			'icon'            => 'run',
			'reverse'         => 0,
			'primary_label'   => 'Get Access',
			'primary_url'     => '#pricing',
			'secondary_label' => '',
		),
	),
	'field_training_schedule' => array(
		array(
			'day'     => 'Monday',
			'classes' => "6 AM – 7 AM — Strength & Muscle\n6 PM — Entrepreneurship Class\n6 PM – 8 PM — Boxing\n6:30 PM – 7:30 PM — Strength & HIIT",
		),
		array(
			'day'     => 'Tuesday',
			'classes' => "6 AM – 7 AM — Strength & Muscle\n6 PM – 8 PM — Boxing",
		),
		array(
			'day'     => 'Wednesday',
			'classes' => "6 AM – 7 AM — Strength & Muscle\n6:30 PM – 7:30 PM — Strength & HIIT",
		),
		array(
			'day'     => 'Thursday',
			'classes' => "6 AM – 7 AM — Strength & Muscle\n6 PM – 8 PM — Boxing",
		),
		array(
			'day'     => 'Friday',
			'classes' => '6 AM – 7 AM — Strength & Muscle',
		),
		array(
			'day'     => 'Saturday',
			'classes' => 'By Appointment Only',
		),
		array(
			'day'     => 'Sunday',
			'classes' => '6 AM – 7 AM — Strength & Muscle',
		),
	),
	'field_training_coaches'       => array(
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
	'field_training_steps'         => array(
		array(
			'number' => '01',
			'icon'   => 'clipboard',
			'title'  => 'Enlist',
			'desc'   => 'Book a free assessment or drop in for your first class. No commitment. Just show up ready to work.',
		),
		array(
			'number' => '02',
			'icon'   => 'fire',
			'title'  => 'Enter The Forge',
			'desc'   => 'Learn your foundations under expert coaching. Form before intensity — always.',
		),
		array(
			'number' => '03',
			'icon'   => 'users',
			'title'  => 'Join The Community',
			'desc'   => 'Integrate into the community. Events, accountability, and people who hold the standard as high as you do.',
		),
	),
);
