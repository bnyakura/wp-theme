<?php
/**
 * Cilla Skyn Banner block — drag-and-drop focal point picker assets.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'cilla_skyn_banner_enqueue_focal_point_editor_assets' ) ) {
	/**
	 * Loads the small block-editor-only script/style that overlays a
	 * draggable crosshair on the Background Image (Desktop) preview inside
	 * the Cilla Skyn Banner block's settings form, driving the block's own
	 * "image_focal_x"/"image_focal_y" ACF range fields (see
	 * blocks/cilla-skyn-banner/focal-point-editor.js for how). Front-end
	 * rendering (blocks/cilla-skyn-banner/render.php) only ever reads those
	 * two field values -- this is purely an editing convenience, harmless
	 * no-op on any screen/block that doesn't have this field group.
	 *
	 * @return void
	 */
	function cilla_skyn_banner_enqueue_focal_point_editor_assets(): void {
		$script_path = '/blocks/cilla-skyn-banner/focal-point-editor.js';
		$style_path  = '/blocks/cilla-skyn-banner/focal-point-editor.css';

		$script_file = get_template_directory() . $script_path;
		$style_file  = get_template_directory() . $style_path;

		if ( file_exists( $script_file ) ) {
			wp_enqueue_script(
				'cilla-skyn-banner-focal-point-editor',
				get_template_directory_uri() . $script_path,
				array(),
				filemtime( $script_file ),
				true
			);
		}

		if ( file_exists( $style_file ) ) {
			wp_enqueue_style(
				'cilla-skyn-banner-focal-point-editor',
				get_template_directory_uri() . $style_path,
				array(),
				filemtime( $style_file )
			);
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'cilla_skyn_banner_enqueue_focal_point_editor_assets' );
