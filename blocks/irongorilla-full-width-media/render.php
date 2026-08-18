<?php
/**
 * IronGorilla Full Width Image / Video block — render template.
 *
 * A full-bleed media section: either an image or a self-hosted video
 * (either an autoplaying background loop or a standard click-to-play
 * clip), with an optional heading/caption overlay. Height options mirror
 * the homepage Hero block (blocks/hero) so a "Large" section reads as the
 * same scale as the hero banner elsewhere on the site.
 *
 * @package custom-theme
 */

$theme_uri = get_stylesheet_directory_uri();

$resolve_image = static function ( $attachment_id, $default = '' ) {
	if ( ! empty( $attachment_id ) && is_numeric( $attachment_id ) ) {
		$url = wp_get_attachment_image_url( (int) $attachment_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return $default;
};

$resolve_file_url = static function ( $attachment_id ) {
	if ( ! empty( $attachment_id ) && is_numeric( $attachment_id ) ) {
		$url = wp_get_attachment_url( (int) $attachment_id );
		if ( $url ) {
			return $url;
		}
	}

	return '';
};

$media_type = get_field( 'media_type' ) ?: 'image';
$media_type = in_array( $media_type, array( 'image', 'video' ), true ) ? $media_type : 'image';

$image_id  = get_field( 'image' );
$image_url = $resolve_image( $image_id, $theme_uri . '/assets/images/cover_1.jpg' );
$image_alt = is_numeric( $image_id ) ? get_post_meta( (int) $image_id, '_wp_attachment_image_alt', true ) : '';

$video_url  = $resolve_file_url( get_field( 'video' ) );
$poster_url = $resolve_image( get_field( 'poster' ) );

$has_video = 'video' === $media_type && $video_url;

$autoplay = (bool) get_field( 'autoplay' );
$heading  = get_field( 'heading' );
$caption  = get_field( 'caption' );
$overlay  = (bool) get_field( 'overlay' );

$height          = get_field( 'height' ) ?: 'large';
$allowed_heights = array( 'auto', 'large', 'full' );
$height          = in_array( $height, $allowed_heights, true ) ? $height : 'large';

$height_classes = array(
	'auto'  => 'aspect-video',
	'large' => 'min-h-[70vh] min-[1081px]:min-h-[90vh]',
	'full'  => 'min-h-screen',
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-irongorilla-full-width-media relative isolate overflow-hidden bg-ink',
	)
);
?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="relative <?php echo esc_attr( $height_classes[ $height ] ); ?>">

		<?php if ( $has_video ) : ?>
			<video
				class="absolute inset-0 h-full w-full object-cover"
				<?php echo $poster_url ? 'poster="' . esc_url( $poster_url ) . '"' : ''; ?>
				<?php echo $autoplay ? 'autoplay muted loop playsinline' : 'controls'; ?>
				preload="metadata"
			>
				<source src="<?php echo esc_url( $video_url ); ?>">
			</video>
		<?php else : ?>
			<img
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				class="absolute inset-0 h-full w-full object-cover"
				loading="lazy"
				decoding="async"
			>
		<?php endif; ?>

		<?php if ( $overlay && ( $heading || $caption ) ) : ?>
			<div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent"></div>
		<?php endif; ?>

		<?php if ( $heading || $caption ) : ?>
			<div class="relative z-10 flex h-full flex-col items-center justify-end px-6 pb-14 text-center min-[1081px]:pb-20">
				<?php if ( $heading ) : ?>
					<h2 class="font-display text-3xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>
				<?php if ( $caption ) : ?>
					<p class="mx-auto max-w-xl text-sm leading-7 text-white/70 <?php echo $heading ? 'mt-4' : ''; ?>">
						<?php echo esc_html( $caption ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
