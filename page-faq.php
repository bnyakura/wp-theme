<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * Tailwind WordPress version of the Iron Gorilla Army /faq page.
 *
 * @package Iron_Gorilla
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style(
	'iga-faq-fonts',
	'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
	array(),
	null
);

get_header();

$iga_faq_urls = array(
	'contact' => home_url( '/contact/' ),
	'book'    => home_url( '/book/' ),
);

/**
 * Inline SVG icons keep the template independent of icon plugins.
 */
$iga_faq_icon = static function ( $name, $classes = 'h-6 w-6' ) {
	$paths = array(
		'door'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M6 21V4.5A1.5 1.5 0 0 1 7.5 3h9A1.5 1.5 0 0 1 18 4.5V21M14.25 12h.01"/>',
		'dumbbell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75v10.5m10.5-10.5v10.5M3.75 9v6m16.5-6v6M6.75 12h10.5M2.25 10.5h1.5v3h-1.5v-3Zm18 0h1.5v3h-1.5v-3Z"/>',
		'medal'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3 12 8.25 15.75 3M7.5 3h9M12 8.25a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm0 3.25 1.05 2.12 2.34.34-1.7 1.65.4 2.33L12 16.9l-2.09 1.1.4-2.33-1.7-1.65 2.34-.34L12 11.5Z"/>',
		'location' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 5.25-7.5 11.25-7.5 11.25S4.5 15.75 4.5 10.5a7.5 7.5 0 1 1 15 0Zm-5.25 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
		'heart'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0 5.25-9 11.25-9 11.25S3 13.5 3 8.25A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 9 .25Z"/>',
		'chevron'  => '<path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>',
		'quote'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 11.25H3.75V7.5A3.75 3.75 0 0 1 7.5 3.75v7.5Zm12.75 0H16.5V7.5a3.75 3.75 0 0 1 3.75-3.75v7.5Z"/>',
		'send'     => '<path stroke-linecap="round" stroke-linejoin="round" d="m3.75 3.75 16.5 8.25-16.5 8.25 3-8.25-3-8.25Zm3 8.25h7.5"/>',
		'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.25v3m10.5-3v3M3.75 9h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>',
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

/**
 * Reusable section heading.
 */
$iga_faq_section_header = static function (
	$eyebrow,
	$title,
	$subtitle = ''
) {
	?>
	<div class="mx-auto mb-12 max-w-3xl text-center lg:mb-14">

		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-[#3A7D44]"></span>

			<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]">
				<?php echo esc_html( $eyebrow ); ?>
			</span>

			<span class="h-px w-10 bg-[#3A7D44]"></span>
		</div>

		<h2 class="font-['Bebas_Neue'] text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">
				<?php echo esc_html( $subtitle ); ?>
			</p>
		<?php endif; ?>

	</div>
	<?php
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
?>

<main
	id="primary"
	class="overflow-hidden bg-[#0A0A0A] font-['DM_Sans'] text-[#F2F2F2] antialiased"
>
	<!-- Page hero -->
	<section class="border-b border-white/[0.07] bg-[#141414] px-6 py-20 text-center sm:px-10 lg:px-20 lg:py-24 xl:px-28">
		<div class="mx-auto max-w-3xl">

			<div class="mb-4 flex items-center justify-center gap-3">
				<span class="h-px w-10 bg-[#3A7D44]"></span>

				<span class="text-xs font-bold uppercase tracking-[0.22em] text-[#4E9E5A]">
					Questions
				</span>

				<span class="h-px w-10 bg-[#3A7D44]"></span>
			</div>

			<h1 class="font-['Bebas_Neue'] text-5xl uppercase leading-none tracking-[0.04em] text-white sm:text-6xl lg:text-7xl">
				Is This For You?
			</h1>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">
				Straight answers. No fluff. If your question isn't here, send a
				dispatch and we'll respond within 24 hours.
			</p>

		</div>
	</section>

	<!-- Categorised FAQs -->
	<section class="px-6 py-20 sm:px-10 lg:px-20 lg:py-28 xl:px-28">
		<div class="mx-auto max-w-[860px] space-y-12">

			<?php foreach ( $iga_faq_categories as $category ) : ?>

				<section
					aria-labelledby="faq-<?php echo esc_attr( sanitize_title( $category['category'] ) ); ?>"
				>
					<div class="mb-5 flex items-center gap-3.5 border-b border-white/[0.07] pb-4">

						<div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#3A7D44]/40 bg-[#3A7D44]/10 text-[#4E9E5A]">
							<?php
							echo $iga_faq_icon(
								$category['icon'],
								'h-5 w-5'
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<h2
							id="faq-<?php echo esc_attr( sanitize_title( $category['category'] ) ); ?>"
							class="font-['Bebas_Neue'] text-3xl uppercase tracking-wide text-white"
						>
							<?php echo esc_html( $category['category'] ); ?>
						</h2>

					</div>

					<div class="space-y-3">

						<?php foreach ( $category['faqs'] as $faq ) : ?>

							<details class="group overflow-hidden rounded-xl border border-white/[0.07] bg-[#1C1C1C] transition duration-300 open:border-[#3A7D44]/40">

								<summary class="flex min-h-16 cursor-pointer list-none items-center justify-between gap-5 px-5 py-4 text-left text-sm font-semibold text-white transition hover:bg-white/[0.03] sm:px-6 sm:text-base [&::-webkit-details-marker]:hidden">

									<span>
										<?php echo esc_html( $faq['q'] ); ?>
									</span>

									<span class="shrink-0 text-[#4E9E5A] transition duration-300 group-open:rotate-180">
										<?php
										echo $iga_faq_icon(
											'chevron',
											'h-4 w-4'
										); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
									</span>

								</summary>

								<div class="border-t border-white/[0.05] px-5 py-5 sm:px-6">
									<p class="text-sm leading-7 text-white/55 sm:text-[0.95rem]">
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

	<!-- Testimonials -->
	<section
		id="testimonials"
		class="border-y border-white/[0.07] bg-[#141414] px-6 py-20 sm:px-10 lg:px-20 lg:py-28 xl:px-28"
	>
		<div class="mx-auto max-w-[1280px]">

			<?php
			$iga_faq_section_header(
				'What Members Say',
				'The Brotherhood Speaks',
				'Not endorsements — honest accounts from members who showed up and did the work.'
			);
			?>

			<div class="grid gap-4 lg:grid-cols-3">

				<?php foreach ( $iga_testimonials as $testimonial ) : ?>

					<article class="flex h-full flex-col rounded-2xl border border-white/[0.07] bg-[#1C1C1C] p-7">

						<div class="mb-5 text-[#4E9E5A]/50">
							<?php
							echo $iga_faq_icon(
								'quote',
								'h-8 w-8'
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<blockquote class="flex-1 text-sm italic leading-7 text-white/65">
							“<?php echo esc_html( $testimonial['quote'] ); ?>”
						</blockquote>

						<div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-white/[0.07] pt-5">

							<div class="flex items-center gap-3">

								<span class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-[#242424] font-['Bebas_Neue'] text-lg text-white">
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

							<span class="rounded-full border border-[#3A7D44]/40 bg-[#3A7D44]/10 px-3 py-1 text-[9px] font-bold uppercase tracking-[0.1em] text-[#4E9E5A]">
								<?php echo esc_html( $testimonial['result'] ); ?>
							</span>

						</div>

					</article>

				<?php endforeach; ?>

			</div>

		</div>
	</section>

	<!-- Final CTA -->
	<section class="bg-[#141414] px-6 py-20 text-center sm:px-10 lg:px-20 lg:py-28 xl:px-28">
		<div class="mx-auto max-w-3xl">

			<h2 class="font-['Bebas_Neue'] text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl lg:text-6xl">
				Still Have Questions?
			</h2>

			<p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-white/50 sm:text-base">
				Our team is available to answer anything not covered here.
				Don't overthink it — just reach out.
			</p>

			<div class="mt-8 flex flex-wrap justify-center gap-3">

				<a
					href="<?php echo esc_url( $iga_faq_urls['contact'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#3A7D44] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:-translate-y-0.5 hover:bg-[#4E9E5A] hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]"
				>
					<?php
					echo $iga_faq_icon(
						'send',
						'h-5 w-5'
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Send a Dispatch
				</a>

				<a
					href="<?php echo esc_url( $iga_faq_urls['book'] ); ?>"
					class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition duration-300 hover:border-white/30 hover:bg-white/5"
				>
					<?php
					echo $iga_faq_icon(
						'calendar',
						'h-5 w-5'
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>

					Book a Drop-In Instead
				</a>

			</div>

		</div>
	</section>
</main>

<?php get_footer(); ?>