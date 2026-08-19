<?php
/**
 * The template for displaying the footer.
 *
 * Contains the site footer and the closing of the <body> and <html> tags.
 * Anything opened in header.php (e.g. a #page wrapper div) must be closed
 * here, before wp_footer().
 *
 * @package IGA
 */

$logo_id  = get_theme_mod( 'custom_logo' );
$logo_url = $logo_id
	? wp_get_attachment_image_url( $logo_id, 'full' )
	: get_theme_file_uri( 'assets/images/logo.png' );

$instagram_url  = get_theme_mod( 'iga_instagram_url', 'https://www.instagram.com/irongorillaarmy' );
$footer_tagline = get_theme_mod( 'iga_footer_tagline', __( 'A community built around iron and faith. Salt River, Cape Town. Forging people of discipline, purpose, and strength since 2022.', 'iga' ) );
?>

<?php // Close header.php wrappers here if needed, e.g. </div><!-- #page -->. ?>

<footer id="site-footer" class="border-t border-line bg-s1 px-[5vw] pb-8 pt-[60px]">
	<div class="mb-12 grid grid-cols-1 gap-10 min-[601px]:grid-cols-2 min-[1081px]:grid-cols-[2fr_1fr_1fr_1fr]">

		<!-- Brand -->
		<div class="min-[601px]:col-span-2 min-[1081px]:col-span-1">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mb-5 flex items-center gap-[15px] transition-opacity duration-200 hover:opacity-85">
				<img
					src="<?php echo esc_url( $logo_url ); ?>"
					alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
					width="45"
					height="45"
					class="block h-[45px] w-auto rounded-lg"
				/>
				<span class="mt-1 font-display text-[1.8rem] uppercase tracking-[2px] text-white">
					Iron <span class="text-green-l">Gorilla</span> Army
				</span>
			</a>
			<p class="max-w-[300px] text-[0.95rem] leading-[1.7] text-muted">
				<?php echo esc_html( $footer_tagline ); ?>
			</p>
		</div>

		<!-- Navigate -->
		<nav aria-label="<?php esc_attr_e( 'Footer navigation', 'iga' ); ?>">
			<h4 class="mb-4 font-display text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l">
				<?php esc_html_e( 'Navigate', 'iga' ); ?>
			</h4>
			<?php
			wp_nav_menu(
				[
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'flex list-none flex-col gap-2.5',
					'fallback_cb'    => 'iga_footer_nav_fallback',
					'depth'          => 1,
				]
			);
			?>
		</nav>

		<!-- Get In -->
		<div>
			<h4 class="mb-4 font-display text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l">
				<?php esc_html_e( 'Get In', 'iga' ); ?>
			</h4>
			<ul class="flex list-none flex-col gap-2.5">
				<li>
					<a
						href="<?php echo esc_url( iga_get_whatsapp_group_url() ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						class="cursor-pointer p-0 text-[0.95rem] text-muted-l transition-colors duration-200 hover:text-white"
					>
						<?php esc_html_e( 'Join Community', 'iga' ); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/book/' ) ); ?>" class="text-[0.95rem] text-muted-l transition-colors duration-200 hover:text-white">
						<?php esc_html_e( 'Book Drop-In', 'iga' ); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="text-[0.95rem] text-muted-l transition-colors duration-200 hover:text-white">
						<?php esc_html_e( 'Contact Us', 'iga' ); ?>
					</a>
				</li>
			</ul>
		</div>

		<!-- Find Us -->
		<div>
			<h4 class="mb-4 font-display text-[0.8rem] font-bold uppercase tracking-[2px] text-green-l">
				<?php esc_html_e( 'Find Us', 'iga' ); ?>
			</h4>
			<address class="text-[0.95rem] not-italic leading-[1.8] text-muted-l">
				Unit 209 Salt Circle, Kent Str.<br />
				Salt River, Cape Town
			</address>
			<ul class="mt-4 flex list-none flex-col">
				<li class="flex justify-between text-[0.9rem] text-muted-l">
					<span><?php esc_html_e( 'Mon – Sat', 'iga' ); ?></span>
					<span class="text-white"><?php esc_html_e( '6AM – 9PM', 'iga' ); ?></span>
				</li>
				<li class="mt-2 flex justify-between text-[0.9rem] text-muted">
					<span><?php esc_html_e( 'Sunday', 'iga' ); ?></span>
					<span><?php esc_html_e( 'Closed', 'iga' ); ?></span>
				</li>
			</ul>
		</div>

	</div>

	<!-- Bottom bar -->
	<div class="flex flex-col items-start gap-3 border-t border-line pt-6 min-[601px]:flex-row min-[601px]:flex-wrap min-[601px]:items-center min-[601px]:justify-between">
		<p class="text-[0.85rem] text-muted">
			<?php
			printf(
				/* translators: %s: current year. */
				esc_html__( '© %s Iron Gorilla Army. All rights reserved.', 'iga' ),
				esc_html( date_i18n( 'Y' ) )
			);
			?>&nbsp;&nbsp;
			<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>" class="text-[0.8rem] text-muted"><?php esc_html_e( 'Terms', 'iga' ); ?></a>
			&middot;
			<a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>" class="text-[0.8rem] text-muted"><?php esc_html_e( 'Privacy', 'iga' ); ?></a>
			&middot;
			<a href="<?php echo esc_url( home_url( '/refund/' ) ); ?>" class="text-[0.8rem] text-muted"><?php esc_html_e( 'Refunds', 'iga' ); ?></a>
		</p>

		<div class="flex gap-3">
			<a
				href="<?php echo esc_url( $instagram_url ); ?>"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="Instagram"
				class="flex h-10 w-10 items-center justify-center rounded-full border border-line-strong text-base text-muted transition-all duration-200 hover:border-white/30 hover:bg-s3 hover:text-white"
			>
				<i class="fa-brands fa-instagram" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</footer>

<?php
// Floating WhatsApp button, shown site-wide (matches the original site's <WhatsApp /> in its root layout).
$footer_whatsapp = get_theme_mod( 'iron_gorilla_whatsapp', '' );
?>

<?php if ( $footer_whatsapp ) : ?>
	<a
		href="https://wa.me/<?php echo esc_attr( $footer_whatsapp ); ?>?text=<?php echo urlencode( 'Hi Iron Gorilla Army, I want to find out more about joining The Forge.' ); ?>"
		target="_blank"
		rel="noopener noreferrer"
		aria-label="Chat on WhatsApp"
		class="fixed bottom-7 right-7 z-900 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-2xl text-white shadow-[0_4px_20px_rgba(37,211,102,0.45)] transition duration-200 hover:scale-110 hover:shadow-[0_6px_28px_rgba(37,211,102,0.6)] max-[768px]:bottom-5 max-[768px]:right-4 max-[768px]:h-12 max-[768px]:w-12 max-[768px]:text-xl"
	>
		<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
