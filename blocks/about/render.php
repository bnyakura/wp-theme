<?php
/**
 * About block — render template.
 *
 * Reads ACF fields and falls back to the original Iron Gorilla content, so
 * the page looks complete the moment the theme is activated.
 *
 * @package Iron_Gorilla
 */

$iga_theme_uri = get_stylesheet_directory_uri();

/**
 * Set origin or brotherhood to an image URL to replace its placeholder.
 */
$iga_about_media = apply_filters(
	'iga_about_media',
	array(
		'origin'        => '',
		'brotherhood'   => '',
		'coach_rhema'   => $iga_theme_uri . '/assets/images/coaches/coach-rhema.jpg',
		'coach_othniel' => $iga_theme_uri . '/assets/images/coaches/coach-othniel.jpg',
		'coach_bongi'   => $iga_theme_uri . '/assets/images/coaches/coach-bongi.jpg',
	)
);

$iga_about_urls = array(
	'enlist' => add_query_arg( 'subject', 'enlist', home_url( '/contact/' ) ),
	'book'   => home_url( '/book/' ),
);

/**
 * Inline SVG icons keep the block independent of icon plugins.
 */
$iga_about_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'dumbbell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'heart'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0 5.25-9 11.25-9 11.25S3 13.5 3 8.25A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 9 .25Z"/>',
		'users'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Zm13.7-12.7a3 3 0 0 1 1.3 5.7m2.25 6a6 6 0 0 0-3.7-5.55"/>',
		'camera'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75 8.25 4.5h7.5l1.5 2.25h2.25A1.5 1.5 0 0 1 21 8.25v9.75a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 18V8.25a1.5 1.5 0 0 1 1.5-1.5h2.25ZM15.75 13a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>',
		'quote'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 11.25H3.75V7.5A3.75 3.75 0 0 1 7.5 3.75v7.5Zm12.75 0H16.5V7.5a3.75 3.75 0 0 1 3.75-3.75v7.5Z"/>',
		'medal'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['users'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

/**
 * Reusable section heading.
 */
$iga_about_section_header = static function ( $eyebrow, $title, $subtitle = '' ) {
	?>
	<div class="mx-auto mb-12 max-w-3xl text-center">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-green"></span>

			<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l">
				<?php echo esc_html( $eyebrow ); ?>
			</span>

			<span class="h-px w-10 bg-green"></span>
		</div>

		<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $subtitle ); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php
};

/**
 * Original Next.js page used placeholders for these two images.
 * Supply an image URL through iga_about_media to replace a placeholder.
 */
