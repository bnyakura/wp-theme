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

$cilla_skyn_shop_links = get_field( 'shop_links', 'option' );
if ( ! $cilla_skyn_shop_links ) {
	$shop_url              = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	$cilla_skyn_shop_links = array(
		array(
			'label' => __( 'All Products', 'custom-theme' ),
			'url'   => $shop_url,
		),
		array(
			'label' => __( 'Best Sellers', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'The Baby Collection', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Bundles & Sets', 'custom-theme' ),
			'url'   => '#',
		),
		array(
			'label' => __( 'Gift Cards', 'custom-theme' ),
			'url'   => '#',
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
			<?php if ( ! empty( $cilla_skyn_shop_links ) ) : ?>
				<nav aria-label="<?php esc_attr_e( 'Footer shop navigation', 'custom-theme' ); ?>">
					<h6 class="mb-4 text-sm font-medium"><?php esc_html_e( 'Shop', 'custom-theme' ); ?></h6>
					<ul class="space-y-2.5 text-sm text-cs-ink/65">
						<?php foreach ( $cilla_skyn_shop_links as $link ) : ?>
							<?php if ( ! empty( $link['label'] ) ) : ?>
								<li><a href="<?php echo esc_url( $link['url'] ?: '#' ); ?>" class="hover:text-cs-ink"><?php echo esc_html( $link['label'] ); ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>

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

<?php
/*
 * Floating WhatsApp chat button — a fixed icon in the bottom-right corner
 * of every page. Clicking it opens a small panel with a textarea; on
 * Send, assets/js/whatsapp-chat.js builds a wa.me link (the number
 * configured under Customize -> Site Identity -> WhatsApp Number,
 * iga_get_whatsapp_number_url() in inc/theme-setup.php, same helper the
 * Book Assessment flow uses) with the typed message pre-filled and opens
 * it in a new tab. There's no WhatsApp Business API integration here --
 * that needs a paid, approved API account -- so "Send" hands off to
 * WhatsApp itself (app or web) with the message ready to go; the visitor
 * still taps Send inside WhatsApp. This is the standard "click-to-chat"
 * pattern every wa.me-based chat widget uses.
 */
$cilla_skyn_whatsapp_base_url = iga_get_whatsapp_number_url();
?>
<div class="fixed bottom-6 right-6 z-50 font-sans-cs">
	<div
		id="whatsapp-chat-panel"
		hidden
		role="dialog"
		aria-modal="false"
		aria-labelledby="whatsapp-chat-heading"
		class="absolute bottom-[calc(100%+0.75rem)] right-0 w-[min(90vw,20rem)] border border-cs-ink/10 bg-cream shadow-xl"
	>
		<div class="flex items-center justify-between gap-3 bg-cs-ink px-4 py-3 text-cream">
			<p id="whatsapp-chat-heading" class="font-serif text-base"><?php esc_html_e( 'Chat with us', 'custom-theme' ); ?></p>
			<button type="button" id="whatsapp-chat-close" class="text-cream/70 hover:text-cream" aria-label="<?php esc_attr_e( 'Close chat', 'custom-theme' ); ?>">
				<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
			</button>
		</div>
		<form id="whatsapp-chat-form" data-whatsapp-url="<?php echo esc_url( $cilla_skyn_whatsapp_base_url ); ?>" class="flex flex-col gap-3 p-4">
			<label for="whatsapp-chat-message" class="text-sm leading-relaxed text-cs-ink/70">
				<?php esc_html_e( "Send us a message on WhatsApp — we'll pick up right where you leave off.", 'custom-theme' ); ?>
			</label>
			<textarea
				id="whatsapp-chat-message"
				name="message"
				rows="4"
				placeholder="<?php esc_attr_e( 'Type your message…', 'custom-theme' ); ?>"
				class="w-full resize-none border border-cs-ink/25 bg-cream px-3 py-2.5 text-sm placeholder:text-cs-ink/40 focus:border-cs-ink focus:outline-none"
			></textarea>
			<button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#25D366] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#1DA851]">
				<?php esc_html_e( 'Send on WhatsApp', 'custom-theme' ); ?> <span aria-hidden="true">→</span>
			</button>
		</form>
	</div>

	<button
		type="button"
		id="whatsapp-chat-toggle"
		aria-expanded="false"
		aria-controls="whatsapp-chat-panel"
		aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'custom-theme' ); ?>"
		class="flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg transition hover:bg-[#1DA851]"
	>
		<svg class="h-7 w-7" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
			<path d="M16.01 3C9.38 3 4 8.36 4 14.97c0 2.2.6 4.27 1.64 6.05L4 29l8.2-1.6a13.1 13.1 0 003.8.57h.01c6.63 0 12.01-5.36 12.01-11.97C28.02 8.36 22.64 3 16.01 3zm0 21.86h-.01a10.9 10.9 0 01-3.63-.63l-.28-.13-4.87.95.98-4.75-.16-.29a9.8 9.8 0 01-1.6-5.36C6.44 9.55 10.62 5.38 16.01 5.38c5.4 0 9.64 4.17 9.64 9.6 0 5.42-4.24 9.88-9.64 9.88zm5.4-7.24c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.66.15-.2.3-.76.96-.93 1.15-.17.2-.34.22-.64.08-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.48-1.75-1.65-2.05-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.66-1.6-.9-2.18-.24-.58-.48-.5-.66-.51h-.56c-.2 0-.52.08-.79.37-.27.3-1.03 1-1.03 2.45s1.06 2.85 1.2 3.05c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.62.71.23 1.35.2 1.86.12.57-.08 1.75-.71 2-1.4.24-.68.24-1.27.17-1.4-.07-.13-.27-.2-.57-.35z"/>
		</svg>
	</button>
</div>

<?php wp_footer(); ?>

</body>
</html>
