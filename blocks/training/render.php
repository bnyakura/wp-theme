<?php
/**
 * Training block — render template.
 *
 * Reads ACF fields and falls back to the original Iron Gorilla content, so
 * the page looks complete the moment the theme is activated.
 *
 * Expected image locations inside the active theme:
 *   /assets/images/forge-gym.png
 *   /assets/images/coaches/coach-rhema.jpg
 *   /assets/images/coaches/coach-othniel.jpg
 *   /assets/images/coaches/coach-bongi.jpg
 *
 * @package Iron_Gorilla
 */

$iga_theme_uri = get_stylesheet_directory_uri();

/**
 * Filter these paths if your theme keeps images in another directory.
 */
$iga_training_images = apply_filters(
	'iga_training_images',
	array(
		'hero'          => $iga_theme_uri . '/assets/images/forge-gym.png',
		'coach_rhema'   => $iga_theme_uri . '/assets/images/coaches/coach-rhema.jpg',
		'coach_othniel' => $iga_theme_uri . '/assets/images/coaches/coach-othniel.jpg',
		'coach_bongi'   => $iga_theme_uri . '/assets/images/coaches/coach-bongi.jpg',
	)
);

$iga_training_urls = array(
	'book'    => home_url( '/book/' ),
	'contact' => home_url( '/contact/' ),
	'faq'     => home_url( '/faq/' ),
);

