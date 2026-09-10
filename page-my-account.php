<?php
/**
 * My Account page — wraps WooCommerce's classic [woocommerce_my_account]
 * shortcode output (still rendered via the_content(); unlike Cart/
 * Checkout this isn't a React-hydrated block, it's plain server-rendered
 * markup) in the theme's page shell, and restyles it to match the Cilla
 * Skyn cream theme (see the "Account page" rules in src/input.css, scoped
 * under .wp-theme-account-page).
 *
 * WordPress picks this up automatically via its page-{slug}.php hierarchy
 * -- the My Account page's slug is "my-account". Without this file the
 * page fell back to page.php's bare `the_content()` branch (no title, no
 * padding, no max-width container, no restyling of WooCommerce's default
 * markup at all), which is why /my-account/ rendered unstyled.
 *
 * @package custom-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="wp-theme-account-page bg-cream px-4.5 pb-24 pt-16 font-sans-cs text-cs-ink antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
		<div class="mx-auto max-w-[1280px]">
			<h1 class="mb-10 font-serif text-4xl leading-none sm:text-5xl">
				<?php the_title(); ?>
			</h1>
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
