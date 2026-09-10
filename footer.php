<?php
/**
 * The template for displaying the footer.
 *
 * Contains the site footer and the closing of the <body> and <html> tags.
 * Anything opened in header.php (e.g. a #page wrapper div) must be closed
 * here, before wp_footer().
 *
 * @package custom-theme
 */

$cilla_skyn_logo_id  = get_theme_mod( 'custom_logo' );
$cilla_skyn_logo_url = $cilla_skyn_logo_id ? wp_get_attachment_image_url( $cilla_skyn_logo_id, 'full' ) : '';

$footer_tagline = get_theme_mod( 'iga_footer_tagline', __( 'Modern African skincare. Powered by nature. Made for real skin. For today and generations to come.', 'custom-theme' ) );

/*
 * Editable footer content — Theme Options → Footer (Custom Fields → Field
 * Groups → "Cilla Skyn Footer", acf-json/group_cilla_skyn_footer_options.json).
 * Falls back to the design's original content when a field has never been
 * saved (ACF's own default_value doesn't cover Repeater fields).
 */
$cilla_skyn_social_links = get_field( 'social_links', 'option' );
if ( ! $cilla_skyn_social_links ) {
	$cilla_skyn_social_links = array(
		array(
			'platform' => 'instagram',
			'url'      => 'https://www.instagram.com/Cillaskyn',
		),
	);
}

