<?php
/**
 * Training — Pillars block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_training_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'dumbbell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'heart'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0 5.25-9 11.25-9 11.25S3 13.5 3 8.25A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 9 .25Z"/>',
		'users'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Zm13.7-12.7a3 3 0 0 1 1.3 5.7m2.25 6a6 6 0 0 0-3.7-5.55"/>',
		'chevron'  => '<path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['users'];

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
		'desc'  => 'Physical transformation is the byproduct of a deeper work. We train body, mind, and spirit together.',
		'items' => array( 'Mindset Coaching', 'Nutrition Guidance', 'Recovery Protocols' ),
	),
	array(
		'icon'  => 'users',
		'title' => 'Brotherhood',
		'desc'  => 'We do not train alone. The community extends beyond the gym floor — into retreats, events, and daily accountability.',
		'items' => array( 'Community Events', 'Retreats & WODs', 'Accountability Groups' ),
	),
);

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

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training-pillars overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
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
</div>
