<?php
/**
 * Cilla Skyn Our Story block — render template.
 *
 * A narrow-column founder-story section for the About page — eyebrow,
 * serif heading, one paragraph per Repeater row, a pronunciation note and
 * a closing line. Mirrors the "Our Story — A Name Rooted in Love &
 * Legacy" copy in NewProject/Cilla Skyn Website Layout.docx's About Us
 * section.
 *
 * @package custom-theme
 */

$eyebrow       = get_field( 'eyebrow' ) ?: 'Our Story';
$heading       = get_field( 'heading' ) ?: 'A Name Rooted in Love & Legacy';
$paragraphs    = get_field( 'paragraphs' );
$pronunciation = get_field( 'pronunciation' ) ?: 'CILLA SKYN™ is pronounced SILL-UH SKIN.';
$closing_line  = get_field( 'closing_line' ) ?: "A name inspired by love and legacy.\nA modern African skincare story.";

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-our-story bg-cream-dark font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-20 min-[768px]:px-10 min-[768px]:py-24">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-center text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h2 class="mb-8 text-center font-serif text-3xl leading-[1.15] min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $paragraphs ) ) : ?>
			<div class="space-y-4 leading-relaxed text-cs-ink/75">
				<?php foreach ( $paragraphs as $paragraph ) : ?>
					<?php if ( ! empty( $paragraph['paragraph'] ) ) : ?>
						<p><?php echo esc_html( $paragraph['paragraph'] ); ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $pronunciation ) : ?>
			<p class="mt-8 text-center text-sm italic text-cs-ink/60"><?php echo esc_html( $pronunciation ); ?></p>
		<?php endif; ?>

		<?php if ( $closing_line ) : ?>
			<p class="mt-6 flex flex-col items-center gap-2 text-center text-[11px] uppercase tracking-[0.22em] text-cs-ink/50">
				<span class="mb-2 h-px w-8 bg-cs-ink/40"></span>
				<?php echo nl2br( esc_html( $closing_line ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</p>
		<?php endif; ?>

	</div>
</section>
