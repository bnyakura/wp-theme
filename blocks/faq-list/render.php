<?php
/**
 * FAQ — Categorised List block — render template.
 *
 * @package Iron_Gorilla
 */

/**
 * Inline SVG icons keep the block independent of icon plugins.
 */
$iga_faq_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'door'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M6 21V4.5A1.5 1.5 0 0 1 7.5 3h9A1.5 1.5 0 0 1 18 4.5V21M14.25 12h.01"/>',
		'dumbbell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'medal'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'location' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 5.25-7.5 11.25-7.5 11.25S4.5 15.75 4.5 10.5a7.5 7.5 0 1 1 15 0Zm-5.25 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
		'heart'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0 5.25-9 11.25-9 11.25S3 13.5 3 8.25A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 9 .25Z"/>',
		'chevron'  => '<path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>',
	);

	$path = isset( $paths[ $name ] )
		? $paths[ $name ]
		: $paths['chevron'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

$iga_faq_categories = array(
	array(
		'category' => 'Getting Started',
		'icon'     => 'door',
		'faqs'     => array(
			array(
				'q' => 'Do I need to be fit to join?',
				'a' => 'No. Everyone who walks through our doors starts somewhere. Our coaches assess where you are and build your programme from there. The only requirement is that you show up ready to work.',
			),
			array(
				'q' => 'Can I do a Drop-In before committing?',
				'a' => 'Absolutely. We encourage it. Book a Drop-In session using the button on this page, come experience the floor and the people, and make your decision from there. No pressure.',
			),
			array(
				'q' => 'What should I bring to my first session?',
				'a' => 'Training shoes, a water bottle, and the right attitude. We have all the equipment. Arrive 15 minutes early for your first session so a coach can walk you through the facility.',
			),
		),
	),
	array(
		'category' => 'Training & Programs',
		'icon'     => 'dumbbell',
		'faqs'     => array(
			array(
				'q' => 'What does a typical session look like?',
				'a' => 'Sessions run 60 minutes. They begin with a structured warm-up, move into strength or conditioning work, and close with a cool-down and debrief with your squad. Every session has a purpose and a coach on the floor.',
			),
			array(
				'q' => 'How many times per week should I train?',
				'a' => 'For most members starting out, 3–4 sessions per week is optimal. Your coach will help you build a schedule that balances training, recovery, and lifestyle. Consistency over volume — always.',
			),
			array(
				'q' => 'Do you offer personal training?',
				'a' => 'Yes. Personal training is available through our Squads tier — 4 personalized 1-on-1 sessions per block with tailored programming and progress tracking.',
			),
		),
	),
	array(
		'category' => 'Membership & Pricing',
		'icon'     => 'medal',
		'faqs'     => array(
			array(
				'q' => 'Are there lock-in contracts?',
				'a' => 'No lock-in contracts. We believe if we do our job right, you stay because you want to — not because you have to. Month-to-month on all plans.',
			),
			array(
				'q' => 'Can I freeze or pause my membership?',
				'a' => 'Yes. Life happens. Contact us directly to discuss a membership pause. We work with our members — we are not a faceless gym chain.',
			),
		),
	),
	array(
		'category' => 'Location & Hours',
		'icon'     => 'location',
		'faqs'     => array(
			array(
				'q' => 'Where are you located?',
				'a' => 'Unit 209 Salt Circle, Kent Street, Salt River, Cape Town. Arrive 15 minutes early for your first visit and a coach will walk you through the facility.',
			),
			array(
				'q' => 'What are your operating hours?',
				'a' => 'Doors open at 6AM Monday to Saturday and close at 9PM. Sunday is a rest day — we practice what we preach.',
			),
		),
	),
	array(
		'category' => 'Culture & Faith',
		'icon'     => 'heart',
		'faqs'     => array(
			array(
				'q' => 'Is this a Christian gym? Do I have to share your beliefs?',
				'a' => 'Iron Gorilla is faith-inspired but not a church. Our values are rooted in scripture, but we welcome everyone who respects the culture of growth, discipline, and community.',
			),
			array(
				'q' => "What does 'brotherhood' actually mean here?",
				'a' => "It means you don't train alone. It means someone notices when you don't show up. It means you're held accountable — not policed. The brotherhood is real and it is earned through consistency.",
			),
		),
	),
);

$iga_categories_acf = get_field( 'categories' );
if ( is_array( $iga_categories_acf ) && ! empty( $iga_categories_acf ) ) {
	$iga_faq_categories = array();
	foreach ( $iga_categories_acf as $category ) {
		if ( empty( $category['category'] ) ) {
			continue;
		}

		$faqs = array();
		if ( ! empty( $category['faqs'] ) && is_array( $category['faqs'] ) ) {
			foreach ( $category['faqs'] as $faq ) {
				if ( empty( $faq['question'] ) ) {
					continue;
				}
				$faqs[] = array(
					'q' => $faq['question'],
					'a' => isset( $faq['answer'] ) ? $faq['answer'] : '',
				);
			}
		}

		if ( empty( $faqs ) ) {
			continue;
		}

		$iga_faq_categories[] = array(
			'category' => $category['category'],
			'icon'     => ! empty( $category['icon'] ) ? $category['icon'] : 'door',
			'faqs'     => $faqs,
		);
	}
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-faq-list overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>

	<!-- Categorised FAQs -->
	<section class="px-4.5 py-15 min-[481px]:px-6 min-[481px]:py-18 min-[1081px]:px-[5vw] min-[1081px]:py-25">
		<div class="mx-auto max-w-[860px] space-y-12">

			<?php foreach ( $iga_faq_categories as $category ) : ?>

				<section
					aria-labelledby="faq-<?php echo esc_attr( sanitize_title( $category['category'] ) ); ?>"
				>
					<div class="mb-5 flex items-center gap-3.5 border-b border-line pb-4">

						<div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-green/40 bg-green/10 text-green-l">
							<?php
							echo $iga_faq_icon(
								$category['icon'],
								'h-5 w-5'
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<h2
							id="faq-<?php echo esc_attr( sanitize_title( $category['category'] ) ); ?>"
							class="font-display text-3xl uppercase tracking-wide text-white"
						>
							<?php echo esc_html( $category['category'] ); ?>
						</h2>

					</div>

					<div class="space-y-3">

						<?php foreach ( $category['faqs'] as $faq ) : ?>

							<details class="group overflow-hidden rounded-xl border border-line bg-s2 transition duration-300 open:border-green/40">

								<summary class="flex min-h-16 cursor-pointer list-none items-center justify-between gap-5 px-6.25 py-5.5 text-left text-base font-semibold text-white transition hover:bg-white/[0.03] [&::-webkit-details-marker]:hidden">

									<span>
										<?php echo esc_html( $faq['q'] ); ?>
									</span>

									<span class="shrink-0 text-green-l transition duration-300 group-open:rotate-180">
										<?php
										echo $iga_faq_icon(
											'chevron',
											'h-4 w-4'
										); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
									</span>

								</summary>

								<div class="border-t border-white/[0.05] px-6.25 py-5">
									<p class="text-[0.95rem] leading-7 text-white/55">
										<?php echo esc_html( $faq['a'] ); ?>
									</p>
								</div>

							</details>

						<?php endforeach; ?>

					</div>

				</section>

			<?php endforeach; ?>

		</div>
	</section>
</div>
