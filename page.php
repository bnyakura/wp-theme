<?php
/**
 * Page template.
 *
 * Two cases land here:
 *
 * 1. WooCommerce product category/tag (and other product taxonomy)
 *    archives. This theme has no add_theme_support('woocommerce'), so
 *    WC_Template_Loader's unsupported-theme fallback (see
 *    unsupported_theme_tax_archive_init() in
 *    plugins/woocommerce/includes/class-wc-template-loader.php)
 *    synthesizes a dummy `page` post -- post_name set to the term's slug,
 *    post_content set to the product grid shortcode output -- and forces
 *    WordPress's page template hierarchy (page-{slug}.php -> page.php ->
 *    index.php) to render it. Without this file that hierarchy fell
 *    through to index.php, which has no padding/max-width container, so
 *    category pages like /product-category/bath-soaks/ rendered
 *    WooCommerce's raw unstyled grid -- the same problem page-shop.php
 *    already fixed for the Shop page itself, which page-{slug}.php only
 *    catches for that one literal page. Reuses the Shop page's
 *    .wp-theme-shop-page styling (src/input.css) since the markup WC
 *    generates here is identical.
 *
 * 2. Every other regular Page (Home, About, Contact, ...), none of which
 *    have a page-{slug}.php of their own. These are built entirely from
 *    full-bleed ACF blocks that supply their own backgrounds, so they
 *    only ever needed a bare Loop + the_content() -- exactly what
 *    index.php did before this file existed. That behaviour is preserved
 *    unchanged below.
 *
 * @package custom-theme
 */

get_header();

if ( is_product_taxonomy() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<section class="wp-theme-shop-page bg-cream px-4.5 pb-24 pt-16 font-sans-cs text-cs-ink antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
			<div class="mx-auto max-w-[1280px]">
				<h1 class="mb-10 font-serif text-4xl leading-none sm:text-5xl">
					<?php the_title(); ?>
				</h1>
				<?php the_content(); ?>
			</div>
		</section>
		<?php
	endwhile;
else :
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
endif;

get_footer();
