<?php
/**
 * Checkout page — wraps WooCommerce's Checkout block (still rendered via
 * the_content(), since it's a React-hydrated block backed by the Store
 * API) in the theme's page shell, and restyles it to match the Cilla Skyn
 * cream theme (see the "Checkout page" rules in src/input.css, scoped
 * under .wp-theme-checkout-page).
 *
 * WordPress picks this up automatically via its page-{slug}.php hierarchy
 * -- the Checkout page's slug is "checkout". Without this file the page
 * fell back to index.php, which has no top padding for this section.
 *
 * @package custom-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="wp-theme-checkout-page bg-cream px-4.5 pb-24 pt-16 font-sans-cs text-cs-ink antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
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
