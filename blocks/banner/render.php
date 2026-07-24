<?php
/**
 * Hero Slider block render template.
 *
 * Field group:
 * - hero_banners
 *   - background_image
 *   - top_heading
 *   - main_heading
 *   - banner_description
 *   - cta_1
 *   - cta_2
 *
 * @package IGA
 *
 * @var array  $block      Block settings and attributes.
 * @var string $content    Block inner content.
 * @var bool   $is_preview Whether the block is being previewed.
 * @var int    $post_id    Current post ID.
 */

defined( 'ABSPATH' ) || exit;

$slides = get_field( 'hero_banners' );

if ( empty( $slides ) || ! is_array( $slides ) ) {
	if ( ! empty( $is_preview ) ) {
		?>
		<div class="border border-dashed border-gray-400 bg-gray-100 p-6 text-center text-gray-700">
			<?php esc_html_e( 'Add at least one hero banner slide.', 'iga' ); ?>
		</div>
		<?php
	}

	return;
}

$interval = 6000;

/**
 * Optional block-level autoplay interval field.
 *
 * Remove this section if the field does not exist.
 */
$custom_interval = get_field( 'autoplay_interval' );

if ( $custom_interval ) {
	$interval = absint( $custom_interval );
}

$interval = max( 2000, $interval );

$block_id = ! empty( $block['anchor'] )
	? sanitize_title( $block['anchor'] )
	: 'hero-' . sanitize_html_class( $block['id'] ?? uniqid() );

$block_classes = array(
	'relative',
	'h-[90vh]',
	'min-h-[560px]',
	'w-full',
	'overflow-hidden',
	'bg-[#0A0A0A]',
);

if ( ! empty( $block['className'] ) ) {
	$custom_classes = preg_split(
		'/\s+/',
		trim( $block['className'] )
	);

	foreach ( $custom_classes as $custom_class ) {
		$block_classes[] = sanitize_html_class( $custom_class );
	}
}

if ( ! empty( $block['align'] ) ) {
	$block_classes[] = 'align' . sanitize_html_class( $block['align'] );
}
?>

<section
	id="<?php echo esc_attr( $block_id ); ?>"
	data-hero-slider
	data-hero-interval="<?php echo esc_attr( (string) $interval ); ?>"
	class="<?php echo esc_attr( implode( ' ', $block_classes ) ); ?>"
