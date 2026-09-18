<?php
/**
 * Cilla Skyn General Information block — render template.
 *
 * A single freeform rich-text section — one full WYSIWYG field (bold/
 * italic, headings, lists, links, images, video embeds) instead of the
 * separate eyebrow/heading/paragraph-repeater/pronunciation/closing-line
 * fields this block started as under its old name, "Our Story". Lets the
 * client write and format any general-purpose copy — About page story,
 * policy text, announcements — without needing a new field for every new
 * piece of copy.
 *
 * @package custom-theme
 */

/*
 * Fetched unformatted (3rd arg `false`) and run through the same
 * `the_content` pipeline WordPress uses for post content (wpautop,
 * shortcodes, oEmbed), rather than ACF's own wysiwyg formatting, to avoid
 * double-wrapping paragraphs in <p> tags.
 */
$content_raw = get_field( 'content', false, false );
$content     = $content_raw ? apply_filters( 'the_content', $content_raw ) : '';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-general-information bg-[#FAF3E5] font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-2xl px-6 py-20 min-[768px]:px-10 min-[768px]:py-24">

		<?php if ( $content ) : ?>
			<div class="wp-theme-cilla-skyn-general-information__content">
				<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

	</div>
</section>
