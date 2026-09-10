<?php
/**
 * Cilla Skyn About Hero block — render template.
 *
 * A centered brand-statement intro for the top of the About page — eyebrow,
 * serif heading, two supporting paragraphs and a closing tagline. Mirrors
 * the "Hero Statement" copy in NewProject/Cilla Skyn Website Layout.docx's
 * About Us section (there's no matching section in
 * NewProject/cilla-skyn-homepage.html since this is an About-page block,
 * not a homepage one).
 *
 * @package custom-theme
 */

$eyebrow     = get_field( 'eyebrow' ) ?: 'About Cilla Skyn';
$heading     = get_field( 'heading' ) ?: 'Skincare with Purpose';
$intro       = get_field( 'intro' ) ?: 'Cilla Skyn™ is a modern African skincare brand creating thoughtful, sensorial formulations inspired by nature and refined by science.';
$description = get_field( 'description' ) ?: 'We believe skincare should do more than simply sit on the skin. It should feel considered, purposeful and beautifully balanced — from the ingredients chosen to the textures experienced and the rituals created around them.';
$tagline     = get_field( 'tagline' ) ?: 'Thoughtfully formulated. Purposefully layered. Inspired by nature.';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-about-hero bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-20 text-center min-[768px]:px-10 min-[768px]:py-28">

		<?php if ( $eyebrow ) : ?>
			<p class="mb-4 text-[11px] uppercase tracking-[0.22em] text-gold"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h1 class="mb-6 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $intro ) : ?>
			<p class="mb-4 leading-relaxed text-cs-ink/80"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="mb-8 leading-relaxed text-cs-ink/70"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $tagline ) : ?>
			<p class="flex items-center justify-center gap-3 text-[11px] uppercase tracking-[0.22em] text-cs-ink/50">
				<span class="h-px w-8 bg-cs-ink/40"></span> <?php echo esc_html( $tagline ); ?> <span class="h-px w-8 bg-cs-ink/40"></span>
			</p>
		<?php endif; ?>

	</div>
</section>
