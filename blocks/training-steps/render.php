<?php
/**
 * Training — Onboarding Steps block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_training_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'clipboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25H6.75A2.25 2.25 0 0 0 4.5 7.5v12a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-12a2.25 2.25 0 0 0-2.25-2.25H15M9 5.25a3 3 0 0 1 6 0M9 5.25h6m-6 8.25 2 2 4-4"/>',
		'fire'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 22.5c4.15 0 7.5-3.13 7.5-7.2 0-2.7-1.35-5.18-4.05-7.43.08 2.48-.82 3.98-2.18 4.8.08-4.2-2.02-7.57-5.02-10.17.3 3.68-3.75 6.3-3.75 11.85 0 4.5 3.35 8.15 7.5 8.15Zm0 0c-1.65 0-3-1.27-3-2.92 0-1.28.75-2.4 2.25-3.83.08 1.28.68 2.03 1.58 2.48.15-1.2.67-2.18 1.42-3.08.53 1.35.75 2.48.75 3.45 0 2.18-1.35 3.9-3 3.9Z"/>',
		'users'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Zm13.7-12.7a3 3 0 0 1 1.3 5.7m2.25 6a6 6 0 0 0-3.7-5.55"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['clipboard'];

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

$iga_training_steps = array(
	array( 'number' => '01', 'icon' => 'clipboard', 'title' => 'Enlist', 'desc' => 'Book a free assessment or drop in for your first class. No commitment. Just show up ready to work.' ),
	array( 'number' => '02', 'icon' => 'fire', 'title' => 'Enter The Forge', 'desc' => 'Learn your foundations under expert coaching. Form before intensity — always.' ),
	array( 'number' => '03', 'icon' => 'users', 'title' => 'Join The Community', 'desc' => 'Integrate into the community. Events, accountability, and people who hold the standard as high as you do.' ),
);

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

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training-steps overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
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
</div>