$cilla_skyn_help_links = get_field( 'help_links', 'option' );
if ( ! $cilla_skyn_help_links ) {
	$cilla_skyn_help_links = array(
		array(
			'label' => __( 'Shipping & Delivery', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Returns & Exchanges', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'FAQs', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Track Your Order', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Contact Us', 'custom-theme' ),
			'url'   => home_url( '/contact/' ),
		),
	);
}

$cilla_skyn_about_links = get_field( 'about_links', 'option' );
if ( ! $cilla_skyn_about_links ) {
	$cilla_skyn_about_links = array(
		array(
			'label' => __( 'Our Story', 'custom-theme' ),
			'url'   => home_url( '/about/' ),
		),
		array(
			'label' => __( 'Our Ingredients', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Sustainability', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'The Edit', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Press', 'custom-theme' ),
			'url'   => '#',
		),
	);
}

$cilla_skyn_legal_links = get_field( 'legal_links', 'option' );
if ( ! $cilla_skyn_legal_links ) {
	$cilla_skyn_legal_links = array(
		array(
			'label' => __( 'Terms', 'custom-theme' ),
			'url'   => home_url( '/terms/' ),
		),
		array(
			'label' => __( 'Privacy', 'custom-theme' ),
			'url'   => home_url( '/privacy/' ),
		),
		array(
			'label' => __( 'Cookies', 'custom-theme' ),
			'url'   => home_url( '/cookies/' ),
		),
	);
}

$cilla_skyn_newsletter_heading     = get_field( 'newsletter_heading', 'option' ) ?: __( 'Join the Cilla Skyn journal.', 'custom-theme' );
$cilla_skyn_newsletter_description = get_field( 'newsletter_description', 'option' ) ?: __( 'Be the first to know about new launches, exclusive offers and skincare rituals.', 'custom-theme' );
?>

<footer id="site-footer" class="border-t border-cs-ink/10 bg-cream-dark pb-6 pt-16 font-sans-cs text-cs-ink">
	<div class="mx-auto max-w-[1400px] px-6 md:px-10">

		<div class="grid grid-cols-1 gap-10 pb-12 md:grid-cols-[1.6fr_1fr_1fr_1fr_1.4fr]">

			<!-- Brand -->
			<div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mb-1 flex items-center gap-3 no-underline">
					<?php if ( $cilla_skyn_logo_url ) : ?>
						<img src="<?php echo esc_url( $cilla_skyn_logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="h-9 w-auto">
					<?php endif; ?>
					<span class="font-serif text-2xl tracking-[0.15em]"><?php bloginfo( 'name' ); ?><sup class="text-[9px]">&trade;</sup></span>
				</a>
				<p class="mb-4 text-[9px] uppercase tracking-[0.22em] text-cs-ink/60">
					<?php echo esc_html( get_theme_mod( 'cilla_skyn_tagline', __( 'Skin for a Brighter Tomorrow', 'custom-theme' ) ) ); ?>
				</p>
				<p class="mb-5 max-w-xs text-sm leading-relaxed text-cs-ink/65"><?php echo esc_html( $footer_tagline ); ?></p>
				<?php if ( ! empty( $cilla_skyn_social_links ) ) : ?>
					<div class="flex items-center gap-4 text-cs-ink/70">
						<?php foreach ( $cilla_skyn_social_links as $social_link ) : ?>
							<?php
							$icon = cilla_skyn_footer_social_icon( $social_link['platform'] ?? '' );
							if ( ! $icon || empty( $social_link['url'] ) ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( $social_link['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $social_link['platform'] ) ); ?>" class="hover:text-cs-ink">
								<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Shop -->
			<nav aria-label="<?php esc_attr_e( 'Footer shop navigation', 'custom-theme' ); ?>">
				<h6 class="mb-4 text-sm font-medium"><?php esc_html_e( 'Shop', 'custom-theme' ); ?></h6>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'cilla-skyn-footer-menu space-y-2.5 text-sm',
						'fallback_cb'    => 'iga_footer_nav_fallback',
						'depth'          => 1,
					)
				);
				?>
			</nav>

			<!-- Help -->
			<?php if ( ! empty( $cilla_skyn_help_links ) ) : ?>
				<div>
					<h6 class="mb-4 text-sm font-medium"><?php esc_html_e( 'Help', 'custom-theme' ); ?></h6>
					<ul class="space-y-2.5 text-sm text-cs-ink/65">
						<?php foreach ( $cilla_skyn_help_links as $link ) : ?>
							<?php if ( ! empty( $link['label'] ) ) : ?>
								<li><a href="<?php echo esc_url( $link['url'] ?: '#' ); ?>" class="hover:text-cs-ink"><?php echo esc_html( $link['label'] ); ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- About -->
			<?php if ( ! empty( $cilla_skyn_about_links ) ) : ?>
				<div>
					<h6 class="mb-4 text-sm font-medium"><?php esc_html_e( 'About', 'custom-theme' ); ?></h6>
					<ul class="space-y-2.5 text-sm text-cs-ink/65">
						<?php foreach ( $cilla_skyn_about_links as $link ) : ?>
							<?php if ( ! empty( $link['label'] ) ) : ?>
								<li><a href="<?php echo esc_url( $link['url'] ?: '#' ); ?>" class="hover:text-cs-ink"><?php echo esc_html( $link['label'] ); ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- Newsletter -->
			<div>
				<h6 class="mb-4 text-sm font-medium"><?php echo esc_html( $cilla_skyn_newsletter_heading ); ?></h6>
				<p class="mb-4 text-sm leading-relaxed text-cs-ink/65"><?php echo esc_html( $cilla_skyn_newsletter_description ); ?></p>
				<form class="flex" onsubmit="return false;">
					<label class="sr-only" for="cilla-skyn-newsletter-email"><?php esc_html_e( 'Your email address', 'custom-theme' ); ?></label>
					<input id="cilla-skyn-newsletter-email" type="email" placeholder="<?php esc_attr_e( 'Your email address', 'custom-theme' ); ?>" class="min-w-0 flex-1 border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm placeholder:text-cs-ink/40 focus:border-cs-ink focus:outline-none">
					<button type="submit" class="shrink-0 bg-cs-ink px-5 py-2.5 text-sm text-cream transition hover:bg-cs-ink/85"><?php esc_html_e( 'Sign Up', 'custom-theme' ); ?></button>
				</form>
			</div>
		</div>

		<!-- Bottom bar -->
		<div class="flex flex-col items-center justify-between gap-3 border-t border-cs-ink/10 pt-6 text-xs text-cs-ink/55 md:flex-row">
			<p>
				<?php
				printf(
					/* translators: %s: current year. */
					esc_html__( '© %s %s. All rights reserved.', 'custom-theme' ),
					esc_html( date_i18n( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
			<p><?php echo esc_html( get_theme_mod( 'cilla_skyn_tagline', __( 'Skin for a Brighter Tomorrow', 'custom-theme' ) ) ); ?></p>
			<div class="flex items-center gap-4">
				<?php foreach ( $cilla_skyn_legal_links as $link ) : ?>
					<?php if ( ! empty( $link['label'] ) ) : ?>
						<a href="<?php echo esc_url( $link['url'] ?: '#' ); ?>" class="hover:text-cs-ink"><?php echo esc_html( $link['label'] ); ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
				<svg class="h-3.5 w-3.5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 20c8-1 12-7 12-16-9 0-14 5-14 12 0 1.5.7 3 2 4z"/></svg>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
