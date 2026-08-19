<?php
/**
 * Training — Tracks block — render template.
 *
 * @package Iron_Gorilla
 */

$iga_training_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'users'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0 17.9 17.9 0 0 1-15 0Zm13.7-12.7a3 3 0 0 1 1.3 5.7m2.25 6a6 6 0 0 0-3.7-5.55"/>',
		'shield'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4.5 6v5.25c0 4.8 3.2 8.25 7.5 9.75 4.3-1.5 7.5-4.95 7.5-9.75V6L12 3Zm-2.25 9 1.5 1.5 3.25-3.5"/>',
		'run'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 5.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Zm-3.9 5.1 2.1-2.85 2.55 2.1 2.7.45m-8.1 2.1 3.15 1.35 1.5 3.75m-4.65-5.1-2.1 3.15-3 .9m8.25-2.7-2.25 4.8-3.75 2.7"/>',
		'tag'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5v5.25L13.5 19.5a2.12 2.12 0 0 0 3 0l3-3a2.12 2.12 0 0 0 0-3L9.75 3.75H4.5a.75.75 0 0 0-.75.75Zm3.75 3a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>',
		'arrow'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
		'chevron'   => '<path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>',
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

$iga_training_urls = array(
	'book' => home_url( '/book/' ),
);

$iga_training_whatsapp_number = get_theme_mod( 'iron_gorilla_whatsapp', '' ) ?: '27790614906';
$iga_training_whatsapp_url    = 'https://wa.me/' . $iga_training_whatsapp_number . '?text=' . rawurlencode( "Hi Iron Gorilla Army, I'd like to book a Personal Coaching assessment." );

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
		'primary'     => 'Book Assessment',
		'primary_url' => $iga_training_whatsapp_url,
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

foreach ( $iga_training_tracks as &$iga_track ) {
	if ( 'Personal Coaching' === $iga_track['title'] ) {
		$iga_track['primary']     = 'Book Assessment';
		$iga_track['primary_url'] = $iga_training_whatsapp_url;
	}
}
unset( $iga_track );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-training-tracks overflow-hidden bg-s1 font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
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
						<?php $iga_is_whatsapp = false !== strpos( $track['primary_url'], 'wa.me' ); ?>
						<a href="<?php echo esc_url( $track['primary_url'] ); ?>" <?php echo $iga_is_whatsapp ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-green px-6 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:bg-green-l">
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
</div>
