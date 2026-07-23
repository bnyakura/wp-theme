<?php
/**
 * Stats bar — the four-column strip under the hero.
 *
 * Stats are defined below and can be overridden with the `iga_stats` filter.
 *
 * @package IGA
 */

$stats = apply_filters(
	'iga_stats',
	[
		[
			'value' => __( '120+', 'iga' ),
			'label' => __( 'Active Members', 'iga' ),
		],
		[
			'value' => __( '3 Yrs', 'iga' ),
			'label' => __( 'Iron-Tested Since 2022', 'iga' ),
		],
		[
			'value' => __( '6AM', 'iga' ),
			'label' => __( 'Doors Open Daily', 'iga' ),
		],
		[
			'value' => __( '1 Unit', 'iga' ),
			'label' => __( 'Brotherhood. No Excuses.', 'iga' ),
		],
	]
);

if ( empty( $stats ) ) {
	return;
}
?>

<section aria-label="<?php esc_attr_e( 'Community stats', 'iga' ); ?>" class="w-full border-y border-[rgba(58,125,68,0.5)] bg-[#111111] px-[5vw]">
	<div class="mx-auto grid w-full max-w-[1100px] grid-cols-1 gap-0 min-[481px]:grid-cols-2 min-[1081px]:grid-cols-4">
		<?php foreach ( $stats as $i => $stat ) : ?>
			<div class="relative flex flex-col items-center px-5 py-9 text-center <?php echo $i > 0 ? 'border-l border-[rgba(58,125,68,0.3)]' : ''; ?>">
				<span class="font-display text-[clamp(2.4rem,4.5vw,3.2rem)] leading-none tracking-[1px] text-green">
					<?php echo esc_html( $stat['value'] ); ?>
				</span>
				<span class="mt-[10px] text-[0.7rem] font-medium uppercase tracking-[2.5px] text-[#cccccc]">
					<?php echo esc_html( $stat['label'] ); ?>
				</span>
			</div>
		<?php endforeach; ?>
	</div>
</section>