/* Small inline SVG set, so the block does not depend on an icon plugin. */
$iga_training_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'dumbbell'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'heart'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0 5.25-9 11.25-9 11.25S3 13.5 3 8.25A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 9 .25Z"/>',
		'users'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Zm13.7-12.7a3 3 0 0 1 1.3 5.7m2.25 6a6 6 0 0 0-3.7-5.55"/>',
		'shield'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4.5 6v5.25c0 4.8 3.2 8.25 7.5 9.75 4.3-1.5 7.5-4.95 7.5-9.75V6L12 3Zm-2.25 9 1.5 1.5 3.25-3.5"/>',
		'run'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 5.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Zm-3.9 5.1 2.1-2.85 2.55 2.1 2.7.45m-8.1 2.1 3.15 1.35 1.5 3.75m-4.65-5.1-2.1 3.15-3 .9m8.25-2.7-2.25 4.8-3.75 2.7"/>',
		'clipboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25H6.75A2.25 2.25 0 0 0 4.5 7.5v12a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-12a2.25 2.25 0 0 0-2.25-2.25H15M9 5.25a3 3 0 0 1 6 0M9 5.25h6m-6 8.25 2 2 4-4"/>',
		'fire'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 22.5c4.15 0 7.5-3.13 7.5-7.2 0-2.7-1.35-5.18-4.05-7.43.08 2.48-.82 3.98-2.18 4.8.08-4.2-2.02-7.57-5.02-10.17.3 3.68-3.75 6.3-3.75 11.85 0 4.5 3.35 8.15 7.5 8.15Zm0 0c-1.65 0-3-1.27-3-2.92 0-1.28.75-2.4 2.25-3.83.08 1.28.68 2.03 1.58 2.48.15-1.2.67-2.18 1.42-3.08.53 1.35.75 2.48.75 3.45 0 2.18-1.35 3.9-3 3.9Z"/>',
		'location'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 5.25-7.5 11.25-7.5 11.25S4.5 15.75 4.5 10.5a7.5 7.5 0 1 1 15 0Zm-5.25 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
		'calendar'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
		'check'     => '<path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4.25 4.25L19 6.5"/>',
		'arrow'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
		'chevron'   => '<path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>',
		'tag'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5v5.25L13.5 19.5a2.12 2.12 0 0 0 3 0l3-3a2.12 2.12 0 0 0 0-3L9.75 3.75H4.5a.75.75 0 0 0-.75.75Zm3.75 3a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>',
		'quote'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 11.25H3.75V7.5A3.75 3.75 0 0 1 7.5 3.75v7.5Zm12.75 0H16.5V7.5a3.75 3.75 0 0 1 3.75-3.75v7.5Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['check'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

$iga_training_section_header = static function ( $eyebrow, $title, $subtitle = '' ) {
	?>
	<div class="mx-auto mb-12 max-w-3xl text-center">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-green"></span>
			<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l"><?php echo esc_html( $eyebrow ); ?></span>
			<span class="h-px w-10 bg-green"></span>
		</div>
		<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
			<?php echo esc_html( $title ); ?>
		</h2>
		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
	<?php
};

/**
 * Resolve an ACF image field (id) to a URL, falling back to $default.
 */
$iga_training_image_url = static function ( $image_id, $default = '' ) {
	if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
		$url = wp_get_attachment_image_url( (int) $image_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return $default;
};

/**
 * Split a textarea into a trimmed line array.
 */
$iga_training_lines = static function ( $raw ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	return array_values(
		array_filter(
			array_map( 'trim', $lines ),
			static function ( $line ) {
				return '' !== $line;
			}
		)
	);
};

$iga_training_pillars = array(
	array(
		'icon'  => 'dumbbell',
		'title' => 'Movement',
		'desc'  => 'Strength & Conditioning, Hybrid Group Classes, and Open Studio access. Every session is coach-led — not just supervised.',
		'items' => array( 'Strength & Conditioning', 'Hybrid Group Classes', 'Open Studio Access' ),
	),
	array(
		'icon'  => 'heart',
		'title' => 'Holistic Wellness',
		'desc'  => 'Physical transformation is the byproduct of deeper work. We train body, mind, and spirit together.',
		'items' => array( 'Mindset Coaching', 'Nutrition Guidance', 'Recovery Protocols' ),
	),
	array(
		'icon'  => 'users',
		'title' => 'Brotherhood',
		'desc'  => 'We do not train alone. The community extends beyond the gym floor — into retreats, events, and daily accountability.',
		'items' => array( 'Community Events', 'Retreats & WODs', 'Accountability Groups' ),
	),
);

$iga_training_tracks = array(
	array(
		'number'      => '01',
		'tier'        => 'For All Members',
		'title'       => 'Group Training',
		'description' => 'Coach-led strength and conditioning sessions built for anyone willing to do the work. You are pushed, coached, and held accountable every session.',
		'plan'        => 'Platoons · R800/mo — See plan',
		'tab'         => 'monthly',
		'icon'        => 'users',
		'visual'      => 'bg-gradient-to-br from-[#0D1A0F] to-[#1A3320]',
		'reverse'     => false,
		'primary'     => 'Book a Drop-In',
		'primary_url' => $iga_training_urls['book'],
		'secondary'   => 'View Monthly Plans',
	),
	array(
		'number'      => '02',
		'tier'        => 'Squads Tier',
		'title'       => 'Personal Coaching',
		'description' => "Dedicated 1-on-1 time with a head coach. Custom programming, mindset work, and nutrition guidance — all built around who you're becoming, not just what you can lift.",
		'plan'        => 'Squads · R950 / 4 sessions — See plan',
		'tab'         => 'monthly',
		'icon'        => 'shield',
		'visual'      => 'bg-gradient-to-br from-[#111111] to-[#1A1A0A]',
		'reverse'     => true,
		'primary'     => 'Book a Session',
		'primary_url' => $iga_training_urls['book'],
		'secondary'   => 'View Squads Pack',
	),
	array(
		'number'      => '03',
		'tier'        => 'Self-Directed',
		'title'       => 'Open Studio',
		'description' => 'Full facility access from 6AM to 9PM, Monday to Saturday. Run your own programme, use every piece of equipment, and check in with coaches when you need them.',
		'plan'        => 'Studio Access · R200/mo — See plan',
		'tab'         => 'monthly',
		'icon'        => 'run',
		'visual'      => 'bg-gradient-to-br from-[#0A0A12] to-[#0D1520]',
		'reverse'     => false,
		'primary'     => 'Get Access',
		'primary_url' => '#pricing',
		'secondary'   => '',
	),
);

$iga_training_schedule = array(
	array( 'day' => 'Monday',    'classes' => array( '6 AM – 7 AM — Strength & Muscle', '6 PM — Entrepreneurship Class', '6 PM – 8 PM — Boxing', '6:30 PM – 7:30 PM — Strength & HIIT' ) ),
	array( 'day' => 'Tuesday',   'classes' => array( '6 AM – 7 AM — Strength & Muscle', '6 PM – 8 PM — Boxing' ) ),
	array( 'day' => 'Wednesday', 'classes' => array( '6 AM – 7 AM — Strength & Muscle', '6:30 PM – 7:30 PM — Strength & HIIT' ) ),
	array( 'day' => 'Thursday',  'classes' => array( '6 AM – 7 AM — Strength & Muscle', '6 PM – 8 PM — Boxing' ) ),
	array( 'day' => 'Friday',    'classes' => array( '6 AM – 7 AM — Strength & Muscle' ) ),
	array( 'day' => 'Saturday',  'classes' => array( 'By Appointment Only' ) ),
	array( 'day' => 'Sunday',    'classes' => array( '6 AM – 7 AM — Strength & Muscle' ) ),
);

$iga_training_testimonials = array(
	array(
		'initials' => 'K',
		'name'     => 'Kamva',
		'location' => 'Fisantekraal',
		'quote'    => 'Iron Gorilla is more than a brotherhood. The community pushes me to stay fit and always want to be better. We are an amalgam of aggression and compassion — exactly what I needed. I feel safe. I feel part of something.',
		'result'   => 'Member since age 18',
	),
	array(
		'initials' => 'D',
		'name'     => 'Deogracias',
		'location' => 'Observatory',
		'quote'    => "I've lost 10kg being part of this community. What kept me going was knowing everyone here is on their own journey of self-betterment. It's not about the weight — it's about the journey everyone is on.",
		'result'   => 'Lost 10kg · Since 2020',
	),
	array(
		'initials' => 'M',
		'name'     => 'Micah',
		'location' => 'Khayelitsha',
		'quote'    => "I sometimes feel misunderstood. But Iron Gorilla has challenged me — not just physically in the boxing classes, but mentally too. That's the difference that keeps me coming back.",
		'result'   => 'Physically & Mentally Challenged',
	),
);

$iga_training_monthly_plans = array(
	array(
		'rank'     => 'Studio Access',
		'subtitle' => 'Open Gym · Monthly',
		'price'    => 'R 200',
		'cadence'  => 'per month',
		'desc'     => 'Open gym access on your own terms. No coach required — just you, the equipment, and the iron.',
		'features' => array( 'Unlimited studio access', 'Self-directed training', 'Full equipment use', 'No lock-in contract' ),
		'cta'      => 'Get Access',
		'url'      => add_query_arg( 'plan', 'studio-access', $iga_training_urls['contact'] ),
		'primary'  => false,
		'badge'    => '',
	),
	array(
		'rank'     => 'Platoons',
		'subtitle' => 'Group Training · Monthly',
		'price'    => 'R 800',
		'cadence'  => 'per month',
		'desc'     => 'Structured group training every week. The core membership for committed members who want community and accountability.',
		'features' => array( 'Unlimited group sessions', 'Coach-led programming', 'Community events access', 'No lock-in contract' ),
		'cta'      => 'Enlist Now',
		'url'      => add_query_arg( 'plan', 'platoons', $iga_training_urls['contact'] ),
		'primary'  => true,
		'badge'    => 'Most Popular',
	),
	array(
		'rank'     => 'Squads',
		'subtitle' => 'Personal Sessions · Pack of 4',
		'price'    => 'R 950',
		'cadence'  => 'per pack',
		'desc'     => 'Four personalized 1-on-1 sessions in one block. Serious coaching for serious results — R238 per session.',
		'features' => array( '4 personalized sessions', '1-on-1 coaching', 'Flexible scheduling', 'Progress tracking' ),
		'cta'      => 'Get Started',
		'url'      => add_query_arg( 'plan', 'squads', $iga_training_urls['contact'] ),
		'primary'  => false,
		'badge'    => '',
	),
);

$iga_training_dropin_plans = array(
	array(
		'rank'     => 'Platoon Drop-In',
		'subtitle' => 'Group Session · Single',
		'price'    => 'R 100',
		'cadence'  => 'per session',
		'desc'     => 'Drop in for a single group session. Coach-supervised, full equipment access. No strings attached.',
		'features' => array( 'Single group session', 'Coach-supervised', 'Full equipment use', 'No contract required' ),
		'cta'      => 'Book Drop-In',
		'url'      => $iga_training_urls['book'],
		'primary'  => true,
		'badge'    => 'Most Popular',
	),
	array(
		'rank'     => 'Squad Drop-In',
		'subtitle' => 'Personal Session · Single',
		'price'    => 'R 200',
		'cadence'  => 'per session',
		'desc'     => 'A single personalized session with focused 1-on-1 coaching. Test the experience before committing.',
		'features' => array( 'Single personalized session', '1-on-1 coaching', 'Tailored to your goals', 'No contract required' ),
		'cta'      => 'Book Session',
		'url'      => $iga_training_urls['book'],
		'primary'  => false,
		'badge'    => '',
	),
);

$iga_training_coaches = array(
	array(
		'initials' => 'PA',
		'name'     => 'Paul',
		'role'     => 'Entrepreneur & Business Coach · Co-Founder',
		'bio'      => 'With over 20 years at CFO level across corporate South Africa, Paul brings executive experience and physical discipline together, training the whole person through business strategy, stress management, and accountability.',
	),
	array(
		'initials' => 'RH',
		'name'     => 'Rhema',
		'role'     => 'Boxing Coach · Co-Founder',
		'bio'      => 'An amateur boxer and certified boxing coach, Rhema teaches technique, discipline, and the mental edge that only combat sports develop. Inside these walls, aggression meets purpose.',
		'image'    => $iga_training_images['coach_rhema'],
		'position' => 'center 22%',
	),
	array(
		'initials' => 'OT',
		'name'     => 'Othniel',
		'role'     => 'Personal Trainer · Strength & Conditioning',
		'bio'      => 'A certified personal trainer with over five years of hands-on experience. Othniel builds physical foundations through movement quality, progressive overload, and lasting consistency.',
		'image'    => $iga_training_images['coach_othniel'],
		'position' => 'center 25%',
	),
	array(
		'initials' => 'BG',
		'name'     => 'Bongi',
		'role'     => 'Strength & Conditioning Specialist',
		'bio'      => "Bongi brings a biotech background and a science-first approach to strength and conditioning. His coaching is built on precision and understanding how the body adapts.",
		'image'    => $iga_training_images['coach_bongi'],
		'position' => 'center 20%',
	),
	array(
		'initials' => 'JR',
		'name'     => 'Junior',
		'role'     => 'Calisthenics Coach',
		'bio'      => 'Junior specialises in bodyweight movement, relative strength, and functional fitness. Master your own body before you touch a weight — every rep is intentional.',
	),
);

$iga_training_steps = array(
	array( 'number' => '01', 'icon' => 'clipboard', 'title' => 'Enlist', 'desc' => 'Book a free assessment or drop in for your first class. No commitment. Just show up ready to work.' ),
	array( 'number' => '02', 'icon' => 'fire', 'title' => 'Enter The Forge', 'desc' => 'Learn your foundations under expert coaching. Form before intensity — always.' ),
	array( 'number' => '03', 'icon' => 'users', 'title' => 'Join The Community', 'desc' => 'Integrate into the community. Events, accountability, and people who hold the standard as high as you do.' ),
);

// ACF overrides (empty fields/repeaters fall back to the defaults above).
$iga_training_hero = array(
	'eyebrow'  => get_field( 'hero_eyebrow' ),
	'title_1'  => get_field( 'hero_title_line_1' ),
	'accent'   => get_field( 'hero_title_accent' ),
	'title_2'  => get_field( 'hero_title_line_2' ),
	'subtitle' => get_field( 'hero_subtitle' ),
	'location' => get_field( 'hero_location' ),
	'image'    => $iga_training_image_url( get_field( 'hero_image' ), $iga_training_images['hero'] ),
);

$iga_training_hero['eyebrow']  = $iga_training_hero['eyebrow'] ?: 'The Forge · Salt River, Cape Town';
$iga_training_hero['title_1']  = $iga_training_hero['title_1'] ?: 'Forge Unbreakable';
$iga_training_hero['accent']   = $iga_training_hero['accent'] ?: 'Strength & Discipline';
$iga_training_hero['title_2']  = $iga_training_hero['title_2'] ?: 'Without the Chaos';
$iga_training_hero['subtitle'] = $iga_training_hero['subtitle'] ?: 'A results-driven coaching brotherhood. Body, mind, and spirit — trained together. Not a commercial gym. A standard.';
$iga_training_hero['location'] = $iga_training_hero['location'] ?: 'Unit 209 Salt Circle, Kent Str, Salt River, Cape Town';

$iga_pillars_acf = get_field( 'pillars' );
if ( is_array( $iga_pillars_acf ) && ! empty( $iga_pillars_acf ) ) {
	$iga_training_pillars = array();
	foreach ( $iga_pillars_acf as $pillar ) {
		if ( empty( $pillar['title'] ) ) {
			continue;
		}
		$iga_training_pillars[] = array(
			'icon'  => ! empty( $pillar['icon'] ) ? $pillar['icon'] : 'dumbbell',
			'title' => $pillar['title'],
			'desc'  => isset( $pillar['desc'] ) ? $pillar['desc'] : '',
			'items' => $iga_training_lines( isset( $pillar['items'] ) ? $pillar['items'] : '' ),
		);
	}
}

$iga_tracks_acf = get_field( 'tracks' );
if ( is_array( $iga_tracks_acf ) && ! empty( $iga_tracks_acf ) ) {
	$iga_training_tracks = array();
	foreach ( $iga_tracks_acf as $index => $track ) {
		if ( empty( $track['title'] ) ) {
			continue;
		}
		$iga_training_tracks[] = array(
			'number'      => ! empty( $track['number'] ) ? $track['number'] : str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ),
			'tier'        => isset( $track['tier'] ) ? $track['tier'] : '',
			'title'       => $track['title'],
			'description' => isset( $track['description'] ) ? $track['description'] : '',
			'plan'        => isset( $track['plan'] ) ? $track['plan'] : '',
			'tab'         => ! empty( $track['tab'] ) ? $track['tab'] : 'monthly',
			'icon'        => ! empty( $track['icon'] ) ? $track['icon'] : 'users',
			'visual'      => 'bg-gradient-to-br from-[#111111] to-[#1A1A1A]',
			'reverse'     => ! empty( $track['reverse'] ),
			'primary'     => ! empty( $track['primary_label'] ) ? $track['primary_label'] : 'Book a Drop-In',
			'primary_url' => ! empty( $track['primary_url'] ) ? $track['primary_url'] : $iga_training_urls['book'],
			'secondary'   => isset( $track['secondary_label'] ) ? $track['secondary_label'] : '',
		);
	}
}

$iga_schedule_acf = get_field( 'schedule' );
if ( is_array( $iga_schedule_acf ) && ! empty( $iga_schedule_acf ) ) {
	$iga_training_schedule = array();
	foreach ( $iga_schedule_acf as $day ) {
		if ( empty( $day['day'] ) ) {
			continue;
		}
		$iga_training_schedule[] = array(
			'day'     => $day['day'],
			'classes' => $iga_training_lines( isset( $day['classes'] ) ? $day['classes'] : '' ),
		);
	}
}

$iga_testimonials_acf = get_field( 'testimonials' );
if ( is_array( $iga_testimonials_acf ) && ! empty( $iga_testimonials_acf ) ) {
	$iga_training_testimonials = array();
	foreach ( $iga_testimonials_acf as $testimonial ) {
		if ( empty( $testimonial['quote'] ) ) {
			continue;
		}
		$iga_training_testimonials[] = array(
			'initials' => ! empty( $testimonial['initials'] ) ? $testimonial['initials'] : '',
			'name'     => isset( $testimonial['name'] ) ? $testimonial['name'] : '',
			'location' => isset( $testimonial['location'] ) ? $testimonial['location'] : '',
			'quote'    => $testimonial['quote'],
			'result'   => isset( $testimonial['result'] ) ? $testimonial['result'] : '',
		);
	}
}

$iga_training_plan_from_acf = static function ( $plan, $fallback_url ) use ( $iga_training_lines ) {
	return array(
		'rank'     => $plan['rank'],
		'subtitle' => isset( $plan['subtitle'] ) ? $plan['subtitle'] : '',
		'price'    => isset( $plan['price'] ) ? $plan['price'] : '',
		'cadence'  => isset( $plan['cadence'] ) ? $plan['cadence'] : '',
		'desc'     => isset( $plan['desc'] ) ? $plan['desc'] : '',
		'features' => $iga_training_lines( isset( $plan['features'] ) ? $plan['features'] : '' ),
		'cta'      => isset( $plan['cta_label'] ) ? $plan['cta_label'] : '',
		'url'      => ! empty( $plan['url'] ) ? $plan['url'] : $fallback_url,
		'primary'  => ! empty( $plan['primary'] ),
		'badge'    => isset( $plan['badge'] ) ? $plan['badge'] : '',
	);
};

$iga_monthly_plans_acf = get_field( 'monthly_plans' );
if ( is_array( $iga_monthly_plans_acf ) && ! empty( $iga_monthly_plans_acf ) ) {
	$iga_training_monthly_plans = array();
	foreach ( $iga_monthly_plans_acf as $plan ) {
		if ( empty( $plan['rank'] ) ) {
			continue;
		}
		$iga_training_monthly_plans[] = $iga_training_plan_from_acf( $plan, $iga_training_urls['contact'] );
	}
}

$iga_dropin_plans_acf = get_field( 'dropin_plans' );
if ( is_array( $iga_dropin_plans_acf ) && ! empty( $iga_dropin_plans_acf ) ) {
	$iga_training_dropin_plans = array();
	foreach ( $iga_dropin_plans_acf as $plan ) {
		if ( empty( $plan['rank'] ) ) {
			continue;
		}
		$iga_training_dropin_plans[] = $iga_training_plan_from_acf( $plan, $iga_training_urls['book'] );
	}
}

$iga_coaches_acf = get_field( 'coaches' );
if ( is_array( $iga_coaches_acf ) && ! empty( $iga_coaches_acf ) ) {
	$iga_training_coaches = array();
	foreach ( $iga_coaches_acf as $coach ) {
		if ( empty( $coach['name'] ) ) {
			continue;
		}
		$iga_training_coaches[] = array(
			'initials' => ! empty( $coach['initials'] ) ? $coach['initials'] : '',
			'name'     => $coach['name'],
			'role'     => isset( $coach['role'] ) ? $coach['role'] : '',
			'bio'      => isset( $coach['bio'] ) ? $coach['bio'] : '',
			'image'    => $iga_training_image_url( isset( $coach['image'] ) ? $coach['image'] : '' ),
			'position' => ! empty( $coach['position'] ) ? $coach['position'] : 'center center',
		);
	}
}

$iga_steps_acf = get_field( 'steps' );
if ( is_array( $iga_steps_acf ) && ! empty( $iga_steps_acf ) ) {
	$iga_training_steps = array();
	foreach ( $iga_steps_acf as $index => $step ) {
		if ( empty( $step['title'] ) ) {
			continue;
		}
		$iga_training_steps[] = array(
			'number' => ! empty( $step['number'] ) ? $step['number'] : str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ),
			'icon'   => ! empty( $step['icon'] ) ? $step['icon'] : 'clipboard',
			'title'  => $step['title'],
			'desc'   => isset( $step['desc'] ) ? $step['desc'] : '',
		);
	}
}

