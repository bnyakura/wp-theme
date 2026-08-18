<?php
/**
 * Single product page — styled to match the theme instead of WooCommerce's
 * default markup.
 *
 * This theme has no add_theme_support('woocommerce'), so WooCommerce never
 * takes over template routing for singular products (see
 * WC_Template_Loader::init()) -- WordPress's normal single-{post_type}.php
 * hierarchy picks this file up on its own. Product data/cart/tabs still use
 * WooCommerce's own template functions (gallery, add-to-cart, variations,
 * meta, tabs) for correctness; only the surrounding markup and CSS are
 * custom.
 *
 * @package custom-theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	global $product;

	if ( ! $product instanceof WC_Product ) {
		$product = wc_get_product( get_the_ID() );
	}

	if ( ! $product ) {
		continue;
	}

	$on_sale  = $product->is_on_sale();
	$in_stock = $product->is_in_stock();
	$cats     = wc_get_product_category_list( $product->get_id() );
	?>
	<section class="bg-ink px-4.5 pb-24 pt-32 font-sans text-off antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
		<div class="mx-auto max-w-[1280px]">

			<nav class="wp-theme-single-product-breadcrumb mb-8 text-xs uppercase tracking-[0.14em] text-white/40">
				<?php woocommerce_breadcrumb(); ?>
			</nav>

			<?php wc_print_notices(); ?>

			<div class="grid gap-10 lg:grid-cols-2 lg:gap-16">

				<div class="wp-theme-single-product-gallery">
					<?php woocommerce_show_product_images(); ?>
				</div>

				<div class="flex flex-col justify-center">

					<?php if ( $cats ) : ?>
						<div class="mb-2 text-[0.7rem] font-bold uppercase tracking-[0.18em] text-green-l"><?php echo wp_kses_post( $cats ); ?></div>
					<?php endif; ?>

					<h1 class="font-display text-4xl uppercase leading-none tracking-[0.03em] text-white sm:text-5xl">
						<?php the_title(); ?>
					</h1>

					<div class="mt-5 flex items-center gap-3">
						<div class="wp-theme-single-product-price text-2xl text-white/90"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
						<?php if ( $on_sale ) : ?>
							<span class="rounded-full bg-green px-3 py-1 text-[0.65rem] font-bold uppercase tracking-[0.12em] text-white"><?php esc_html_e( 'Sale', 'iga' ); ?></span>
						<?php elseif ( ! $in_stock ) : ?>
							<span class="rounded-full bg-white/10 px-3 py-1 text-[0.65rem] font-bold uppercase tracking-[0.12em] text-white/60"><?php esc_html_e( 'Out of Stock', 'iga' ); ?></span>
						<?php endif; ?>
					</div>

					<?php if ( $product->get_short_description() ) : ?>
						<div class="mt-6 max-w-md text-sm leading-7 text-white/60">
							<?php echo apply_filters( 'woocommerce_short_description', $product->get_short_description() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php endif; ?>

					<div class="wp-theme-single-product-cart mt-8">
						<?php woocommerce_template_single_add_to_cart(); ?>
					</div>

					<div class="wp-theme-single-product-meta mt-8 border-t border-line pt-6">
						<?php woocommerce_template_single_meta(); ?>
					</div>

				</div>
			</div>

			<div class="wp-theme-single-product-tabs mt-20">
				<?php woocommerce_output_product_data_tabs(); ?>
			</div>

			<div class="mt-24">
				<?php iga_render_related_products( $product ); ?>
			</div>

		</div>
	</section>
	<?php
endwhile;

get_footer();
