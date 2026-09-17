<?php
/**
 * Cilla Skyn Follow Along block — render template.
 *
 * Pulls a live Instagram feed via a shortcode (e.g. from an Instagram
 * feed plugin) instead of a manually curated tile grid.
 *
 * @package custom-theme
 */

$shortcode = get_field( 'instagram_shortcode' );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-cilla-skyn-follow-along bg-cream font-sans-cs text-cs-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="mx-auto max-w-[1400px] px-6 py-16 min-[768px]:px-10 min-[768px]:py-20">
		<?php if ( $shortcode ) : ?>
			<?php echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>
	</div>
</section>
