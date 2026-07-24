<?php
/**
 * ACF block registration.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_register_acf_blocks' ) ) {
    /**
     * Register ACF blocks from block.json files.
     *
     * @return void
     */
    function custom_theme_register_acf_blocks(): void {
        $blocks_path = get_template_directory() . '/blocks';

        if ( ! function_exists( 'register_block_type' ) || ! is_dir( $blocks_path ) ) {
            return;
        }

        $block_json_files = glob( $blocks_path . '/*/block.json' );

        if ( empty( $block_json_files ) ) {
            return;
        }

        foreach ( $block_json_files as $block_json_file ) {
            // Use core WP register_block_type with dirname()
            register_block_type( dirname( $block_json_file ) );
        }
    }
}
add_action( 'init', 'custom_theme_register_acf_blocks' );