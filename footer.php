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

$instagram_url  = get_theme_mod( 'iga_instagram_url', 'https://www.instagram.com/cillaskyn' );
$footer_tagline = get_theme_mod( 'iga_footer_tagline', __( 'Modern African skincare. Powered by nature. Made for real skin. For today and generations to come.', 'custom-theme' ) );
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
				<div class="flex items-center gap-4 text-cs-ink/70">
					<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="hover:text-cs-ink">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
					</a>
					<a href="#" aria-label="Facebook" class="hover:text-cs-ink">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 9h3V6h-3a3 3 0 00-3 3v2H9v3h2v6h3v-6h3l1-3h-4V9a1 1 0 011-1z"/></svg>
					</a>
					<a href="#" aria-label="TikTok" class="hover:text-cs-ink">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 4v11.5a3.5 3.5 0 11-3-3.46M14 4a5 5 0 005 5"/></svg>
					</a>
					<a href="#" aria-label="Pinterest" class="hover:text-cs-ink">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M10 17c1-4 1.5-6 1.5-8a2 2 0 114 0c0 1.5-1 3.5-1.5 5"/></svg>
					</a>
					<a href="#" aria-label="YouTube" class="hover:text-cs-ink">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="6" width="18" height="12" rx="3"/><path d="M11 10l4 2-4 2v-4z" fill="currentColor" stroke="none"/></svg>
					</a>
				</div>
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
			<div>
				<h6 class="mb-4 text-sm font-medium"><?php esc_html_e( 'Help', 'custom-theme' ); ?></h6>
				<ul class="space-y-2.5 text-sm text-cs-ink/65">
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Shipping & Delivery', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Returns & Exchanges', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'FAQs', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Track Your Order', 'custom-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-cs-ink"><?php esc_html_e( 'Contact Us', 'custom-theme' ); ?></a></li>
				</ul>
			</div>

			<!-- About -->
			<div>
				<h6 class="mb-4 text-sm font-medium"><?php esc_html_e( 'About', 'custom-theme' ); ?></h6>
				<ul class="space-y-2.5 text-sm text-cs-ink/65">
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Our Story', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Our Ingredients', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Sustainability', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'The Edit', 'custom-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-cs-ink"><?php esc_html_e( 'Press', 'custom-theme' ); ?></a></li>
				</ul>
			</div>

			<!-- Newsletter -->
			<div>
				<h6 class="mb-4 text-sm font-medium">
					<?php
					printf(
						/* translators: %s: site name. */
						esc_html__( 'Join the %s journal.', 'custom-theme' ),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
				</h6>
				<p class="mb-4 text-sm leading-relaxed text-cs-ink/65"><?php esc_html_e( 'Be the first to know about new launches, exclusive offers and skincare rituals.', 'custom-theme' ); ?></p>
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
				<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>" class="hover:text-cs-ink"><?php esc_html_e( 'Terms', 'custom-theme' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>" class="hover:text-cs-ink"><?php esc_html_e( 'Privacy', 'custom-theme' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/cookies/' ) ); ?>" class="hover:text-cs-ink"><?php esc_html_e( 'Cookies', 'custom-theme' ); ?></a>
				<svg class="h-3.5 w-3.5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 20c8-1 12-7 12-16-9 0-14 5-14 12 0 1.5.7 3 2 4z"/></svg>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
