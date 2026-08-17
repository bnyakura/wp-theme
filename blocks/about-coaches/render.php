<?php
/**
 * About — Coaches block — render template.
 *
 * Expected image locations inside the active theme:
 *   /assets/images/coaches/coach-rhema.jpg
 *   /assets/images/coaches/coach-othniel.jpg
 *   /assets/images/coaches/coach-bongi.jpg
 *
 * @package Iron_Gorilla
 */

$iga_theme_uri = get_stylesheet_directory_uri();

$iga_about_media = apply_filters(
	'iga_about_media',
	array(
		'coach_rhema'   => $iga_theme_uri . '/assets/images/coaches/coach-rhema.jpg',
		'coach_othniel' => $iga_theme_uri . '/assets/images/coaches/coach-othniel.jpg',
		'coach_bongi'   => $iga_theme_uri . '/assets/images/coaches/coach-bongi.jpg',
	)
);

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
			'image'    => $iga_about_image_url( isset( $coach['image'] ) ? $coach['image'] : '' ),
			'position' => ! empty( $coach['position'] ) ? $coach['position'] : 'center center',
		);
	}
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about-coaches overflow-hidden bg-s1 font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

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
</div>
