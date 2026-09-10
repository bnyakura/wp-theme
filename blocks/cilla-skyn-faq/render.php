<?php
/**
 * Cilla Skyn FAQ block — render template.
 *
 * A no-JS accordion of question/answer pairs using native
 * <details>/<summary> — the same no-JS-dropdown idiom header.php already
 * uses for its search field. For the FAQs page; there's no matching
 * section in NewProject/cilla-skyn-homepage.html or the docx, since FAQs
 * weren't part of the original design brief.
 *
 * @package custom-theme
 */

$heading    = get_field( 'heading' ) ?: 'Frequently Asked Questions';
$subheading = get_field( 'subheading' ) ?: "Can't find what you're looking for? Reach out — we're happy to help.";
$faqs       = get_field( 'faqs' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-faq bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $heading ) : ?>
			<h1 class="mb-3 font-serif text-4xl leading-[1.1] min-[768px]:text-5xl"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $subheading ) : ?>
			<p class="mb-10 leading-relaxed text-cs-ink/70"><?php echo esc_html( $subheading ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $faqs ) ) : ?>
			<div class="divide-y divide-cs-ink/10 border-y border-cs-ink/10">
				<?php foreach ( $faqs as $faq ) : ?>
					<?php if ( ! empty( $faq['question'] ) ) : ?>
						<details class="group py-4">
							<summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-serif text-lg marker:content-none">
								<?php echo esc_html( $faq['question'] ); ?>
								<span class="shrink-0 text-xl text-gold transition group-open:rotate-45" aria-hidden="true">+</span>
							</summary>
							<?php if ( ! empty( $faq['answer'] ) ) : ?>
								<div class="mt-3 max-w-xl leading-relaxed text-cs-ink/70">
									<?php echo nl2br( esc_html( $faq['answer'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php endif; ?>
						</details>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
