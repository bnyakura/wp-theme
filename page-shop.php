<?php
/**
 * Shop page — wraps WooCommerce's product grid (still rendered via
 * WC_Template_Loader::unsupported_theme_shop_content_filter() on
 * the_content(), since this theme has no add_theme_support('woocommerce'))
 * in the theme's page shell, and restyles it to match the Cilla Skyn cream
 * theme (see the "Shop page" rules in src/input.css, scoped under
 * .wp-theme-shop-page).
 *
 * WordPress picks this up automatically via its page-{slug}.php hierarchy
 * -- the Shop page's slug is "shop". Without this file the page fell back
 * to index.php, which has no padding/max-width container, so WooCommerce's
 * unstyled default grid ran edge-to-edge.
 *
 * @package custom-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="wp-theme-shop-page bg-cream px-4.5 pb-24 font-sans-cs text-cs-ink antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
		<div class="mx-auto max-w-[1280px]">
			<?php
			/*
			 * No the_title() heading here on purpose -- the Cilla Skyn Banner
			 * block at the top of this page's content already renders its own
			 * <h1> Heading field, so printing the WordPress page title too
			 * would put two <h1>s on the page and show "Shop" twice.
			 */
			the_content();
			?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
