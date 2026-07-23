<?php
/**
 * Forge section — dashboard-editable "Three Pillars" content.
 *
 * Pillars:       Dashboard → Forge Pillars (title = pillar name, icon + body
 *                in the "Pillar Settings" meta box, Order for sequence).
 * Header text:   Appearance → Customize → Forge Section (eyebrow/title/subtitle).
 *
 * Both fall back to the original copy until anything is added/changed.
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pillar meta fields.
 */
function iga_forge_pillar_fields() {
	return [
		'_iga_icon' => [
			'label' => __( 'Icon', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Font Awesome class, e.g. fa-dumbbell, fa-brain, fa-users.', 'iga' ),
		],
		'_iga_body' => [
			'label' => __( 'Body copy', 'iga' ),
			'type'  => 'textarea',
			'desc'  => __( 'Paragraph under the pillar name.', 'iga' ),
		],
	];
}

/**
 * Register the post type.
 */
function iga_register_forge_pillar_post_type() {
	register_post_type(
		'iga_forge_pillar',
		[
			'labels'        => [
				'name'          => __( 'Forge Pillars', 'iga' ),
				'singular_name' => __( 'Forge Pillar', 'iga' ),
				'add_new_item'  => __( 'Add New Pillar', 'iga' ),
				'edit_item'     => __( 'Edit Pillar', 'iga' ),
			],
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_icon'     => 'dashicons-awards',
			'menu_position' => 22,
			'supports'      => [ 'title', 'page-attributes' ],
			'rewrite'       => false,
		]
	);
}
add_action( 'init', 'iga_register_forge_pillar_post_type' );

/**
 * Meta box.
 */
function iga_forge_pillar_meta_boxes() {
	add_meta_box(
		'iga-forge-pillar-settings',
		__( 'Pillar Settings', 'iga' ),
		'iga_render_forge_pillar_meta_box',
		'iga_forge_pillar',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'iga_forge_pillar_meta_boxes' );

/**
 * Render the meta box.
 */
function iga_render_forge_pillar_meta_box( $post ) {
	wp_nonce_field( 'iga_forge_pillar_save', 'iga_forge_pillar_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';

	foreach ( iga_forge_pillar_fields() as $key => $field ) {
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
 * Save handler.
 */
function iga_save_forge_pillar( $post_id ) {
	if (
		! isset( $_POST['iga_forge_pillar_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iga_forge_pillar_nonce'] ) ), 'iga_forge_pillar_save' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( iga_forge_pillar_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$value = 'textarea' === $field['type']
			? sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) )
			: sanitize_text_field( wp_unslash( $_POST[ $key ] ) );

		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_iga_forge_pillar', 'iga_save_forge_pillar' );

/**
 * Default pillars — shown until at least one Forge Pillar is published.
 * Mirrors the PILLARS array from the original React component.
 */
function iga_get_default_forge_pillars() {
	return [
		[
			'icon'  => 'fa-dumbbell',
			'title' => __( 'Movement', 'iga' ),
			'body'  => __( 'Strength & Conditioning, Hybrid Group Classes, Open Studio. Every session is coach-led — movements are scaled so anyone can train.', 'iga' ),
		],
		[
			'icon'  => 'fa-brain',
			'title' => __( 'Holistic Wellness', 'iga' ),
			'body'  => __( 'Physical training is one part of the equation. We integrate mental resilience, nutrition guidance, and spiritual grounding into everything.', 'iga' ),
		],
		[
			'icon'  => 'fa-users',
			'title' => __( 'Brotherhood', 'iga' ),
			'body'  => __( 'Small squads trained under professional guidance. You belong here. You are held accountable. You do not train alone.', 'iga' ),
		],
	];
}

/**
 * Get pillars: published posts, else defaults.
 */
function iga_get_forge_pillars() {
	$posts = get_posts(
		[
			'post_type'      => 'iga_forge_pillar',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		]
	);

	$pillars = [];

	foreach ( $posts as $post ) {
		$pillars[] = [
			'icon'  => get_post_meta( $post->ID, '_iga_icon', true ),
			'title' => get_the_title( $post ),
			'body'  => get_post_meta( $post->ID, '_iga_body', true ),
		];
	}

	if ( empty( $pillars ) ) {
		$pillars = iga_get_default_forge_pillars();
	}

	return apply_filters( 'iga_forge_pillars', $pillars );
}

/**
 * Header text: Customizer settings with original copy as defaults.
 */
function iga_forge_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'iga_forge',
		[
			'title'       => __( 'Forge Section', 'iga' ),
			'description' => __( 'The "Three Pillars" header on the front page. The pillar cards themselves are managed under Dashboard → Forge Pillars.', 'iga' ),
			'priority'    => 32,
		]
	);

	$fields = [
		'iga_forge_eyebrow'  => [
			'label'   => __( 'Eyebrow', 'iga' ),
			'type'    => 'text',
			'default' => __( 'What We Offer', 'iga' ),
		],
		'iga_forge_title'    => [
			'label'   => __( 'Heading', 'iga' ),
			'type'    => 'text',
			'default' => __( 'Built on Three Pillars', 'iga' ),
		],
		'iga_forge_subtitle' => [
			'label'   => __( 'Subtitle', 'iga' ),
			'type'    => 'textarea',
			'default' => __( 'Every session, every program, and every coach is built around three core pillars.', 'iga' ),
		],
	];

	foreach ( $fields as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			[
				'default'           => $field['default'],
				'sanitize_callback' => 'textarea' === $field['type'] ? 'sanitize_textarea_field' : 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			$key,
			[
				'label'   => $field['label'],
				'section' => 'iga_forge',
				'type'    => $field['type'],
			]
		);
	}
}
add_action( 'customize_register', 'iga_forge_customize_register' );

/**
 * Get the Forge section header args (ready for the section-header part).
 */
function iga_get_forge_header() {
	return apply_filters(
		'iga_forge_header',
		[
			'eyebrow'  => get_theme_mod( 'iga_forge_eyebrow', __( 'What We Offer', 'iga' ) ),
			'title'    => get_theme_mod( 'iga_forge_title', __( 'Built on Three Pillars', 'iga' ) ),
			'subtitle' => get_theme_mod( 'iga_forge_subtitle', __( 'Every session, every program, and every coach is built around three core pillars.', 'iga' ) ),
		]
	);
}