>
	<?php foreach ( $slides as $index => $slide ) : ?>
		<?php
		$is_active = 0 === $index;

		$background_image   = $slide['background_image'] ?? '';
		$top_heading       = trim( (string) ( $slide['top_heading'] ?? '' ) );
		$main_heading      = trim( (string) ( $slide['main_heading'] ?? '' ) );
		$description       = trim( (string) ( $slide['banner_description'] ?? '' ) );
		$cta_1             = trim( (string) ( $slide['cta_1'] ?? '' ) );
		$cta_2             = trim( (string) ( $slide['cta_2'] ?? '' ) );

		/**
		 * Your background_image field currently returns a URL string.
		 */
		if ( is_array( $background_image ) ) {
			$background_image = $background_image['url'] ?? '';
		} elseif ( is_numeric( $background_image ) ) {
			$background_image = wp_get_attachment_image_url(
				absint( $background_image ),
				'full'
			);
		}

		if ( empty( $background_image ) ) {
			continue;
		}

		$image_alt = $top_heading ?: $main_heading;
		?>

		<div
			data-hero-slide
			aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
			class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-[1100ms] ease-[ease] [&.is-active]:pointer-events-auto [&.is-active]:opacity-100<?php echo $is_active ? ' is-active' : ''; ?>"
		>
			<img
				src="<?php echo esc_url( $background_image ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				class="absolute inset-0 h-full w-full object-cover object-top"
				decoding="async"
				<?php if ( $is_active ) : ?>
					loading="eager"
					fetchpriority="high"
				<?php else : ?>
					loading="lazy"
				<?php endif; ?>
			/>

			<div
				class="absolute inset-0 bg-[linear-gradient(to_right,rgba(10,10,10,0.93)_35%,rgba(10,10,10,0.3)_75%,rgba(10,10,10,0.1)_100%)]"
				aria-hidden="true"
			></div>

			<div class="absolute inset-0 flex items-center px-[clamp(24px,5vw,80px)] pb-20">
				<div class="max-w-[620px]">
					<?php if ( $top_heading ) : ?>
						<div class="mb-5 flex items-center justify-center gap-3 before:h-px before:max-w-10 before:flex-1 before:bg-green before:content-[''] after:h-px after:max-w-10 after:flex-1 after:bg-green after:content-['']">
							<span class="text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l">
								<?php echo esc_html( $top_heading ); ?>
							</span>
						</div>
					<?php endif; ?>

					<?php if ( $main_heading ) : ?>
						<h2 class="mb-[22px] font-display text-[clamp(3.2rem,7.5vw,6.5rem)] leading-[0.92] tracking-[2px] text-white">
							<?php echo esc_html( $main_heading ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<p class="mb-8 max-w-[440px] text-[1rem] leading-[1.8] text-white/[0.55]">
							<?php echo esc_html( $description ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $cta_1 || $cta_2 ) : ?>
						<div class="flex flex-col gap-3 min-[601px]:flex-row min-[601px]:flex-wrap">
							<?php if ( $cta_1 ) : ?>
								<a
									href="<?php echo esc_url( home_url( '/book/' ) ); ?>"
									class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-full border-0 bg-green px-[38px] py-[15px] font-sans text-[0.9rem] font-bold uppercase tracking-[1px] text-white no-underline transition-all duration-[250ms] hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)] min-[601px]:w-auto"
								>
									<i
										class="fa-regular fa-calendar-check shrink-0 text-[0.9em] leading-none"
										aria-hidden="true"
									></i>

									<?php echo esc_html( $cta_1 ); ?>
								</a>
							<?php endif; ?>

							<?php if ( $cta_2 ) : ?>
								<button
									type="button"
									data-modal-open="enlist-modal"
									class="group inline-flex cursor-pointer items-center justify-center gap-2 border-0 bg-transparent px-1 py-[15px] font-sans text-[0.9rem] font-semibold tracking-[0.3px] text-white/[0.6] transition-colors duration-200 hover:text-white min-[601px]:justify-start"
								>
									<?php echo esc_html( $cta_2 ); ?>

									<i
										class="fa-solid fa-arrow-right shrink-0 text-[0.8em] transition-transform duration-200 group-hover:translate-x-[3px]"
										aria-hidden="true"
									></i>
								</button>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<?php if ( count( $slides ) > 1 ) : ?>
		<button
			type="button"
			data-hero-prev
			aria-label="<?php esc_attr_e( 'Previous slide', 'iga' ); ?>"
			class="absolute left-[clamp(12px,3vw,32px)] top-1/2 z-[4] flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-white/[0.12] bg-[rgba(10,10,10,0.55)] text-[0.8rem] text-white backdrop-blur-[8px] transition-[background,border-color] duration-200 hover:border-[#3A7D44] hover:bg-[rgba(58,125,68,0.75)]"
		>
			<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
		</button>

		<button
			type="button"
			data-hero-next
			aria-label="<?php esc_attr_e( 'Next slide', 'iga' ); ?>"
			class="absolute right-[clamp(12px,3vw,32px)] top-1/2 z-[4] flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-white/[0.12] bg-[rgba(10,10,10,0.55)] text-[0.8rem] text-white backdrop-blur-[8px] transition-[background,border-color] duration-200 hover:border-[#3A7D44] hover:bg-[rgba(58,125,68,0.75)]"
		>
			<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
		</button>

		<div
			class="absolute inset-x-0 bottom-9 z-[4] flex justify-center gap-2"
			role="group"
			aria-label="<?php esc_attr_e( 'Choose a slide', 'iga' ); ?>"
		>
			<?php foreach ( $slides as $index => $slide ) : ?>
				<?php $is_active = 0 === $index; ?>

				<button
					type="button"
					data-hero-dot
					aria-label="<?php echo esc_attr(
						sprintf(
							/* translators: %d: slide number. */
							__( 'Slide %d', 'iga' ),
							$index + 1
						)
					); ?>"
					aria-current="<?php echo $is_active ? 'true' : 'false'; ?>"
					class="h-[7px] w-[7px] cursor-pointer rounded-[4px] border-0 bg-white/[0.2] transition-all duration-[350ms] [&.is-active]:w-6 [&.is-active]:bg-green<?php echo $is_active ? ' is-active' : ''; ?>"
				></button>
			<?php endforeach; ?>
		</div>

		<div
			data-hero-progress
			class="absolute inset-x-0 bottom-0 z-[4] h-[3px] bg-white/[0.07]"
			aria-hidden="true"
		>
			<div
				data-hero-progress-fill
				class="h-full w-0 animate-slide-progress bg-green"
			></div>
		</div>
	<?php endif; ?>
</section>