$iga_training_cta = array(
	'eyebrow'  => get_field( 'cta_eyebrow' ),
	'title'    => get_field( 'cta_title' ),
	'subtitle' => get_field( 'cta_subtitle' ),
);

$iga_training_cta['eyebrow']  = $iga_training_cta['eyebrow'] ?: 'Ready?';
$iga_training_cta['title']    = $iga_training_cta['title'] ?: 'Your First Session Is Free';
$iga_training_cta['subtitle'] = $iga_training_cta['subtitle'] ?: 'Zero pressure. No commitment. Come in, meet the coaches, and see if The Forge is where you belong.';

$iga_training_pricing_card = static function ( $plan ) use ( $iga_training_icon ) {
	$is_primary = ! empty( $plan['primary'] );
	$card_class = $is_primary
		? 'relative flex h-full flex-col rounded-2xl border border-green/70 bg-gradient-to-br from-[#18301D]/70 to-s1 p-7 shadow-[0_20px_60px_rgba(58,125,68,0.10)] transition duration-300 hover:-translate-y-1 hover:border-green-l min-[481px]:p-8'
		: 'relative flex h-full flex-col rounded-2xl border border-white/10 bg-s1 p-7 transition duration-300 hover:-translate-y-1 hover:border-white/20 min-[481px]:p-8';
	?>
	<article class="<?php echo esc_attr( $card_class ); ?>">
		<?php if ( ! empty( $plan['badge'] ) ) : ?>
			<span class="absolute left-1/2 top-0 -translate-x-1/2 rounded-b-lg bg-green px-4 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-white">
				<?php echo esc_html( $plan['badge'] ); ?>
			</span>
		<?php endif; ?>

		<div class="mb-4 <?php echo ! empty( $plan['badge'] ) ? 'pt-3' : ''; ?>">
			<p class="mb-2 text-[10px] font-bold uppercase tracking-[0.2em] <?php echo $is_primary ? 'text-green-l' : 'text-white/40'; ?>">
				<?php echo esc_html( $plan['subtitle'] ); ?>
			</p>
			<h3 class="font-display text-3xl uppercase tracking-[0.04em] text-white"><?php echo esc_html( $plan['rank'] ); ?></h3>
		</div>

		<div class="mb-4 flex items-end gap-2">
			<span class="font-display text-5xl leading-none tracking-wide <?php echo $is_primary ? 'text-green-l' : 'text-white'; ?>">
				<?php echo esc_html( $plan['price'] ); ?>
			</span>
			<span class="pb-1 text-xs text-white/40"><?php echo esc_html( $plan['cadence'] ); ?></span>
		</div>

		<p class="mb-6 text-sm leading-7 text-white/45"><?php echo esc_html( $plan['desc'] ); ?></p>

		<ul class="mb-8 space-y-3">
			<?php foreach ( $plan['features'] as $feature ) : ?>
				<li class="flex items-start gap-3 text-sm text-white/65">
					<span class="mt-0.5 text-green-l"><?php echo $iga_training_icon( 'check', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php echo esc_html( $feature ); ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<a href="<?php echo esc_url( $plan['url'] ); ?>" class="mt-auto inline-flex min-h-12 items-center justify-center gap-2 rounded-full px-6 py-3 text-xs font-bold uppercase tracking-[0.12em] transition <?php echo $is_primary ? 'bg-green text-white hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]' : 'border border-white/15 text-white hover:border-white/30 hover:bg-white/5'; ?>">
			<?php echo esc_html( $plan['cta'] ); ?>
			<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	</article>
	<?php
};

$iga_training_block_id = 'iga-training-' . wp_unique_id();

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?> id="<?php echo esc_attr( $iga_training_block_id ); ?>">
	<!-- Hero -->
	<section class="relative flex h-[90vh] min-h-145 items-center overflow-hidden">
		<img
			src="<?php echo esc_url( $iga_training_hero['image'] ); ?>"
			alt="The Forge — Iron Gorilla Army training facility"
			class="absolute inset-0 h-full w-full object-cover object-center"
			fetchpriority="high"
		>
		<div class="absolute inset-0 bg-gradient-to-r from-ink from-[35%] via-ink/80 to-ink/20"></div>
		<div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-transparent to-transparent"></div>

		<div class="relative z-10 mx-auto w-full max-w-[1440px] px-[clamp(24px,6vw,120px)]">
			<div class="max-w-2xl">
				<div class="mb-6 flex items-center gap-3">
					<span class="h-px w-10 bg-green"></span>
					<span class="text-xs font-bold uppercase tracking-[0.2em] text-green-l"><?php echo esc_html( $iga_training_hero['eyebrow'] ); ?></span>
				</div>

				<h1 class="font-display text-5xl uppercase leading-[0.92] tracking-[0.03em] text-white sm:text-6xl lg:text-7xl xl:text-[5.5rem]">
					<?php echo esc_html( $iga_training_hero['title_1'] ); ?><br>
					<span class="text-green-l"><?php echo esc_html( $iga_training_hero['accent'] ); ?></span><br>
					<?php echo esc_html( $iga_training_hero['title_2'] ); ?>
				</h1>

				<p class="mt-6 max-w-md text-base leading-7 text-white/55">
					<?php echo esc_html( $iga_training_hero['subtitle'] ); ?>
				</p>

				<div class="mt-8 flex flex-wrap items-center gap-3">
					<a href="<?php echo esc_url( $iga_training_urls['book'] ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-7 py-3 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)] sm:px-9 sm:py-4">
						<?php echo $iga_training_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Book Free Assessment
					</a>
					<a href="#pricing" data-training-pricing-tab="monthly" class="inline-flex min-h-12 items-center gap-2 px-4 py-3 text-sm font-semibold text-white/65 transition hover:text-white">
						View Membership Plans
						<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>

				<p class="mt-7 flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-white/30">
					<span class="text-green-l"><?php echo $iga_training_icon( 'location', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php echo esc_html( $iga_training_hero['location'] ); ?>
				</p>
			</div>
		</div>
	</section>

	<!-- Three pillars -->
	<section class="px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1280px]">
			<?php
			$iga_training_section_header(
				'Why The Forge',
				'Built on Three Pillars',
				'Iron Gorilla is not a commercial gym. It is a systematic approach to becoming more — in every area of life.'
			);
			?>

			<div class="grid grid-cols-1 gap-5 min-[601px]:grid-cols-2 min-[1101px]:grid-cols-3">
				<?php foreach ( $iga_training_pillars as $pillar ) : ?>
					<article class="group flex gap-5 rounded-2xl border border-line bg-s1 p-6 transition duration-300 hover:-translate-y-1 hover:border-green/50 min-[601px]:block min-[601px]:p-8">
						<div class="flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-xl border border-green/40 bg-green/15 text-green-l min-[601px]:mb-5">
							<?php echo $iga_training_icon( $pillar['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div>
							<h3 class="font-display text-3xl uppercase tracking-wide text-white"><?php echo esc_html( $pillar['title'] ); ?></h3>
							<p class="mt-3 text-sm leading-7 text-white/45"><?php echo esc_html( $pillar['desc'] ); ?></p>
							<ul class="mt-5 space-y-2.5">
								<?php foreach ( $pillar['items'] as $item ) : ?>
									<li class="flex items-center gap-2 text-sm text-white/65">
										<span class="text-green-l"><?php echo $iga_training_icon( 'chevron', 'h-3 w-3' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
										<?php echo esc_html( $item ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Training tracks -->
	<section class="border-y border-line bg-s1">
		<div class="px-4.5 pb-12 pt-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:pt-24">
			<?php
			$iga_training_section_header(
				'The Forge',
				'Training Tracks',
				'Three ways to train. Same standard across all of them — real coaching, real accountability, real results.'
			);
			?>
		</div>

		<?php foreach ( $iga_training_tracks as $track ) : ?>
			<article class="grid border-t border-line min-[769px]:min-h-105 min-[769px]:grid-cols-2">
				<div class="relative min-h-60 overflow-hidden <?php echo esc_attr( $track['visual'] ); ?> <?php echo $track['reverse'] ? 'min-[769px]:order-2' : ''; ?>">
					<div class="absolute inset-0 flex items-center justify-center text-green-l/20">
						<?php echo $iga_training_icon( $track['icon'], 'h-24 w-24' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="absolute inset-0 bg-gradient-to-r from-transparent to-ink/40"></div>
					<span class="absolute bottom-4 right-6 font-display text-7xl leading-none text-white/[0.04]"><?php echo esc_html( $track['number'] ); ?></span>
				</div>

				<div class="flex flex-col justify-center px-7 py-12 min-[769px]:px-14 min-[769px]:py-14 <?php echo $track['reverse'] ? 'min-[769px]:order-1' : ''; ?>">
					<span class="font-display text-sm tracking-[0.2em] text-white/10"><?php echo esc_html( $track['number'] ); ?> / <?php echo esc_html( str_pad( (string) count( $iga_training_tracks ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="mt-1 text-[10px] font-bold uppercase tracking-[0.25em] text-green-l"><?php echo esc_html( $track['tier'] ); ?></span>
					<h3 class="mt-4 max-w-sm font-display text-5xl uppercase leading-[0.95] tracking-wide text-white"><?php echo esc_html( $track['title'] ); ?></h3>
					<p class="mt-5 max-w-md text-sm leading-7 text-white/45 sm:text-base"><?php echo esc_html( $track['description'] ); ?></p>

					<?php if ( $track['plan'] ) : ?>
						<a href="#pricing" data-training-pricing-tab="<?php echo esc_attr( $track['tab'] ); ?>" class="mt-6 inline-flex w-fit items-center gap-2 rounded-full border border-green/40 bg-green/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.15em] text-green-l transition hover:border-green-l">
							<?php echo $iga_training_icon( 'tag', 'h-3.5 w-3.5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php echo esc_html( $track['plan'] ); ?> ↓
						</a>
					<?php endif; ?>

					<div class="mt-7 flex flex-wrap gap-3">
						<a href="<?php echo esc_url( $track['primary_url'] ); ?>" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-green px-6 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:bg-green-l">
							<?php echo esc_html( $track['primary'] ); ?>
							<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
						<?php if ( $track['secondary'] ) : ?>
							<a href="#pricing" data-training-pricing-tab="monthly" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full border border-white/15 px-6 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:border-white/30 hover:bg-white/5">
								<?php echo esc_html( $track['secondary'] ); ?>
								<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</article>
		<?php endforeach; ?>

		<div class="flex items-center justify-center gap-4 border-t border-line bg-ink px-6 py-9">
			<span class="hidden h-px w-32 bg-line sm:block"></span>
			<div class="text-center">
				<p class="mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-white/35">Ready to choose your rank?</p>
				<a href="#pricing" data-training-pricing-tab="monthly" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-6 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:border-white/30 hover:bg-white/5">
					View All Plans ↓
				</a>
			</div>
			<span class="hidden h-px w-32 bg-line sm:block"></span>
		</div>
	</section>

	<!-- Schedule -->
	<section class="px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1280px]">
			<?php
			$iga_training_section_header(
				'Weekly Schedule',
				'Class Timetable',
				'Doors open at 6AM Monday to Saturday. All sessions are coach-led — no wandering the floor alone.'
			);
			?>

			<div class="mx-auto max-w-4xl space-y-3">
				<?php foreach ( $iga_training_schedule as $day ) : ?>
					<div class="rounded-xl border border-line bg-s2 px-5 py-5 transition hover:border-white/15 sm:flex sm:items-start sm:justify-between sm:gap-8 sm:px-7">
						<strong class="font-display text-xl uppercase tracking-wide text-green-l"><?php echo esc_html( $day['day'] ); ?></strong>
						<div class="mt-2 space-y-1 text-left sm:mt-0 sm:text-right">
							<?php foreach ( $day['classes'] as $class ) : ?>
								<p class="text-sm text-white/60"><?php echo esc_html( $class ); ?></p>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="mt-8 text-center">
				<a href="<?php echo esc_url( $iga_training_urls['book'] ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-7 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:border-white/30 hover:bg-white/5">
					Book Your Slot
					<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>
		</div>
	</section>

	<!-- Testimonials -->
	<section class="border-y border-line bg-s1 px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1280px]">
			<?php
			$iga_training_section_header(
				'What Members Say',
				'The Brotherhood Speaks',
				'Not endorsements — honest accounts from members who showed up and did the work.'
			);
			?>

			<div class="grid grid-cols-1 gap-3 min-[481px]:grid-cols-2 min-[769px]:grid-cols-1 min-[769px]:gap-4 min-[1081px]:grid-cols-3">
				<?php foreach ( $iga_training_testimonials as $testimonial ) : ?>
					<article class="flex h-full flex-col rounded-2xl border border-line bg-s2 p-7">
						<div class="mb-5 text-green-l/50"><?php echo $iga_training_icon( 'quote', 'h-8 w-8' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<blockquote class="flex-1 text-sm italic leading-7 text-white/65">&ldquo;<?php echo esc_html( $testimonial['quote'] ); ?>&rdquo;</blockquote>
						<div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-5">
							<div class="flex items-center gap-3">
								<span class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-s3 font-display text-lg text-white"><?php echo esc_html( $testimonial['initials'] ); ?></span>
								<span>
									<strong class="block text-sm text-white"><?php echo esc_html( $testimonial['name'] ); ?></strong>
									<small class="block text-[10px] uppercase tracking-[0.12em] text-white/35"><?php echo esc_html( $testimonial['location'] ); ?></small>
								</span>
							</div>
							<span class="rounded-full border border-green/40 bg-green/10 px-3 py-1 text-[9px] font-bold uppercase tracking-[0.1em] text-green-l"><?php echo esc_html( $testimonial['result'] ); ?></span>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Pricing -->
	<section id="pricing" class="scroll-mt-24 border-b border-line bg-ink px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1280px]">
			<?php
			$iga_training_section_header(
				'Membership',
				'Transparent Pricing',
				'No hidden fees. No “call for rates.” Choose the tier that matches where you are right now.'
			);
			?>

			<div class="mb-12 flex justify-center" role="tablist" aria-label="Pricing options">
				<div class="inline-flex rounded-full border border-white/10 bg-s1 p-1.5">
					<button type="button" data-training-monthly-tab data-pricing-button="monthly" class="rounded-full bg-green px-4 py-3 text-[10px] font-bold uppercase tracking-[0.1em] text-white shadow-[0_4px_18px_rgba(58,125,68,0.3)] transition min-[481px]:px-7 min-[481px]:text-xs" role="tab" aria-selected="true">
						Monthly Memberships
					</button>
					<button type="button" data-training-dropin-tab data-pricing-button="dropin" class="rounded-full px-4 py-3 text-[10px] font-bold uppercase tracking-[0.1em] text-white/40 transition hover:text-white min-[481px]:px-7 min-[481px]:text-xs" role="tab" aria-selected="false">
						Drop-In Sessions
					</button>
				</div>
			</div>

			<div data-training-monthly-panel data-pricing-panel="monthly" role="tabpanel">
				<div class="grid items-stretch grid-cols-[repeat(auto-fill,minmax(min(280px,100%),1fr))] gap-5">
					<?php foreach ( $iga_training_monthly_plans as $plan ) : ?>
						<?php $iga_training_pricing_card( $plan ); ?>
					<?php endforeach; ?>
				</div>
				<div class="mx-auto mt-8 max-w-xl rounded-2xl border border-line bg-s1 px-5 py-4 text-center text-sm leading-6 text-white/45">
					<strong class="text-white/70">Not ready to commit?</strong>
					Try a drop-in first — no obligation, just show up and train.
					<button type="button" data-training-pricing-tab="dropin" class="font-bold text-green-l">See Drop-In options →</button>
				</div>
			</div>

			<div data-training-dropin-panel data-pricing-panel="dropin" class="hidden" role="tabpanel" hidden>
				<div class="mx-auto grid max-w-3xl grid-cols-1 items-stretch gap-5 min-[481px]:grid-cols-2">
					<?php foreach ( $iga_training_dropin_plans as $plan ) : ?>
						<?php $iga_training_pricing_card( $plan ); ?>
					<?php endforeach; ?>
				</div>
				<div class="mx-auto mt-8 max-w-xl rounded-2xl border border-line bg-s1 px-5 py-4 text-center text-sm leading-6 text-white/45">
					<strong class="text-white/70">Train regularly?</strong>
					A monthly membership works out far cheaper.
					<button type="button" data-training-pricing-tab="monthly" class="font-bold text-green-l">See Monthly plans →</button>
				</div>
			</div>
		</div>
	</section>

	<!-- Coaches -->
	<section class="border-b border-line bg-s1 px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1280px]">
			<?php
			$iga_training_section_header(
				'The Coaches',
				'Meet The Team',
				'Every coach at The Forge is invested in your growth beyond the workout. They show up because they believe in the mission.'
			);
			?>

			<div class="grid grid-cols-1 gap-5 min-[601px]:grid-cols-2 min-[861px]:grid-cols-3">
				<?php foreach ( $iga_training_coaches as $index => $coach ) : ?>
					<article class="group overflow-hidden rounded-2xl border border-line bg-[#0F0F0F] transition duration-300 hover:-translate-y-1 hover:border-green/50">
						<div class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-s2 to-[#142018]">
							<span class="absolute left-3 top-3 z-20 rounded border border-green/20 bg-black/60 px-2 py-1 text-[9px] font-bold tracking-[0.2em] text-green-l">
								<?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) . ' / ' . str_pad( (string) count( $iga_training_coaches ), 2, '0', STR_PAD_LEFT ) ); ?>
							</span>

							<?php if ( ! empty( $coach['image'] ) ) : ?>
								<img src="<?php echo esc_url( $coach['image'] ); ?>" alt="Coach <?php echo esc_attr( $coach['name'] ); ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" style="object-position: <?php echo esc_attr( $coach['position'] ); ?>;" loading="lazy">
							<?php else : ?>
								<div class="absolute inset-0 flex flex-col items-center justify-center gap-3">
									<span class="flex h-20 w-20 items-center justify-center rounded-full border border-green/40 bg-green/10 font-display text-3xl tracking-wide text-green-l"><?php echo esc_html( $coach['initials'] ); ?></span>
									<span class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/15">Photo Coming Soon</span>
								</div>
							<?php endif; ?>

							<div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/10 to-transparent"></div>
							<h3 class="absolute bottom-4 left-5 z-10 font-display text-3xl uppercase tracking-wide text-white"><?php echo esc_html( $coach['name'] ); ?></h3>
						</div>
						<div class="border-t border-line p-5">
							<span class="inline-block rounded-full border border-green/40 bg-green/10 px-2.5 py-1 text-[8px] font-bold uppercase leading-4 tracking-[0.1em] text-green-l"><?php echo esc_html( $coach['role'] ); ?></span>
							<p class="mt-3 text-xs leading-6 text-white/45"><?php echo esc_html( $coach['bio'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Onboarding -->
	<section class="px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1100px]">
			<?php
			$iga_training_section_header(
				'How It Works',
				'Your Path Into The Brotherhood',
				'Three clear steps. No guesswork. No intimidation. Just show up.'
			);
			?>

			<div class="relative grid grid-cols-1 gap-10 min-[481px]:grid-cols-2 min-[1101px]:grid-cols-3">
				<div class="absolute left-[16.66%] right-[16.66%] top-[86px] hidden h-px bg-line min-[1101px]:block"></div>
				<?php foreach ( $iga_training_steps as $step ) : ?>
					<article class="relative">
						<span class="font-display text-7xl leading-none text-green/15"><?php echo esc_html( $step['number'] ); ?></span>
						<div class="relative z-10 -mt-3 mb-5 flex h-14 w-14 items-center justify-center rounded-xl border border-green/40 bg-[#102014] text-green-l">
							<?php echo $iga_training_icon( $step['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h3 class="font-display text-3xl uppercase tracking-wide text-white"><?php echo esc_html( $step['title'] ); ?></h3>
						<p class="mt-3 text-sm leading-7 text-white/45"><?php echo esc_html( $step['desc'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="border-t border-line bg-s1 px-4.5 py-20 text-center min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-3xl">
			<?php
			$iga_training_section_header(
				$iga_training_cta['eyebrow'],
				$iga_training_cta['title'],
				$iga_training_cta['subtitle']
			);
			?>

			<div class="flex flex-wrap justify-center gap-3">
				<a href="<?php echo esc_url( $iga_training_urls['book'] ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
					<?php echo $iga_training_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					Book Free Assessment
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'subject', 'operations-list', $iga_training_urls['contact'] ) ); ?>" class="inline-flex min-h-12 items-center gap-2 px-4 py-3 text-sm font-semibold text-white/60 transition hover:text-white">
					Join The Operations List
					<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>

			<p class="mt-7 flex items-center justify-center gap-2 text-sm text-white/40">
				<span class="text-green-l"><?php echo $iga_training_icon( 'location', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php echo esc_html( $iga_training_hero['location'] ); ?>
			</p>

			<div class="mt-8 border-t border-line pt-6 text-sm text-white/40">
				Questions about membership or training?
				<a href="<?php echo esc_url( $iga_training_urls['faq'] ); ?>" class="ml-1 inline-flex items-center gap-1.5 font-bold text-green-l hover:text-white">
					Browse the FAQ
					<?php echo $iga_training_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>
		</div>
	</section>
</div>

<script>
(function () {
	var root = document.getElementById(<?php echo wp_json_encode( $iga_training_block_id ); ?>);
	if ( ! root ) {
		return;
	}

	var pricingButtons = root.querySelectorAll('[data-pricing-button]');
	var pricingPanels = root.querySelectorAll('[data-pricing-panel]');
	var pricingLinks = root.querySelectorAll('[data-training-pricing-tab]');

	function setPricingTab(tab) {
		pricingButtons.forEach(function (button) {
			var active = button.getAttribute('data-pricing-button') === tab;
			button.setAttribute('aria-selected', active ? 'true' : 'false');
			button.classList.toggle('bg-green', active);
			button.classList.toggle('text-white', active);
			button.classList.toggle('shadow-[0_4px_18px_rgba(58,125,68,0.3)]', active);
			button.classList.toggle('text-white/40', !active);
		});

		pricingPanels.forEach(function (panel) {
			var active = panel.getAttribute('data-pricing-panel') === tab;
			panel.hidden = !active;
			panel.classList.toggle('hidden', !active);
		});
	}

	pricingButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			setPricingTab(button.getAttribute('data-pricing-button'));
		});
	});

	pricingLinks.forEach(function (link) {
		link.addEventListener('click', function () {
			setPricingTab(link.getAttribute('data-training-pricing-tab'));
		});
	});
})();
</script>
