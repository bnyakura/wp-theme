<?php
/**
 * Distinction Cards — dashboard-editable "Distinction" section content.
 *
 * Registers a "Distinction Cards" post type (Dashboard → Distinction Cards).
 * Each post is one card:
 *   - Title            → card heading
 *   - Featured image   → card image (leave EMPTY to render the map card)
 *   - "Card Settings"  → tag, body copy, CTA, featured flag
 *
 * Cards render in "Order" (menu_order) sequence. If no cards are published,
 * the built-in defaults (identical to the original React site) are used.
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta field definitions.
 */
function iga_distinction_card_fields() {
	return [
		'_iga_tag'         => [
			'label' => __( 'Tag', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Small green label, e.g. “The Movement”. Leave empty to hide.', 'iga' ),
		],
		'_iga_tag_icon'    => [
			'label' => __( 'Tag icon', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Font Awesome class, e.g. fa-users, fa-dumbbell, fa-location-dot.', 'iga' ),
		],
		'_iga_body'        => [
			'label' => __( 'Body copy', 'iga' ),
			'type'  => 'textarea',
			'desc'  => __( 'Paragraph under the heading.', 'iga' ),
		],
		'_iga_cta_label'   => [
			'label' => __( 'CTA label', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Button text, e.g. “Enlist Now”. Leave empty for no button.', 'iga' ),
		],
		'_iga_cta_icon'    => [
			'label' => __( 'CTA icon', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Font Awesome class, e.g. fa-medal.', 'iga' ),
		],
		'_iga_cta_action'  => [
			'label'   => __( 'CTA action', 'iga' ),
			'type'    => 'select',
			'options' => [
				'link'           => __( 'Link to a page (uses URL below)', 'iga' ),
				'directions'     => __( 'Google Maps directions', 'iga' ),
				'whatsapp-group' => __( '“Join Community” — links to WhatsApp group', 'iga' ),
				'packages-modal' => __( 'Open “Packages” modal ¹', 'iga' ),
				'booking-modal'  => __( 'Open “Booking” modal ¹', 'iga' ),
			],
			'desc'    => __( '¹ These modals work once their template parts are converted too.', 'iga' ),
		],
		'_iga_cta_href'    => [
			'label' => __( 'CTA link URL', 'iga' ),
			'type'  => 'url',
			'desc'  => __( 'Site path like /training or a full URL. Only used for “Link to a page”.', 'iga' ),
		],
		'_iga_featured'    => [
			'label' => __( 'Featured card', 'iga' ),
			'type'  => 'checkbox',
			'desc'  => __( 'Green gradient background, green border, glow, and green CTA button.', 'iga' ),
		],
	];
}

/**
 * Register the post type.
 */
function iga_register_distinction_card_post_type() {
	register_post_type(
		'iga_dist_card',
		[
			'labels'        => [
				'name'                  => __( 'Distinction Cards', 'iga' ),
				'singular_name'         => __( 'Distinction Card', 'iga' ),
				'add_new_item'          => __( 'Add New Card', 'iga' ),
				'edit_item'             => __( 'Edit Card', 'iga' ),
				'featured_image'        => __( 'Card image', 'iga' ),
				'set_featured_image'    => __( 'Set card image', 'iga' ),
				'remove_featured_image' => __( 'Remove card image', 'iga' ),
			],
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => false,
			'menu_icon'     => 'dashicons-columns',
			'menu_position' => 21,
			'supports'      => [ 'title', 'thumbnail', 'page-attributes' ],
			'rewrite'       => false,
		]
	);
}
add_action( 'init', 'iga_register_distinction_card_post_type' );

/**
 * Meta box.
 */
function iga_distinction_card_meta_boxes() {
	add_meta_box(
		'iga-distinction-card-settings',
		__( 'Card Settings', 'iga' ),
		'iga_render_distinction_card_meta_box',
		'iga_dist_card',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'iga_distinction_card_meta_boxes' );

/**
 * Render the meta box.
 */
function iga_render_distinction_card_meta_box( $post ) {
	wp_nonce_field( 'iga_distinction_card_save', 'iga_distinction_card_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';

	foreach ( iga_distinction_card_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );

		echo '<tr>';
		printf(
			'<th scope="row"><label for="%1$s">%2$s</label></th>',
			esc_attr( $key ),
			esc_html( $field['label'] )
		);
		echo '<td>';

		switch ( $field['type'] ) {
			case 'textarea':
				printf(
					'<textarea id="%1$s" name="%1$s" rows="3" class="large-text">%2$s</textarea>',
					esc_attr( $key ),
					esc_textarea( $value )
				);
				break;

			case 'select':
				printf( '<select id="%1$s" name="%1$s">', esc_attr( $key ) );
				foreach ( $field['options'] as $option_value => $option_label ) {
					printf(
						'<option value="%1$s" %2$s>%3$s</option>',
						esc_attr( $option_value ),
						selected( $value, $option_value, false ),
						esc_html( $option_label )
					);
				}
				echo '</select>';
				break;

			case 'checkbox':
				printf(
					'<label><input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s /> %3$s</label>',
					esc_attr( $key ),
					checked( $value, '1', false ),
					esc_html( $field['desc'] )
				);
				break;

			default:
				printf(
					'<input type="text" id="%1$s" name="%1$s" value="%2$s" class="large-text" />',
					esc_attr( $key ),
					esc_attr( $value )
				);
		}

		if ( 'checkbox' !== $field['type'] && ! empty( $field['desc'] ) ) {
			printf( '<p class="description">%s</p>', esc_html( $field['desc'] ) );
		}

		echo '</td></tr>';
	}

	echo '</tbody></table>';
}

/**
 * Save handler.
 */
function iga_save_distinction_card( $post_id ) {
	if (
		! isset( $_POST['iga_distinction_card_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iga_distinction_card_nonce'] ) ), 'iga_distinction_card_save' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( iga_distinction_card_fields() as $key => $field ) {
		// Checkboxes submit nothing when unchecked — always write them.
		if ( 'checkbox' === $field['type'] ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '' );
			continue;
		}

		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$raw = wp_unslash( $_POST[ $key ] );

		switch ( $field['type'] ) {
			case 'textarea':
				$value = sanitize_textarea_field( $raw );
				break;
			case 'url':
				$value = esc_url_raw( $raw );
				break;
			case 'select':
				$value = array_key_exists( $raw, $field['options'] ) ? $raw : 'link';
				break;
			default:
				$value = sanitize_text_field( $raw );
		}

		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_iga_dist_card', 'iga_save_distinction_card' );

/**
 * Directions + map-embed URLs (single source, filterable).
 */
function iga_directions_url() {
	return apply_filters(
		'iga_directions_url',
		'https://maps.google.com/maps?q=Salt+Circle,+Kent+Street,+Salt+River,+Cape+Town,+South+Africa'
	);
}

function iga_map_embed_url() {
	return apply_filters(
		'iga_map_embed_url',
		'https://maps.google.com/maps?q=Salt+Circle,+Kent+Street,+Salt+River,+Cape+Town,+South+Africa&output=embed'
	);
}

/**
 * Default cards — shown until at least one Distinction Card is published.
 * Mirrors the CARDS array from the original React component.
 */
function iga_get_default_distinction_cards() {
	return [
		[
			'tag'        => __( 'The Movement', 'iga' ),
			'tag_icon'   => 'fa-users',
			'title'      => __( 'Iron Gorilla Army', 'iga' ),
			'body'       => __( 'We are a community built around iron and faith. The Army is the overarching culture, the standard, and the movement committed to growth and complete self-mastery.', 'iga' ),
			'image'      => get_theme_file_uri( 'assets/img/cover_2.jpg' ),
			'image_alt'  => __( 'Iron Gorilla Army community', 'iga' ),
			'cta_label'  => __( 'Enlist Now', 'iga' ),
			'cta_icon'   => 'fa-medal',
			'cta_action' => 'enlist-modal',
			'cta_href'   => '',
			'featured'   => false,
		],
		[
			'tag'        => __( 'The Facility', 'iga' ),
			'tag_icon'   => 'fa-dumbbell',
			'title'      => __( 'The Forge Gym', 'iga' ),
			'body'       => __( 'The Forge is the proving ground where the Army trains. Open access, studio classes, and coach-led sessions. This is where the work gets done.', 'iga' ),
			'image'      => get_theme_file_uri( 'assets/img/forge-gym.png' ),
			'image_alt'  => __( 'The Forge Gym', 'iga' ),
			'cta_label'  => __( 'View Training Programs', 'iga' ),
			'cta_icon'   => 'fa-dumbbell',
			'cta_action' => 'link',
			'cta_href'   => '/training',
			'featured'   => true,
		],
		[
			'tag'        => __( 'Headquarters', 'iga' ),
			'tag_icon'   => 'fa-location-dot',
			'title'      => __( 'Where To Find Us', 'iga' ),
			'body'       => __( 'Unit 209 Salt Circle, Kent Str, Salt River, Cape Town. Mon–Sat: 6AM–9PM. Sunday: Closed.', 'iga' ),
			'image'      => null,
			'image_alt'  => '',
			'cta_label'  => __( 'Get Directions', 'iga' ),
			'cta_icon'   => 'fa-map-location-dot',
			'cta_action' => 'directions',
			'cta_href'   => '',
			'featured'   => false,
		],
	];
}

/**
 * Get distinction cards: published posts, else defaults.
 */
function iga_get_distinction_cards() {
	$posts = get_posts(
		[
			'post_type'      => 'iga_dist_card',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		]
	);

	$cards = [];

	foreach ( $posts as $post ) {
		$thumb_id  = get_post_thumbnail_id( $post->ID );
		$image     = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : null;
		$image_alt = '';

		if ( $thumb_id ) {
			$image_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
			if ( ! $image_alt ) {
				$image_alt = get_the_title( $post );
			}
		}

		$cards[] = [
			'tag'        => get_post_meta( $post->ID, '_iga_tag', true ),
			'tag_icon'   => get_post_meta( $post->ID, '_iga_tag_icon', true ),
			'title'      => get_the_title( $post ),
			'body'       => get_post_meta( $post->ID, '_iga_body', true ),
			'image'      => $image,
			'image_alt'  => $image_alt,
			'cta_label'  => get_post_meta( $post->ID, '_iga_cta_label', true ),
			'cta_icon'   => get_post_meta( $post->ID, '_iga_cta_icon', true ),
			'cta_action' => get_post_meta( $post->ID, '_iga_cta_action', true ),
			'cta_href'   => get_post_meta( $post->ID, '_iga_cta_href', true ),
			'featured'   => (bool) get_post_meta( $post->ID, '_iga_featured', true ),
		];
	}

	if ( empty( $cards ) ) {
		$cards = iga_get_default_distinction_cards();
	}

	return apply_filters( 'iga_distinction_cards', $cards );
}
