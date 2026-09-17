<?php
/**
 * Cilla Skyn Ingredients block — render template.
 *
 * A centered ingredient index rendered as an accordion list — one row per
 * ingredient, expanding to its Description, dash-bulleted Benefits, Best
 * For and Find It In copy, plus an optional link — following the layout of
 * Yearn Skin's Ingredient Library
 * (https://www.yearnskin.co.za/pages/ingredient-library), with a few
 * boutique touches of our own (numbered rows, a hairline flourish under
 * the intro). Uses the same no-JS <details>/<summary> idiom as the FAQ
 * block instead of a card grid with photography, since this design has no
 * images at all. Field shape (Description / Benefits / Best For / Find It
 * In) mirrors the "Featured Hero Ingredients" card structure in
 * "Hero Ingredients.xlsx" so that document's content drops in directly.
 *
 * Every field is optional and every part of a row degrades on its own: no
 * Description, Benefits, Best For, Find It In or link just omits that line
 * instead of rendering a broken-looking gap. A row with only a Name still
 * renders (a bare, unexpandable heading). An entirely empty block renders
 * nothing but its own padding.
 *
 * @package custom-theme
 */

// Tailwind only generates CSS for class names it finds as literal text in
// the theme's files (see src/input.css's top comment) -- a class name built
// by concatenating the field's raw value at runtime would be invisible to
// it, so this maps the select's value to a literal class name instead.
$background_classes = array(
	'cream'      => 'bg-cream',
	'cream-dark' => 'bg-cream-dark',
);
$background = $background_classes[ get_field( 'background' ) ?: 'cream' ] ?? 'bg-cream';

$eyebrow     = get_field( 'eyebrow' );
$heading     = get_field( 'heading' );
$intro       = get_field( 'intro' );
$ingredients = get_field( 'ingredients' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-ingredients ' . $background . ' font-sans-cs text-cs-ink',
	)
);

$position = 0;
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $eyebrow || $heading || $intro ) : ?>
			<div class="mb-10 text-center">
				<?php if ( $eyebrow ) : ?>
					<p class="mb-3 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<?php if ( $heading ) : ?>
					<h2 class="mb-3 font-serif text-3xl leading-[1.1] min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $intro ) : ?>
					<p class="text-sm leading-relaxed text-cs-ink/65"><?php echo esc_html( $intro ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $ingredients ) ) : ?>
					<div class="mx-auto mt-6 h-px w-10 bg-gold/40"></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $ingredients ) ) : ?>
			<div class="divide-y divide-cs-ink/10">
				<?php foreach ( $ingredients as $ingredient ) : ?>
						<?php
						$name        = trim( (string) ( $ingredient['name'] ?? '' ) );
						$description = trim( (string) ( $ingredient['description'] ?? '' ) );
						$benefits    = trim( (string) ( $ingredient['benefits'] ?? '' ) );
						$best_for    = trim( (string) ( $ingredient['best_for'] ?? '' ) );
						$find_in     = trim( (string) ( $ingredient['find_in'] ?? '' ) );
						$link_url    = trim( (string) ( $ingredient['link_url'] ?? '' ) );
						$link_label  = trim( (string) ( $ingredient['link_label'] ?? '' ) ) ?: 'Learn More';

						if ( ! $name ) {
							continue;
						}

						++$position;

						$benefit_lines = $benefits
							? array_filter( array_map( 'trim', explode( "\n", $benefits ) ) )
							: array();
						?>
						<details class="group">
							<summary class="flex cursor-pointer list-none items-center gap-4 px-5 py-4 marker:content-none">
								<span class="w-6 shrink-0 font-sans-cs text-xs tabular-nums text-gold/60"><?php echo esc_html( sprintf( '%02d', $position ) ); ?></span>
								<span class="flex-1 font-serif text-lg"><?php echo esc_html( $name ); ?></span>
								<svg class="h-4 w-4 shrink-0 text-gold transition-transform duration-300 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
									<path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</summary>
							<?php if ( $description || $benefit_lines || $best_for || $find_in || $link_url ) : ?>
								<div class="space-y-4 py-5 pr-5 pl-15 text-sm leading-relaxed text-cs-ink/70">
									<?php if ( $description ) : ?>
										<p><?php echo nl2br( esc_html( $description ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
									<?php endif; ?>
									<?php if ( $benefit_lines ) : ?>
										<div>
											<span class="mb-1.5 flex items-center gap-1.5 text-[11px] uppercase tracking-[0.14em] text-gold">
												<svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
													<path d="M4 20c8-1 12-7 12-16-9 0-14 5-14 12 0 1.5.7 3 2 4z" stroke-linecap="round" stroke-linejoin="round" />
												</svg>
												Benefits
											</span>
											<ul class="space-y-0.5">
												<?php foreach ( $benefit_lines as $line ) : ?>
													<li class="flex gap-2">
														<span class="text-gold" aria-hidden="true">–</span>
														<span><?php echo esc_html( $line ); ?></span>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>
									<?php if ( $best_for ) : ?>
										<p>
											<span class="mb-1 block text-[11px] uppercase tracking-[0.14em] text-gold">Best For</span>
											<?php echo esc_html( $best_for ); ?>
										</p>
									<?php endif; ?>
									<?php if ( $find_in ) : ?>
										<p>
											<span class="mb-1 block text-[11px] uppercase tracking-[0.14em] text-gold">Find It In</span>
											<?php echo esc_html( $find_in ); ?>
										</p>
									<?php endif; ?>
									<?php if ( $link_url ) : ?>
										<a href="<?php echo esc_url( $link_url ); ?>" class="inline-block text-[11px] uppercase tracking-[0.14em] text-gold underline underline-offset-4 transition hover:text-cs-ink">
											<?php echo esc_html( $link_label ); ?> →
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</details>
					<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
