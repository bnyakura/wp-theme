<?php
/**
 * About — Values block — render template.
 *
 * @package Iron_Gorilla
 */

/**
 * Inline SVG icons keep the block independent of icon plugins.
 */
$iga_about_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'dumbbell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'heart'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0 5.25-9 11.25-9 11.25S3 13.5 3 8.25A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 9 .25Z"/>',
		'users'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Zm13.7-12.7a3 3 0 0 1 1.3 5.7m2.25 6a6 6 0 0 0-3.7-5.55"/>',
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

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-about-values overflow-hidden bg-s1 font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Values -->
	<section class="border-y border-line bg-s1 px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[1280px]">

			<?php
			$iga_about_section_header(
				'What We Stand For',
				'Our Core Values'
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
</div>
