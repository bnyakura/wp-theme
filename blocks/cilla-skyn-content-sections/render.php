<?php
/**
 * Cilla Skyn Content Sections block — render template.
 *
 * A generic narrow-column policy/info page block: eyebrow, heading, intro
 * paragraph and a Repeater of titled sections — meant for pages like
 * Shipping & Delivery or Returns & Exchanges that have no design mockup of
 * their own (there's no such page in NewProject/cilla-skyn-homepage.html
 * or the docx). Ships with example Shipping & Delivery copy; duplicate
 * this block and edit its fields for Returns & Exchanges or any similar
 * page — see the block's own README.
 *
 * @package custom-theme
 */

/*
 * A local closure, not a named function — render.php is included afresh
 * for every instance of this block, so a global `function` declaration
 * here would fatal ("cannot redeclare") the moment a page uses the block
 * twice.
 */
$cilla_skyn_content_sections_paragraphs = static function ( string $body ): string {
	$paragraphs = preg_split( '/\n\s*\n/', trim( $body ) );
	$html       = '';

	foreach ( (array) $paragraphs as $paragraph ) {
		$paragraph = trim( $paragraph );

		if ( '' === $paragraph ) {
			continue;
		}

		$html .= '<p>' . nl2br( esc_html( $paragraph ) ) . '</p>';
	}

	return $html;
};

$eyebrow  = get_field( 'eyebrow' ) ?: 'Help';
$heading  = get_field( 'heading' ) ?: 'Shipping & Delivery';
$intro    = get_field( 'intro' ) ?: "Everything you need to know about how we get your Cilla Skyn order to your door.";
$sections = get_field( 'sections' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-content-sections bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h1 class="mb-6 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $intro ) : ?>
			<p class="mb-10 leading-relaxed text-cs-ink/70"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $sections ) ) : ?>
			<div class="divide-y divide-cs-ink/10">
				<?php foreach ( $sections as $section ) : ?>
					<?php if ( ! empty( $section['title'] ) || ! empty( $section['body'] ) ) : ?>
						<div class="py-6 first:pt-0 last:pb-0">
							<?php if ( ! empty( $section['title'] ) ) : ?>
								<h2 class="mb-2 font-serif text-xl"><?php echo esc_html( $section['title'] ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $section['body'] ) ) : ?>
								<div class="space-y-3 leading-relaxed text-cs-ink/70">
									<?php echo $cilla_skyn_content_sections_paragraphs( $section['body'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