$iga_about_placeholder = static function ( $label, $ratio_class, $image = '' ) use ( $iga_about_icon ) {
	?>
	<div class="relative w-full overflow-hidden rounded-2xl <?php echo esc_attr( $ratio_class ); ?>">

		<?php if ( $image ) : ?>

			<img
				src="<?php echo esc_url( $image ); ?>"
				alt="<?php echo esc_attr( $label ); ?>"
				class="absolute inset-0 h-full w-full object-cover"
				loading="lazy"
			>

			<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

		<?php else : ?>

			<div class="absolute inset-0 flex flex-col items-center justify-center gap-3 border border-dashed border-white/15 bg-s2 text-white/20">
				<?php
				echo $iga_about_icon( 'camera', 'h-9 w-9' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>

				<span class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/35">
					<?php echo esc_html( $label ); ?>
				</span>
			</div>

		<?php endif; ?>

	</div>
	<?php
};

/**
 * Resolve an ACF image field (id) to a URL, falling back to $default.
 */
$iga_about_image_url = static function ( $image_id, $default = '' ) {
	if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
		$url = wp_get_attachment_image_url( (int) $image_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return $default;
};

$iga_values = array(
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
);

$iga_coaches = array(
	array(
		'initials' => 'PA',
		'name'     => 'Paul',
		'role'     => 'Entrepreneur & Business Coach · Co-Founder',
		'bio'      => 'With over 20 years at CFO level across corporate South Africa, Paul knows the weight that comes with leading — and the cost of neglecting the body while doing it. He brings executive experience and physical discipline together, running entrepreneurship and business classes fused with fitness. Stress management, business strategy, personal accountability — Paul trains the whole person.',
	),
	array(
		'initials' => 'RH',
		'name'     => 'Rhema',
		'role'     => 'Boxing Coach · Co-Founder',
		'bio'      => 'Rhema is an amateur boxer and certified boxing coach who built Iron Gorilla alongside Paul from the ground up. He runs the boxing programme at The Forge — teaching technique, discipline, and the mental edge that only combat sports develop. Inside these walls, Rhema is where aggression meets purpose.',
		'image'    => $iga_about_media['coach_rhema'],
		'position' => 'center 22%',
	),
	array(
		'initials' => 'OT',
		'name'     => 'Othniel',
		'role'     => 'Personal Trainer · Strength & Conditioning',
		'bio'      => 'Othniel is a certified personal trainer with over 5 years of hands-on experience in strength and conditioning. He specialises in building physical foundations — movement quality, progressive overload, and the consistency that produces lasting results. If you want to get stronger and move better, Othniel builds the programme.',
		'image'    => $iga_about_media['coach_othniel'],
		'position' => 'center 25%',
	),
	array(
		'initials' => 'BG',
		'name'     => 'Bongi',
		'role'     => 'Strength & Conditioning Specialist',
		'bio'      => "Bongi brings a biotech background and a deep specialisation in strength and conditioning. His science-first approach to training has attracted major clients who demand real results — not guesswork. Bongi's coaching is built on precision: understanding how the body adapts, and pushing it further than it thought possible.",
		'image'    => $iga_about_media['coach_bongi'],
		'position' => 'center 20%',
	),
	array(
		'initials' => 'JR',
		'name'     => 'Junior',
		'role'     => 'Calisthenics Coach',
		'bio'      => "Junior is Iron Gorilla's calisthenics coach — specialising in bodyweight movement, relative strength, and functional fitness that travels with you anywhere. His approach strips training back to its foundation: master your own body before you touch a weight. Every rep is intentional. Every session builds the base.",
	),
);

$iga_testimonials = array(
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

// ACF overrides (empty fields fall back to the defaults above).
$iga_about_hero = array(
	'eyebrow'   => get_field( 'hero_eyebrow' ),
	'title'     => get_field( 'hero_title' ),
	'subtitle'  => get_field( 'hero_subtitle' ),
);

$iga_about_hero['eyebrow']  = $iga_about_hero['eyebrow'] ?: 'Our Story';
$iga_about_hero['title']    = $iga_about_hero['title'] ?: 'Who We Are';
$iga_about_hero['subtitle'] = $iga_about_hero['subtitle'] ?: 'Iron Gorilla Army is more than a gym. It is a movement built around the belief that real strength is forged — through iron, faith, and community.';

$iga_about_story = array(
	'eyebrow'   => get_field( 'origin_eyebrow' ),
	'title'     => get_field( 'origin_title' ),
	'image'     => $iga_about_image_url( get_field( 'origin_image' ), $iga_about_media['origin'] ),
);

$iga_about_story['eyebrow'] = $iga_about_story['eyebrow'] ?: 'The Origin';
$iga_about_story['title']   = $iga_about_story['title'] ?: 'How The Army Was Born';

$iga_about_story['paragraphs'] = get_field( 'origin_paragraphs' );
if ( empty( $iga_about_story['paragraphs'] ) ) {
	$iga_about_story['paragraphs'] = array(
		"Iron Gorilla didn't start with a business plan. It started with a friendship.",
		'Paul and Rhema met as friends and colleagues — two men from different worlds who found common ground in the relentless pursuit of physical excellence. What started as early morning gym sessions slowly became something neither of them could ignore. The floor became a boardroom. The barbells became mirrors. And somewhere in the silence between sets, a vision took shape.',
		'They called it a sacred space — a place where iron genuinely sharpened iron. Not just the body, but the character, the purpose, the brotherhood. The gym sessions became a proving ground. Accountability replaced excuses. And the seed of something bigger was planted.',
		'The vision crystallised when they met Bongi at a community camp. Looking around at the men who showed up — hungry for structure, starved of direction — the need was undeniable. This was not just about training. It was about building something that could carry men forward.',
		'Othniel joined the mission. Then Junior. Each one arriving with exactly what the army needed. From Salt River, Cape Town — Iron Gorilla Army was born. Not as a gym. As a movement.',
	);
}

$iga_values_acf = get_field( 'values' );
if ( is_array( $iga_values_acf ) && ! empty( $iga_values_acf ) ) {
	$iga_values = array();
	foreach ( $iga_values_acf as $value ) {
		if ( empty( $value['title'] ) ) {
			continue;
		}
		$iga_values[] = array(
			'icon'  => ! empty( $value['icon'] ) ? $value['icon'] : 'dumbbell',
			'title' => $value['title'],
			'desc'  => isset( $value['desc'] ) ? $value['desc'] : '',
		);
	}
}

$iga_about_brotherhood = array(
	'eyebrow' => get_field( 'brotherhood_eyebrow' ),
	'title'   => get_field( 'brotherhood_title' ),
	'subtitle' => get_field( 'brotherhood_subtitle' ),
	'image'   => $iga_about_image_url( get_field( 'brotherhood_image' ), $iga_about_media['brotherhood'] ),
);

$iga_about_brotherhood['eyebrow']  = $iga_about_brotherhood['eyebrow'] ?: 'What We Stand For';
$iga_about_brotherhood['title']    = $iga_about_brotherhood['title'] ?: 'Our Core Values';
$iga_about_brotherhood['subtitle'] = $iga_about_brotherhood['subtitle'] ?: '';

$iga_coaches_acf = get_field( 'coaches' );
if ( is_array( $iga_coaches_acf ) && ! empty( $iga_coaches_acf ) ) {
	$iga_coaches = array();
	foreach ( $iga_coaches_acf as $coach ) {
		if ( empty( $coach['name'] ) ) {
			continue;
		}
		$iga_coaches[] = array(
			'initials' => ! empty( $coach['initials'] ) ? $coach['initials'] : '',
			'name'     => $coach['name'],
			'role'     => isset( $coach['role'] ) ? $coach['role'] : '',
			'bio'      => isset( $coach['bio'] ) ? $coach['bio'] : '',
			'image'    => $iga_about_image_url( $coach['image'] ),
			'position' => ! empty( $coach['position'] ) ? $coach['position'] : 'center center',
		);
	}
}

$iga_testimonials_acf = get_field( 'testimonials' );
if ( is_array( $iga_testimonials_acf ) && ! empty( $iga_testimonials_acf ) ) {
	$iga_testimonials = array();
	foreach ( $iga_testimonials_acf as $testimonial ) {
		if ( empty( $testimonial['quote'] ) ) {
			continue;
		}
		$iga_testimonials[] = array(
			'initials' => ! empty( $testimonial['initials'] ) ? $testimonial['initials'] : '',
			'name'     => isset( $testimonial['name'] ) ? $testimonial['name'] : '',
			'location' => isset( $testimonial['location'] ) ? $testimonial['location'] : '',
			'quote'    => $testimonial['quote'],
			'result'   => isset( $testimonial['result'] ) ? $testimonial['result'] : '',
		);
	}
}

$iga_about_cta = array(
	'title'     => get_field( 'cta_title' ),
	'subtitle'  => get_field( 'cta_subtitle' ),
);

$iga_about_cta['title']    = $iga_about_cta['title'] ?: 'Ready To Join The Army?';
$iga_about_cta['subtitle'] = $iga_about_cta['subtitle'] ?: 'Come see the floor. Meet the coaches. Experience the community. Your first drop-in is on us.';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Page hero -->
	<section class="border-b border-line bg-s1 px-4.5 pb-12 pt-15 text-center min-[481px]:px-[5vw] min-[481px]:pb-16 min-[481px]:pt-20">
		<div class="mx-auto max-w-3xl">

			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-green"></span>

				<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l">
					<?php echo esc_html( $iga_about_hero['eyebrow'] ); ?>
				</span>

				<span class="h-px w-10 bg-green"></span>
			</div>

			<h1 class="font-display text-5xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl">
				<?php echo esc_html( $iga_about_hero['title'] ); ?>
			</h1>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $iga_about_hero['subtitle'] ); ?>
			</p>

		</div>
	</section>

	<!-- Origin story -->
	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-3xl">

			<?php
			$iga_about_section_header(
				$iga_about_story['eyebrow'],
				$iga_about_story['title']
			);
			?>

			<div class="space-y-6 text-[1.05rem] leading-8 text-white/65">

				<?php foreach ( $iga_about_story['paragraphs'] as $paragraph ) : ?>

					<p><?php echo esc_html( $paragraph ); ?></p>

				<?php endforeach; ?>

			</div>

			<div class="mt-12">
				<?php
				$iga_about_placeholder(
					'The Forge — Gym Interior',
					'aspect-[16/7]',
					$iga_about_story['image']
				);
				?>
			</div>

		</div>
	</section>

	<!-- Values -->
	<section class="border-y border-line bg-s1 px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[1280px]">

			<?php
			$iga_about_section_header(
				$iga_about_brotherhood['eyebrow'],
				$iga_about_brotherhood['title'],
				$iga_about_brotherhood['subtitle']
			);
			?>

			<div class="grid grid-cols-1 gap-5 min-[1081px]:grid-cols-3">

				<?php foreach ( $iga_values as $value ) : ?>

					<article class="group flex gap-5 rounded-2xl border border-line bg-s2 p-6 transition duration-300 hover:-translate-y-1 hover:border-green/50 min-[601px]:block min-[601px]:p-8">

						<div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border border-green/40 bg-green/10 text-green-l min-[601px]:mb-6">
							<?php
							echo $iga_about_icon( $value['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<div>
							<h3 class="font-display text-3xl uppercase tracking-wide text-white">
								<?php echo esc_html( $value['title'] ); ?>
							</h3>

							<p class="mt-3 text-[0.95rem] leading-7 text-white/50">
								<?php echo esc_html( $value['desc'] ); ?>
							</p>
						</div>

					</article>

				<?php endforeach; ?>

			</div>

		</div>
	</section>

	<!-- Brotherhood image -->
	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[1280px]">

			<?php
			$iga_about_placeholder(
				'Brotherhood Group Shot',
				'aspect-[21/9]',
				$iga_about_brotherhood['image']
			);
			?>

		</div>
	</section>

	<!-- Coaches -->
	<section class="border-y border-line bg-s1 px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[1060px]">

			<?php
			$iga_about_section_header(
				'The Coaches',
				'Meet The Team',
				'The coaches behind the floor. Every coach at The Forge is invested in your growth beyond the workout.'
			);
			?>

			<div class="grid grid-cols-1 gap-5 min-[601px]:grid-cols-2 min-[861px]:grid-cols-3">

				<?php foreach ( $iga_coaches as $index => $coach ) : ?>

					<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-line bg-[#0F0F0F] transition duration-300 hover:-translate-y-1 hover:border-green/50">

						<div class="relative h-[220px] overflow-hidden bg-gradient-to-br from-s2 to-[#142018] min-[601px]:h-auto min-[601px]:aspect-3/4">

							<span class="absolute left-3 top-3 z-20 rounded border border-green/20 bg-black/60 px-2 py-1 text-[9px] font-bold tracking-[0.2em] text-green-l">
								<?php
								echo esc_html(
									str_pad(
										(string) ( $index + 1 ),
										2,
										'0',
										STR_PAD_LEFT
									) .
									' / ' .
									str_pad(
										(string) count( $iga_coaches ),
										2,
										'0',
										STR_PAD_LEFT
									)
								);
								?>
							</span>

							<?php if ( ! empty( $coach['image'] ) ) : ?>

								<img
									src="<?php echo esc_url( $coach['image'] ); ?>"
									alt="Coach <?php echo esc_attr( $coach['name'] ); ?>"
									class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
									style="object-position: <?php echo esc_attr( $coach['position'] ); ?>;"
									loading="lazy"
								>

							<?php else : ?>

								<div class="absolute inset-0 flex flex-col items-center justify-center gap-3">

									<span class="flex h-20 w-20 items-center justify-center rounded-full border border-green/40 bg-green/10 font-display text-3xl tracking-wide text-green-l">
										<?php echo esc_html( $coach['initials'] ); ?>
									</span>

									<span class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/15">
										Photo Coming Soon
									</span>

								</div>

							<?php endif; ?>

							<div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/10 to-transparent"></div>

							<h3 class="absolute bottom-4 left-5 z-10 font-display text-3xl uppercase tracking-wide text-white">
								<?php echo esc_html( $coach['name'] ); ?>
							</h3>

						</div>

						<div class="flex flex-1 flex-col border-t border-line p-5">

							<span class="inline-block self-start rounded-full border border-green/40 bg-green/10 px-2.5 py-1 text-[9px] font-bold uppercase leading-4 tracking-[0.1em] text-green-l">
								<?php echo esc_html( $coach['role'] ); ?>
							</span>

							<p class="mt-3 text-sm leading-7 text-white/50">
								<?php echo esc_html( $coach['bio'] ); ?>
							</p>

						</div>

					</article>

				<?php endforeach; ?>

			</div>

		</div>
	</section>

	<!-- Testimonials -->
	<section
		id="testimonials"
		class="border-b border-line bg-ink px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25"
	>
		<div class="mx-auto max-w-[1280px]">

			<?php
			$iga_about_section_header(
				'What Members Say',
				'The Brotherhood Speaks',
				'Not endorsements — honest accounts from members who showed up and did the work.'
			);
			?>

			<div class="grid grid-cols-1 gap-4 min-[481px]:grid-cols-2 min-[769px]:grid-cols-1 min-[1081px]:grid-cols-3">

				<?php foreach ( $iga_testimonials as $testimonial ) : ?>

					<article class="flex h-full flex-col rounded-2xl border border-line bg-s1 p-7">

						<div class="mb-5 text-green-l/50">
							<?php
							echo $iga_about_icon( 'quote', 'h-8 w-8' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<blockquote class="flex-1 text-sm italic leading-7 text-white/65">
							&ldquo;<?php echo esc_html( $testimonial['quote'] ); ?>&rdquo;
						</blockquote>

						<div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-5">

							<div class="flex items-center gap-3">

								<span class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-s3 font-display text-lg text-white">
									<?php echo esc_html( $testimonial['initials'] ); ?>
								</span>

								<span>
									<strong class="block text-sm text-white">
										<?php echo esc_html( $testimonial['name'] ); ?>
									</strong>

									<small class="block text-[10px] uppercase tracking-[0.12em] text-white/35">
										<?php echo esc_html( $testimonial['location'] ); ?>
									</small>
								</span>

							</div>

							<span class="rounded-full border border-green/40 bg-green/10 px-3 py-1 text-[9px] font-bold uppercase tracking-[0.1em] text-green-l">
								<?php echo esc_html( $testimonial['result'] ); ?>
							</span>

						</div>

					</article>

				<?php endforeach; ?>

			</div>

		</div>
	</section>

	<!-- Final CTA -->
	<section class="bg-s1 px-4.5 py-15 text-center min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-3xl">

			<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
				<?php echo esc_html( $iga_about_cta['title'] ); ?>
			</h2>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 min-[769px]:text-base">
				<?php echo esc_html( $iga_about_cta['subtitle'] ); ?>
			</p>

			<div class="mt-8 flex flex-wrap justify-center gap-3">

				<a
					href="<?php echo esc_url( $iga_about_urls['enlist'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]"
				>
					<?php
					echo $iga_about_icon( 'medal', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Enlist Today
				</a>

				<a
					href="<?php echo esc_url( $iga_about_urls['book'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:border-white/30 hover:bg-white/5"
				>
					<?php
					echo $iga_about_icon( 'calendar', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Book a Drop-In
				</a>

			</div>

		</div>
	</section>
</div>
