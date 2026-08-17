<?php
/**
 * Training — Schedule block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_training_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'arrow' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow'];

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

$iga_training_urls = array(
	'book' => home_url( '/book/' ),
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

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training-schedule overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
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
</div>
