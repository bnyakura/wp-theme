<?php
/**
 * Cilla Skyn Contact Info block — render template.
 *
 * A row of contact-method cards (icon, label, value, link) — mirrors the
 * "Contact Information" list in NewProject/Cilla Skyn Website Layout.docx
 * (WhatsApp, Instagram, Email). Meant for the About or Contact page; the
 * header/footer already surface WhatsApp/Instagram via their own
 * Customizer settings — see the main theme README §8.
 *
 * @package custom-theme
 */

$cilla_skyn_contact_icon = static function ( $type ) {
	$paths = array(
		'whatsapp'  => '<path d="M17.5 6.5A7.9 7.9 0 0012 4a8 8 0 00-6.9 12l-1.1 4 4.1-1.1A8 8 0 0012 20a8 8 0 008-8c0-2.1-.9-4.1-2.5-5.5z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5.6 0 1-.4 1-1v-.9c0-.3-.2-.6-.5-.7l-1.3-.5c-.3-.1-.6 0-.8.2l-.4.5a5 5 0 01-2.6-2.6l.5-.4c.2-.2.3-.5.2-.8l-.5-1.3c-.1-.3-.4-.5-.7-.5H9c-.6 0-1 .4-1 1z"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/>',
		'email'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
		'phone'     => '<path d="M6 3h3l2 5-2.5 1.5a11 11 0 005 5L15 12l5 2v3a2 2 0 01-2 2A16 16 0 014 5a2 2 0 012-2z"/>',
	);

	$path = isset( $paths[ $type ] ) ? $paths[ $type ] : $paths['email'];

	return sprintf(
		'<svg class="h-6 w-6 shrink-0 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
		$path
	);
};

$heading = get_field( 'heading' ) ?: 'Get in Touch';
$methods = get_field( 'methods' );

/*
 * Subheading is a WYSIWYG field (bold/headings/lists/links/images/video
 * embeds/file links) — fetched unformatted (3rd arg `false`) and run
 * through the same `the_content` pipeline WordPress uses for post
 * content (wpautop, shortcodes, oEmbed), rather than ACF's own wysiwyg
 * formatting, to avoid double-wrapping paragraphs in <p> tags.
 */
$subheading_raw = get_field( 'subheading', false, false ) ?: "Questions about a product or your order? We're here to help.";
$subheading     = apply_filters( 'the_content', $subheading_raw );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-contact-info bg-cream-dark font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">

		<?php if ( $heading ) : ?>
			<h2 class="mb-2 text-center font-serif text-3xl min-[768px]:text-4xl"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( trim( wp_strip_all_tags( $subheading ) ) || false !== strpos( $subheading, '<img' ) || false !== strpos( $subheading, '<iframe' ) ) : ?>
			<div class="cilla-skyn-contact-info-subheading mx-auto mb-10 max-w-2xl text-center text-sm text-cs-ink/60">
				<?php echo $subheading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $methods ) ) : ?>
			<div class="mx-auto grid max-w-3xl grid-cols-1 gap-8 min-[640px]:grid-cols-3">
				<?php foreach ( $methods as $method ) : ?>
					<?php
					$link = trim( (string) ( $method['url'] ?? '' ) );
					$tag  = $link ? 'a' : 'div';
					?>
					<<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php if ( $link ) : ?>href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"<?php endif; ?>
						class="group flex flex-col items-center gap-3 text-center"
					>
						<?php echo $cilla_skyn_contact_icon( $method['type'] ?? 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div>
							<?php if ( ! empty( $method['label'] ) ) : ?>
								<p class="text-[11px] uppercase tracking-[0.22em] text-cs-ink/55"><?php echo esc_html( $method['label'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $method['value'] ) ) : ?>
								<p class="mt-1 text-sm font-medium transition group-hover:text-gold"><?php echo esc_html( $method['value'] ); ?></p>
							<?php endif; ?>
						</div>
					</<?php echo esc_html( $tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
