<?php
/**
 * Pre-fills ACF block fields with the theme's shipped fallback content when
 * a block instance has no saved value yet.
 *
 * This covers two gaps:
 *
 * 1. Repeater fields: ACF's own `default_value` setting does not support
 *    Repeater fields at all. Each blocks/<slug> that has repeaters gets a
 *    matching inc/block-defaults/<slug>.php returning a
 *    `field_key => default rows` map, served below whenever a block
 *    instance's repeater is still empty.
 *
 * 2. Scalar fields (text/textarea/select/etc.) on ACF blocks specifically:
 *    ACF's core acf_get_value() only falls back to $field['default_value']
 *    when the stored value is exactly `null`. For a normal post that's true
 *    when meta was never saved — but for an ACF block instance
 *    ("block_..." pseudo post ID), the block value store returns `false`
 *    for "no value", not `null`, so that native fallback silently never
 *    fires and the field's own default_value (already set correctly in
 *    every acf-json/*.json file) never reaches the editor form or the
 *    front end. The filter below re-applies default_value ourselves for
 *    block contexts to work around that.
 *
 * @package custom-theme
 */

if ( ! function_exists( 'custom_theme_block_field_defaults' ) ) {
	/**
	 * Collect the field-key => default-value maps from every file in
	 * inc/block-defaults/.
	 *
	 * @return array<string, mixed>
	 */
	function custom_theme_block_field_defaults(): array {
		static $defaults = null;

		if ( null !== $defaults ) {
			return $defaults;
		}

		$defaults = array();
		$files    = glob( get_template_directory() . '/inc/block-defaults/*.php' );

		foreach ( (array) $files as $file ) {
			$block_defaults = include $file;

			if ( is_array( $block_defaults ) ) {
				$defaults = array_merge( $defaults, $block_defaults );
			}
		}

		return $defaults;
	}
}

if ( ! function_exists( 'custom_theme_remap_repeater_row_keys' ) ) {
	/**
	 * Re-key default Repeater rows from `sub_field_name => value` (what the
	 * inc/block-defaults/*.php files use, for readability) to
	 * `sub_field_key => value` (what ACF's Repeater field actually expects
	 * internally: both the admin/block-editor row renderer,
	 * ACF_Repeater_Table::render(), and format_value() — used by every
	 * front-end get_field() call — look up each cell by sub-field key, only
	 * converting to name-based keys as their own final output step).
	 * Recurses into nested Repeater sub-fields (e.g. FAQ categories→faqs).
	 *
	 * @param array<int, array<string, mixed>> $rows       Rows keyed by sub-field name.
	 * @param array<int, array<string, mixed>> $sub_fields The field's sub_fields definitions.
	 *
	 * @return array<int, array<string, mixed>> Rows keyed by sub-field key.
	 */
	function custom_theme_remap_repeater_row_keys( array $rows, array $sub_fields ): array {
		$by_name = array();

		foreach ( $sub_fields as $sub_field ) {
			$by_name[ $sub_field['name'] ] = $sub_field;
		}

		$remapped = array();

		foreach ( $rows as $row ) {
			$new_row = array();

			foreach ( $row as $name => $value ) {
				if ( ! isset( $by_name[ $name ] ) ) {
					continue;
				}

				$sub_field = $by_name[ $name ];

				if ( 'repeater' === $sub_field['type'] && is_array( $value ) && ! empty( $sub_field['sub_fields'] ) ) {
					$value = custom_theme_remap_repeater_row_keys( $value, $sub_field['sub_fields'] );
				}

				$new_row[ $sub_field['key'] ] = $value;
			}

			$remapped[] = $new_row;
		}

		return $remapped;
	}
}

if ( ! function_exists( 'custom_theme_block_field_default_value' ) ) {
	/**
	 * Serve default content for a block field that has not saved any value
	 * yet: our own default-rows map for Repeaters, or the field's own
	 * default_value for everything else (working around ACF's null-only
	 * fallback check not matching the `false` that block value storage
	 * returns for an unset field).
	 *
	 * @param mixed        $value   Field value.
	 * @param string|int   $post_id Post ID being loaded; ACF blocks use a
	 *                              "block_..." pseudo post ID.
	 * @param array<mixed> $field   Field settings.
	 *
	 * @return mixed
	 */
	function custom_theme_block_field_default_value( $value, $post_id, array $field ) {
		if ( ! is_string( $post_id ) || 0 !== strpos( $post_id, 'block_' ) ) {
			return $value;
		}

		if ( ! ( '' === $value || null === $value || false === $value || array() === $value ) ) {
			return $value;
		}

		$defaults = custom_theme_block_field_defaults();

		if ( isset( $defaults[ $field['key'] ] ) ) {
			$default = $defaults[ $field['key'] ];

			if ( 'repeater' === $field['type'] && is_array( $default ) && ! empty( $field['sub_fields'] ) ) {
				return custom_theme_remap_repeater_row_keys( $default, $field['sub_fields'] );
			}

			return $default;
		}

		if ( isset( $field['default_value'] ) && '' !== $field['default_value'] ) {
			return $field['default_value'];
		}

		return $value;
	}
}
add_filter( 'acf/load_value', 'custom_theme_block_field_default_value', 10, 3 );
