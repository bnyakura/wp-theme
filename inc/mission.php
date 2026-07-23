<?php
/**
 * Mission section — dashboard-editable origin-story block.
 *
 * Editable under Appearance → Customize → Mission Section. Every field falls
 * back to the original copy until changed. The value pills use a simple
 * "fa-icon | Label" per line format, e.g.:
 *
 *   fa-dumbbell | Iron Discipline
 *   fa-heart    | Faith First
 *   fa-users    | Brotherhood
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field definitions for the Mission section (defaults = original copy).
 */
function iga_mission_fields() {
	return [
		'iga_mission_eyebrow'     => [
			'label'    => __( 'Eyebrow', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => __( 'The Origin', 'iga' ),
		],
		'iga_mission_heading'     => [
			'label'    => __( 'Heading', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => __( "We Built What We Couldn't Find", 'iga' ),
		],
		'iga_mission_paragraph_1' => [
			'label'    => __( 'Paragraph 1', 'iga' ),
			'type'     => 'textarea',
			'sanitize' => 'sanitize_textarea_field',
			'default'  => __( "Iron Gorilla Army wasn't built in a boardroom. It started with a group of men in Cape Town who were tired of going through the motions — training alone, winning and losing alone, with no one who truly held them to a higher standard.", 'iga' ),
		],
		'iga_mission_paragraph_2' => [
			'label'    => __( 'Paragraph 2', 'iga' ),
			'type'     => 'textarea',
			'sanitize' => 'sanitize_textarea_field',
			'default'  => __( 'We believed that iron sharpens iron — that you become who you are in the company you keep. So we built a space where physical training is the vehicle, not the destination. You come for the weights. You stay for the community.', 'iga' ),
		],
		'iga_mission_values'      => [
			'label'    => __( 'Value pills', 'iga' ),
			'type'     => 'textarea',
			'sanitize' => 'sanitize_textarea_field',
			'desc'     => __( 'One per line, formatted: fa-icon | Label. Font Awesome class list: fontawesome.com/icons', 'iga' ),
			'default'  => "fa-dumbbell | Iron Discipline\nfa-heart | Faith First\nfa-users | Brotherhood",
		],
		'iga_mission_story_label' => [
			'label'    => __( 'Button label', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => __( 'Read Our Story', 'iga' ),
		],
		'iga_mission_story_url'   => [
			'label'    => __( 'Button link', 'iga' ),
			'type'     => 'url',
			'sanitize' => 'esc_url_raw',
			'desc'     => __( 'Site path like /blog/iron-gorilla-origin-story or a full URL.', 'iga' ),
			'default'  => '/blog/iron-gorilla-origin-story',
		],
		'iga_mission_image'       => [
			'label'    => __( 'Image', 'iga' ),
			'type'     => 'image',
			'sanitize' => 'esc_url_raw',
			'default'  => '',
		],
		'iga_mission_caption'     => [
			'label'    => __( 'Image caption', 'iga' ),
			'type'     => 'text',
			'sanitize' => 'sanitize_text_field',
			'default'  => __( 'Salt River, Cape Town', 'iga' ),
		],
	];
}

/**
 * Register the Customizer section, settings, and controls.
 */
function iga_mission_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'iga_mission',
		[
			'title'       => __( 'Mission Section', 'iga' ),
			'description' => __( 'The origin-story block on the front page (eyebrow, heading, paragraphs, value pills, button, image).', 'iga' ),
			'priority'    => 31,
		]
	);

	foreach ( iga_mission_fields() as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			[
				'default'           => $field['default'],
				'sanitize_callback' => $field['sanitize'],
			]
		);

		if ( 'image' === $field['type'] ) {
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$key,
					[
						'label'       => $field['label'],
						'description' => __( 'Portrait works best (4:5 on desktop). Falls back to the bundled photo.', 'iga' ),
						'section'     => 'iga_mission',
					]
				)
			);
			continue;
		}

		$wp_customize->add_control(
			$key,
			[
				'label'       => $field['label'],
				'description' => $field['desc'] ?? '',
				'section'     => 'iga_mission',
				'type'        => $field['type'],
			]
		);
	}
}
add_action( 'customize_register', 'iga_mission_customize_register' );

/**
 * Get the normalized Mission content for the template.
 *
 * @return array{eyebrow:string,heading:string,paragraphs:string[],values:array[],story_label:string,story_href:string,image:string,image_alt:string,caption:string}
 */
function iga_get_mission() {
	$fields = iga_mission_fields();

	$mod = static function ( $key ) use ( $fields ) {
		return get_theme_mod( $key, $fields[ $key ]['default'] );
	};

	// Paragraphs: drop empties.
	$paragraphs = array_values(
		array_filter(
			[ $mod( 'iga_mission_paragraph_1' ), $mod( 'iga_mission_paragraph_2' ) ]
		)
	);

	// Value pills: "fa-icon | Label" per line; a line without "|" is label-only.
	$values = [];
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $mod( 'iga_mission_values' ) ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$values[] = [
			'icon'  => 2 === count( $parts ) ? $parts[0] : '',
			'label' => 2 === count( $parts ) ? $parts[1] : $parts[0],
		];
	}

	// Image: custom upload, else the bundled theme photo.
	$image = (string) $mod( 'iga_mission_image' );
	if ( ! $image ) {
		$image = get_theme_file_uri( 'assets/img/cover_2.jpg' );
	}

	$mission = [
		'eyebrow'     => $mod( 'iga_mission_eyebrow' ),
		'heading'     => $mod( 'iga_mission_heading' ),
		'paragraphs'  => $paragraphs,
		'values'      => $values,
		'story_label' => $mod( 'iga_mission_story_label' ),
		'story_href'  => $mod( 'iga_mission_story_url' ),
		'image'       => $image,
		'image_alt'   => __( 'Iron Gorilla Army brotherhood', 'iga' ),
		'caption'     => $mod( 'iga_mission_caption' ),
	];

	return apply_filters( 'iga_mission', $mission );
}
