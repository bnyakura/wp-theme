<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package custom-theme
 */

get_header();

/*
 * A real Loop, not a bare the_content() call. WooCommerce's fallback for
 * themes without add_theme_support('woocommerce') -- which is what injects
 * the actual product template (gallery, price, add-to-cart, tabs) into
 * the_content() on single product pages -- explicitly requires in_the_loop()
 * to be true (see WC_Template_Loader::unsupported_theme_product_content_filter()).
 * Without a proper loop that never fires, so product pages silently fell
 * back to the raw, unstyled post content.
 */
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		if ( function_exists( 'is_product' ) && is_product() ) {
			// WooCommerce's fallback product template is injected with
			// show_title=0 -- it expects the theme to render the title
			// itself.
			the_title( '<h1 class="px-[5vw] pt-16 pb-4 font-display text-3xl uppercase tracking-wide text-white">', '</h1>' );
		}

		the_content();
	endwhile;
endif;

get_footer();
