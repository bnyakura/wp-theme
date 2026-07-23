<?php
/**
 * Pricing tiers — dashboard-editable pricing cards.
 *
 * Tiers:       Dashboard → Pricing Tiers (title = plan rank, everything else
 *              in the "Tier Settings" meta box, Order for sequence, "Group"
 *              decides which tab the tier appears in).
 * Header text: Appearance → Customize → Pricing Section.
 *
 * Both fall back to the original tiers until anything is added/changed.
 *
 * @package IGA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tier meta fields.
 */
function iga_pricing_tier_fields() {
	return [
		'_iga_group'      => [
			'label'   => __( 'Group (tab)', 'iga' ),
			'type'    => 'select',
			'options' => [
				'monthly' => __( 'Monthly Memberships', 'iga' ),
				'dropin'  => __( 'Drop-In Sessions', 'iga' ),
			],
			'desc'    => __( 'Which pricing tab this tier appears in.', 'iga' ),
		],
		'_iga_sub'        => [
			'label' => __( 'Label above plan name', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Small uppercase line, e.g. “Open Gym · Monthly”.', 'iga' ),
		],
		'_iga_price'      => [
			'label' => __( 'Price', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'As displayed, e.g. “R 200”.', 'iga' ),
		],
		'_iga_cadence'    => [
			'label' => __( 'Cadence', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Small text after the price, e.g. “per month”, “per pack”, “per session”.', 'iga' ),
		],
		'_iga_desc'       => [
			'label' => __( 'Description', 'iga' ),
			'type'  => 'textarea',
			'desc'  => __( 'Short paragraph under the price.', 'iga' ),
		],
		'_iga_features'   => [
			'label' => __( 'Features', 'iga' ),
			'type'  => 'textarea',
			'desc'  => __( 'One per line — each becomes a check-marked list item.', 'iga' ),
		],
		'_iga_badge'      => [
			'label' => __( 'Badge (optional)', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Ribbon attached to the top of the card, e.g. “Most Popular”.', 'iga' ),
		],
		'_iga_primary'    => [
			'label' => __( 'Primary tier', 'iga' ),
			'type'  => 'checkbox',
			'desc'  => __( 'Green gradient card, green accents and a green CTA button.', 'iga' ),
		],
		'_iga_cta_label'  => [
			'label' => __( 'CTA label', 'iga' ),
			'type'  => 'text',
			'desc'  => __( 'Button text, e.g. “Enlist Now”.', 'iga' ),
		],
		'_iga_cta_action' => [
			'label'   => __( 'CTA action', 'iga' ),
			'type'    => 'select',
			'options' => [
				'link'           => __( 'Link to a page (uses URL below)', 'iga' ),
				'enlist-modal'   => __( 'Open “Enlist Now” modal', 'iga' ),
				'packages-modal' => __( 'Open “Packages” modal ¹', 'iga' ),
				'booking-modal'  => __( 'Open “Booking” modal ¹', 'iga' ),
			],
			'desc'    => __( '¹ These modals work once their template parts are converted too.', 'iga' ),
		],
		'_iga_cta_href'   => [
			'label' => __( 'CTA link URL', 'iga' ),
			'type'  => 'url',
			'desc'  => __( 'Site path like /book or a full URL. Only used for “Link to a page”.', 'iga' ),
		],
	];
}

/**
 * Register the post type.
 */
function iga_register_pricing_tier_post_type() {
	register_post_type(
		'iga_price_tier',
		[
			'labels'        => [
				'name'          => __( 'Pricing Tiers', 'iga' ),
				'singular_name' => __( 'Pricing Tier', 'iga' ),
				'add_new_item'  => __( 'Add New Tier', 'iga' ),
				'edit_item'     => __( 'Edit Tier', 'iga' ),
			],
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_icon'     => 'dashicons-money-alt',
			'menu_position' => 23,
			'supports'      => [ 'title', 'page-attributes' ],
			'rewrite'       => false,
		]
	);
}
add_action( 'init', 'iga_register_pricing_tier_post_type' );

/**
 * Meta box.
 */
function iga_pricing_tier_meta_boxes() {
	add_meta_box(
		'iga-pricing-tier-settings',
		__( 'Tier Settings', 'iga' ),
		'iga_render_pricing_tier_meta_box',
		'iga_price_tier',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'iga_pricing_tier_meta_boxes' );

/**
 * Render the meta box.
 */
function iga_render_pricing_tier_meta_box( $post ) {
	wp_nonce_field( 'iga_pricing_tier_save', 'iga_pricing_tier_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';

	foreach ( iga_pricing_tier_fields() as $key => $field ) {
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
					'<textarea id="%1$s" name="%1$s" rows="%3$d" class="large-text">%2$s</textarea>',
					esc_attr( $key ),
					esc_textarea( $value ),
					'_iga_features' === $key ? 5 : 3
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
function iga_save_pricing_tier( $post_id ) {
	if (
		! isset( $_POST['iga_pricing_tier_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['iga_pricing_tier_nonce'] ) ), 'iga_pricing_tier_save' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( iga_pricing_tier_fields() as $key => $field ) {
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
add_action( 'save_post_iga_price_tier', 'iga_save_pricing_tier' );

/**
 * Split a textarea into a trimmed line array (used for Features).
 */
function iga_pricing_parse_lines( $raw ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	return array_values(
		array_filter(
			array_map( 'trim', $lines ),
			static fn( $line ) => '' !== $line
		)
	);
}

/**
 * Default tiers — shown until at least one Pricing Tier is published.
 * Mirrors MONTHLY_TIERS / DROPIN_TIERS from the original React component.
 */
function iga_get_default_pricing_tiers() {
	return [
		'monthly' => [
			[
				'rank'       => __( 'Studio Access', 'iga' ),
				'sub'        => __( 'Open Gym · Monthly', 'iga' ),
				'price'      => 'R 200',
				'cadence'    => __( 'per month', 'iga' ),
				'desc'       => __( 'Open gym access on your own terms. No coach required — just you, the equipment, and the iron.', 'iga' ),
				'features'   => [ __( 'Unlimited studio access', 'iga' ), __( 'Self-directed training', 'iga' ), __( 'Full equipment use', 'iga' ), __( 'No lock-in contract', 'iga' ) ],
				'cta_label'  => __( 'Get Access', 'iga' ),
				'cta_action' => 'packages-modal',
				'cta_href'   => '',
				'primary'    => false,
				'badge'      => '',
			],
			[
				'rank'       => __( 'Platoons', 'iga' ),
				'sub'        => __( 'Group Training · Monthly', 'iga' ),
				'price'      => 'R 800',
				'cadence'    => __( 'per month', 'iga' ),
				'desc'       => __( 'Structured group training every week. The core membership for committed members who want community and accountability.', 'iga' ),
				'features'   => [ __( 'Unlimited group sessions', 'iga' ), __( 'Coach-led programming', 'iga' ), __( 'Community events access', 'iga' ), __( 'No lock-in contract', 'iga' ) ],
				'cta_label'  => __( 'Enlist Now', 'iga' ),
				'cta_action' => 'enlist-modal',
				'cta_href'   => '',
				'primary'    => true,
				'badge'      => __( 'Most Popular', 'iga' ),
			],
			[
				'rank'       => __( 'Squads', 'iga' ),
				'sub'        => __( 'Personal Sessions · Pack of 4', 'iga' ),
				'price'      => 'R 950',
				'cadence'    => __( 'per pack', 'iga' ),
				'desc'       => __( 'Four personalized 1-on-1 sessions in one block. Serious coaching for serious results — R238 per session.', 'iga' ),
				'features'   => [ __( '4 personalized sessions', 'iga' ), __( '1-on-1 coaching', 'iga' ), __( 'Flexible scheduling', 'iga' ), __( 'Progress tracking', 'iga' ) ],
				'cta_label'  => __( 'Get Started', 'iga' ),
				'cta_action' => 'packages-modal',
				'cta_href'   => '',
				'primary'    => false,
				'badge'      => '',
			],
		],
		'dropin'  => [
			[
				'rank'       => __( 'Platoon Drop-In', 'iga' ),
				'sub'        => __( 'Group Session · Single', 'iga' ),
				'price'      => 'R 100',
				'cadence'    => __( 'per session', 'iga' ),
				'desc'       => __( 'Drop in for a single group session. Coach-supervised, full equipment access. No strings attached.', 'iga' ),
				'features'   => [ __( 'Single group session', 'iga' ), __( 'Coach-supervised', 'iga' ), __( 'Full equipment use', 'iga' ), __( 'No contract required', 'iga' ) ],
				'cta_label'  => __( 'Book Drop-In', 'iga' ),
				'cta_action' => 'link',
				'cta_href'   => '/book',
				'primary'    => true,
				'badge'      => __( 'Most Popular', 'iga' ),
			],
			[
				'rank'       => __( 'Squad Drop-In', 'iga' ),
				'sub'        => __( 'Personal Session · Single', 'iga' ),
				'price'      => 'R 200',
				'cadence'    => __( 'per session', 'iga' ),
				'desc'       => __( 'A single personalized session with focused 1-on-1 coaching. Test the experience before committing.', 'iga' ),
				'features'   => [ __( 'Single personalized session', 'iga' ), __( '1-on-1 coaching', 'iga' ), __( 'Tailored to your goals', 'iga' ), __( 'No contract required', 'iga' ) ],
				'cta_label'  => __( 'Book Session', 'iga' ),
				'cta_action' => 'link',
				'cta_href'   => '/book',
				'primary'    => false,
				'badge'      => '',
			],
		],
	];
}

/**
 * Get tiers grouped by tab: published posts, else defaults.
 *
 * @return array{monthly: array[], dropin: array[]}
 */
function iga_get_pricing_tiers() {
	$posts = get_posts(
		[
			'post_type'      => 'iga_price_tier',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		]
	);

	$tiers = [ 'monthly' => [], 'dropin' => [] ];

	foreach ( $posts as $post ) {
		$group = 'dropin' === get_post_meta( $post->ID, '_iga_group', true ) ? 'dropin' : 'monthly';

		$tiers[ $group ][] = [
			'rank'       => get_the_title( $post ),
			'sub'        => get_post_meta( $post->ID, '_iga_sub', true ),
			'price'      => get_post_meta( $post->ID, '_iga_price', true ),
			'cadence'    => get_post_meta( $post->ID, '_iga_cadence', true ),
			'desc'       => get_post_meta( $post->ID, '_iga_desc', true ),
			'features'   => iga_pricing_parse_lines( get_post_meta( $post->ID, '_iga_features', true ) ),
			'cta_label'  => get_post_meta( $post->ID, '_iga_cta_label', true ),
			'cta_action' => get_post_meta( $post->ID, '_iga_cta_action', true ) ?: 'link',
			'cta_href'   => get_post_meta( $post->ID, '_iga_cta_href', true ),
			'primary'    => (bool) get_post_meta( $post->ID, '_iga_primary', true ),
			'badge'      => get_post_meta( $post->ID, '_iga_badge', true ),
		];
	}

	// All-or-nothing fallback: once any tier exists, the client owns the full grid.
	if ( empty( $tiers['monthly'] ) && empty( $tiers['dropin'] ) ) {
		$tiers = iga_get_default_pricing_tiers();
	}

	return apply_filters( 'iga_pricing_tiers', $tiers );
}

/**
 * Header text: Customizer settings with original copy as defaults.
 */
function iga_pricing_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'iga_pricing',
		[
			'title'       => __( 'Pricing Section', 'iga' ),
			'description' => __( 'The "Choose Your Rank" header. The pricing cards themselves are managed under Dashboard → Pricing Tiers.', 'iga' ),
			'priority'    => 33,
		]
	);

	$fields = [
		'iga_pricing_eyebrow'  => [
			'label'   => __( 'Eyebrow', 'iga' ),
			'type'    => 'text',
			'default' => __( 'Membership', 'iga' ),
		],
		'iga_pricing_title'    => [
			'label'   => __( 'Heading', 'iga' ),
			'type'    => 'text',
			'default' => __( 'Choose Your Rank', 'iga' ),
		],
		'iga_pricing_subtitle' => [
			'label'   => __( 'Subtitle', 'iga' ),
			'type'    => 'textarea',
			'default' => __( 'No hidden fees. No lock-in contracts. Choose how you want to train.', 'iga' ),
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
				'section' => 'iga_pricing',
				'type'    => $field['type'],
			]
		);
	}
}
add_action( 'customize_register', 'iga_pricing_customize_register' );

/**
 * Get the Pricing section header args (ready for the section-header part).
 */
function iga_get_pricing_header() {
	return apply_filters(
		'iga_pricing_header',
		[
			'eyebrow'  => get_theme_mod( 'iga_pricing_eyebrow', __( 'Membership', 'iga' ) ),
			'title'    => get_theme_mod( 'iga_pricing_title', __( 'Choose Your Rank', 'iga' ) ),
			'subtitle' => get_theme_mod( 'iga_pricing_subtitle', __( 'No hidden fees. No lock-in contracts. Choose how you want to train.', 'iga' ) ),
		]
	);
}
