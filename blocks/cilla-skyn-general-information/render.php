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

/*
 * Section background colour, chosen in the block sidebar. The ACF field
 * defaults to the brand cream (#FAF3E5), the block's original hardcoded
 * background; the PHP fallback repeats it so blocks placed before this
 * field existed (empty stored value) keep that same cream.
 */
$background_color = get_field( 'background_color' ) ?: '#FAF3E5';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-general-information font-sans-cs text-cs-ink',
		'style' => sprintf( 'background-color: %s;', esc_attr( $background_color ) ),
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
