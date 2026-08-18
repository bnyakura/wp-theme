<?php
/**
 * Cart page — wraps WooCommerce's Cart block (still rendered via
 * the_content(), since it's a React-hydrated block, not something worth
 * reimplementing) in the theme's page shell, and restyles it to match the
 * dark theme (see the "Cart page" rules in src/input.css, scoped under
 * .wp-theme-cart-page).
 *
 * WordPress picks this up automatically via its page-{slug}.php hierarchy
 * -- the Cart page's slug is "cart". Without this file the page fell back
 * to index.php, which has no top padding, so the fixed header overlapped
 * the cart title, table header row, and coupon toggle.
 *
 * @package custom-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="wp-theme-cart-page bg-ink px-4.5 pb-24 pt-32 font-sans text-off antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
		<div class="mx-auto max-w-[1280px]">
			<h1 class="mb-10 font-display text-4xl uppercase leading-none tracking-[0.03em] text-white sm:text-5xl">
				<?php the_title(); ?>
			</h1>
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
