<?php
/**
 * Testimonials — dashboard-editable member quotes.
 *
 * Quotes:      Dashboard → Testimonials (title = member name, details in the
 *              "Testimonial Settings" meta box, Order for sequence).
 * Header text: Appearance → Customize → Testimonials Section.
 *
 * Both fall back to the original testimonials until anything is added/changed.
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Testimonial meta fields.
 */
function iga_testimonial_fields() {
	return [
		'_iga_initials' => [
			'label' => __( 'Initials', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Shown in the round avatar, e.g. “K”. Leave empty to use the first letter of the name.', 'iga' ),
		],
		'_iga_location' => [
			'label' => __( 'Location', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Shown under the name, e.g. “Khayelitsha”.', 'iga' ),
		],
		'_iga_quote'    => [
			'label' => __( 'Quote', 'iga' ),
			'type'  => 'textarea',
			'desc'  => __( 'The testimonial itself — quotation marks are added automatically.', 'iga' ),
		],
		'_iga_result'   => [
			'label' => __( 'Result badge', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Small green pill at the bottom, e.g. “Lost 10kg · Since 2020”. Optional.', 'iga' ),
		],
	];
}

/**
 * Register the post type.
 */
function iga_register_testimonial_post_type() {
	register_post_type(
		'iga_testimonial',
		[
			'labels'        => [
				'name'          => __( 'Testimonials', 'iga' ),
				'singular_name' => __( 'Testimonial', 'iga' ),
				'add_new_item'  => __( 'Add New Testimonial', 'iga' ),
				'edit_item'     => __( 'Edit Testimonial', 'iga' ),
			],
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 24,
			'supports'      => [ 'title', 'page-attributes' ],
			'rewrite'       => false,
		]
	);
}
add_action( 'init', 'iga_register_testimonial_post_type' );

/**
 * Meta box.
 */
function iga_testimonial_meta_boxes() {
	add_meta_box(
		'iga-testimonial-settings',
		__( 'Testimonial Settings', 'iga' ),
		'iga_render_testimonial_meta_box',
		'iga_testimonial',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'iga_testimonial_meta_boxes' );

/**
 * Render the meta box.
 */
function iga_render_testimonial_meta_box( $post ) {
	wp_nonce_field( 'iga_testimonial_save', 'iga_testimonial_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';

	foreach ( iga_testimonial_fields() as $key => $field ) {
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
				'<textarea id="%1$s" name="%1$s" rows="4" class="large-text">%2$s</textarea>',
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
function iga_save_testimonial( $post_id ) {
	if (
		! isset( $_POST['iga_testimonial_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iga_testimonial_nonce'] ) ), 'iga_testimonial_save' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( iga_testimonial_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$value = 'textarea' === $field['type']
			? sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) )
			: sanitize_text_field( wp_unslash( $_POST[ $key ] ) );

		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_iga_testimonial', 'iga_save_testimonial' );

/**
 * Default testimonials — shown until at least one Testimonial is published.
 * Mirrors the TESTIMONIALS array from the original React component.
 */
function iga_get_default_testimonials() {
	return [
		[
			'initials' => 'K',
			'name'     => __( 'Kamva', 'iga' ),
			'location' => __( 'Fisantekraal', 'iga' ),
			'quote'    => __( 'Iron Gorilla is more than a brotherhood. The community pushes me to stay fit and always want to be better. We are an amalgam of aggression and compassion — exactly what I needed. I feel safe. I feel part of something.', 'iga' ),
			'result'   => __( 'Member since age 18', 'iga' ),
		],
		[
			'initials' => 'D',
			'name'     => __( 'Deogracias', 'iga' ),
			'location' => __( 'Observatory', 'iga' ),
			'quote'    => __( "I've lost 10kg being part of this community. What kept me going was knowing everyone here is on their own journey of self-betterment. It's not about the weight — it's about the journey everyone is on.", 'iga' ),
			'result'   => __( 'Lost 10kg · Since 2020', 'iga' ),
		],
		[
			'initials' => 'M',
			'name'     => __( 'Micah', 'iga' ),
			'location' => __( 'Khayelitsha', 'iga' ),
			'quote'    => __( "I sometimes feel misunderstood. But Iron Gorilla has challenged me — not just physically in the boxing classes, but mentally too. That's the difference that keeps me coming back.", 'iga' ),
			'result'   => __( 'Physically & Mentally Challenged', 'iga' ),
		],
	];
}

/**
 * Get testimonials: published posts, else defaults.
 */
function iga_get_testimonials() {
	$posts = get_posts(
		[
			'post_type'      => 'iga_testimonial',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		]
	);

	$testimonials = [];

	foreach ( $posts as $post ) {
		$initials = trim( (string) get_post_meta( $post->ID, '_iga_initials', true ) );
		if ( '' === $initials ) {
			$initials = function_exists( 'mb_substr' )
				? mb_strtoupper( mb_substr( get_the_title( $post ), 0, 1 ) )
				: strtoupper( substr( get_the_title( $post ), 0, 1 ) );
		}

		$testimonials[] = [
			'initials' => $initials,
			'name'     => get_the_title( $post ),
			'location' => get_post_meta( $post->ID, '_iga_location', true ),
			'quote'    => get_post_meta( $post->ID, '_iga_quote', true ),
			'result'   => get_post_meta( $post->ID, '_iga_result', true ),
		];
	}

	if ( empty( $testimonials ) ) {
		$testimonials = iga_get_default_testimonials();
	}

	return apply_filters( 'iga_testimonials', $testimonials );
}

/**
 * Header text: Customizer settings with original copy as defaults.
 */
function iga_testimonials_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'iga_testimonials',
		[
			'title'       => __( 'Testimonials Section', 'iga' ),
			'description' => __( 'The "Brotherhood Speaks" header. The testimonials themselves are managed under Dashboard → Testimonials.', 'iga' ),
			'priority'    => 34,
		]
	);

	$fields = [
		'iga_testimonials_eyebrow'  => [
			'label'   => __( 'Eyebrow', 'iga' ),
			'type'    => 'text',
			'default' => __( 'What Members Say', 'iga' ),
		],
		'iga_testimonials_title'    => [
			'label'   => __( 'Heading', 'iga' ),
			'type'    => 'text',
			'default' => __( 'The Brotherhood Speaks', 'iga' ),
		],
		'iga_testimonials_subtitle' => [
			'label'   => __( 'Subtitle', 'iga' ),
			'type'    => 'textarea',
			'default' => __( 'Not endorsements — honest accounts from members who showed up and did the work.', 'iga' ),
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
				'section' => 'iga_testimonials',
				'type'    => $field['type'],
			]
		);
	}
}
add_action( 'customize_register', 'iga_testimonials_customize_register' );

/**
 * Get the Testimonials section header args (ready for the section-header part).
 */
function iga_get_testimonials_header() {
	return apply_filters(
		'iga_testimonials_header',
		[
			'eyebrow'  => get_theme_mod( 'iga_testimonials_eyebrow', __( 'What Members Say', 'iga' ) ),
			'title'    => get_theme_mod( 'iga_testimonials_title', __( 'The Brotherhood Speaks', 'iga' ) ),
			'subtitle' => get_theme_mod( 'iga_testimonials_subtitle', __( 'Not endorsements — honest accounts from members who showed up and did the work.', 'iga' ) ),
		]
	);
}
