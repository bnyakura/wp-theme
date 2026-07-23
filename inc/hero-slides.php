<?php
/**
 * Hero Slides — dashboard-editable hero slider content.
 *
 * Registers a "Hero Slides" post type (Dashboard → Hero Slides). Each post
 * is one slide:
 *   - Featured image        → slide background
 *   - Title                 → headline line 1 (white)
 *   - "Slide Text" meta box → eyebrow, headline line 2 (green), body copy
 *
 * Slides render in "Order" (menu_order) sequence; a slide with no featured
 * image is skipped. If no slides are published, the built-in defaults
 * (identical to the original React site) are used instead.
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta field definitions: meta key => config.
 */
function iga_hero_slide_fields() {
	return [
		'_iga_eyebrow' => [
			'label' => __( 'Eyebrow', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Small green label above the headline, e.g. “The Brotherhood”.', 'iga' ),
		],
		'_iga_line_2'  => [
			'label' => __( 'Headline line 2 (green)', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Line 1 comes from the post title above.', 'iga' ),
		],
		'_iga_body'    => [
			'label' => __( 'Body copy', 'iga' ),
			'type'  => 'textarea',
			'desc'  => __( 'Short paragraph under the headline. Aim for ~140 characters.', 'iga' ),
		],
	];
}

/**
 * Register the post type.
 */
function iga_register_hero_slide_post_type() {
	register_post_type(
		'iga_hero_slide',
		[
			'labels'        => [
				'name'                  => __( 'Hero Slides', 'iga' ),
				'singular_name'         => __( 'Hero Slide', 'iga' ),
				'add_new_item'          => __( 'Add New Slide', 'iga' ),
				'edit_item'             => __( 'Edit Slide', 'iga' ),
				'featured_image'        => __( 'Slide background image', 'iga' ),
				'set_featured_image'    => __( 'Set background image', 'iga' ),
				'remove_featured_image' => __( 'Remove background image', 'iga' ),
			],
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_icon'     => 'dashicons-images-alt2',
			'menu_position' => 20,
			'supports'      => [ 'title', 'thumbnail', 'page-attributes' ],
			'rewrite'       => false,
		]
	);
}
add_action( 'init', 'iga_register_hero_slide_post_type' );

/**
 * Register the "Slide Text" meta box.
 */
function iga_hero_slide_meta_boxes() {
	add_meta_box(
		'iga-hero-slide-text',
		__( 'Slide Text', 'iga' ),
		'iga_render_hero_slide_meta_box',
		'iga_hero_slide',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'iga_hero_slide_meta_boxes' );

/**
 * Render the meta box.
 */
function iga_render_hero_slide_meta_box( $post ) {
	wp_nonce_field( 'iga_hero_slide_save', 'iga_hero_slide_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';

	foreach ( iga_hero_slide_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );

		echo '<tr>';
		printf(
			'<th scope="row"><label for="%1$s">%2$s</label></th>',
			esc_attr( $key ),
			esc_html( $field['label'] )
		);
		echo '<td>';

		if ( 'textarea' === $field['type'] ) {
			printf(
				'<textarea id="%1$s" name="%1$s" rows="3" class="large-text">%2$s</textarea>',
				esc_attr( $key ),
				esc_textarea( $value )
			);
		} else {
			printf(
				'<input type="text" id="%1$s" name="%1$s" value="%2$s" class="large-text" />',
				esc_attr( $key ),
				esc_attr( $value )
			);
		}

		printf( '<p class="description">%s</p>', esc_html( $field['desc'] ) );
		echo '</td></tr>';
	}

	echo '</tbody></table>';
}

/**
 * Save the meta box fields.
 */
function iga_save_hero_slide( $post_id ) {
	if (
		! isset( $_POST['iga_hero_slide_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iga_hero_slide_nonce'] ) ), 'iga_hero_slide_save' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( iga_hero_slide_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$raw   = wp_unslash( $_POST[ $key ] );
		$value = 'textarea' === $field['type']
			? sanitize_textarea_field( $raw )
			: sanitize_text_field( $raw );

		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_iga_hero_slide', 'iga_save_hero_slide' );

/**
 * Default slides — shown until at least one Hero Slide is published.
 * Mirrors the SLIDES array from the original React component.
 */
function iga_get_default_hero_slides() {
	return [
		[
			'image'   => get_theme_file_uri( 'assets/img/cover_1.jpg' ),
			'eyebrow' => __( 'The Brotherhood', 'iga' ),
			'line_1'  => __( 'IRON GORILLA', 'iga' ),
			'line_2'  => __( 'ARMY', 'iga' ),
			'body'    => __( "Cape Town's most serious training community is enlisting. Built around iron, faith, and the belief that strength is forged — not born.", 'iga' ),
		],
		[
			'image'   => get_theme_file_uri( 'assets/img/forge-gym.png' ),
			'eyebrow' => __( 'The Forge', 'iga' ),
			'line_1'  => __( 'STRENGTH', 'iga' ),
			'line_2'  => __( 'FORGED DAILY', 'iga' ),
			'body'    => __( 'Open access training, hybrid group classes, and squads led by professional coaches. Walk in soft. Walk out steel.', 'iga' ),
		],
		[
			'image'   => get_theme_file_uri( 'assets/img/cover_3.jpg' ),
			'eyebrow' => __( 'The Standard', 'iga' ),
			'line_1'  => __( 'DISCIPLINE', 'iga' ),
			'line_2'  => __( 'OVER MOOD', 'iga' ),
			'body'    => __( "We don't chase motivation. We build standards. Every rep, every class, every member held to the same line.", 'iga' ),
		],
	];
}

/**
 * Get hero slides for the template: published Hero Slide posts, else defaults.
 *
 * @return array[] Each item has: image, eyebrow, line_1, line_2, body.
 */
function iga_get_hero_slides() {
	$posts = get_posts(
		[
			'post_type'      => 'iga_hero_slide',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		]
	);

	$slides = [];

	foreach ( $posts as $post ) {
		$image = get_the_post_thumbnail_url( $post->ID, 'full' );

		if ( ! $image ) {
			continue; // A slide without a background image is skipped.
		}

		$slides[] = [
			'image'   => $image,
			'eyebrow' => get_post_meta( $post->ID, '_iga_eyebrow', true ),
			'line_1'  => get_the_title( $post ),
			'line_2'  => get_post_meta( $post->ID, '_iga_line_2', true ),
			'body'    => get_post_meta( $post->ID, '_iga_body', true ),
		];
	}

	if ( empty( $slides ) ) {
		$slides = iga_get_default_hero_slides();
	}

	return apply_filters( 'iga_hero_slides', $slides );
}
