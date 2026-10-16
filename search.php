<?php
/**
 * Search results template.
 *
 * Why this file exists: the header search form (header.php) submits a plain
 * WordPress keyword query (?s=...) with no post_type, so WooCommerce leaves it
 * as an ordinary mixed search -- its pre_get_posts() only strips products
 * flagged hidden-from-search (see WC_Query::pre_get_posts()), it does not turn
 * the query into a product loop. Without a search.php the results fell through
 * the template hierarchy to index.php, whose loop just calls the_content() on
 * each hit. On a search page is_product() is false, so WooCommerce's
 * unsupported-theme content filter never injects the product-card markup --
 * matched products rendered as a bare, title-less blob of their description
 * text (or nothing at all for products with no description).
 *
 * This template instead renders matched products as the site's standard
 * WooCommerce product cards -- the same [products] grid the Shop page, Best
 * Sellers and "You May Also Like" blocks use -- and lists any non-product hits
 * (pages, posts) beneath them. The product-card styling is shared via the
 * .wp-theme-search-results scope in src/input.css, which rides on the Best
 * Sellers ruleset. The page shell matches page-shop.php / page.php.
 *
 * @package custom-theme
 */

get_header();

$cilla_skyn_search_query = get_search_query();
?>
<section class="wp-theme-search-results bg-cream px-4.5 pb-24 pt-16 font-sans-cs text-cs-ink antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
	<div class="mx-auto max-w-[1280px]">

		<header class="mb-10">
			<p class="mb-2 text-[11px] uppercase tracking-[0.22em] text-cs-ink/60">
				<?php esc_html_e( 'Search results', 'custom-theme' ); ?>
			</p>
			<h1 class="font-serif text-4xl leading-none sm:text-5xl">
				<?php
				printf(
					/* translators: %s: the search term. */
					esc_html__( 'Results for &ldquo;%s&rdquo;', 'custom-theme' ),
					esc_html( $cilla_skyn_search_query )
				);
				?>
			</h1>
			<?php if ( have_posts() ) : ?>
				<p class="mt-3 text-sm text-cs-ink/60">
					<?php
					$cilla_skyn_found = (int) $GLOBALS['wp_query']->found_posts;
					printf(
						/* translators: %s: number of results found. */
						esc_html( _n( '%s result found', '%s results found', $cilla_skyn_found, 'custom-theme' ) ),
						esc_html( number_format_i18n( $cilla_skyn_found ) )
					);
					?>
				</p>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<?php
			/*
			 * Split this page of results: products render as the site's
			 * standard WooCommerce cards, everything else as a plain linked
			 * list below. The main query is paginated, so only the current
			 * page's hits are collected here.
			 */
			$cilla_skyn_product_ids = array();
			$cilla_skyn_other_ids   = array();

			while ( have_posts() ) :
				the_post();
				if ( 'product' === get_post_type() && function_exists( 'wc_get_product' ) ) {
					$cilla_skyn_product_ids[] = get_the_ID();
				} else {
					$cilla_skyn_other_ids[] = get_the_ID();
				}
			endwhile;
			wp_reset_postdata();
			?>

			<?php if ( ! empty( $cilla_skyn_product_ids ) ) : ?>
				<?php
				/*
				 * Hand the matched product IDs to WooCommerce's [products]
				 * shortcode -- identical grid markup and AJAX add-to-cart as
				 * every other product surface on the site. limit matches the
				 * id count so the shortcode's default per-page cap can't drop
				 * any (same approach as iga_render_related_products()).
				 */
				echo do_shortcode(
					sprintf(
						'[products ids="%s" columns="4" limit="%d"]',
						esc_attr( implode( ',', array_map( 'absint', $cilla_skyn_product_ids ) ) ),
						count( $cilla_skyn_product_ids )
					)
				);
				?>
			<?php endif; ?>

			<?php if ( ! empty( $cilla_skyn_other_ids ) ) : ?>
				<?php if ( ! empty( $cilla_skyn_product_ids ) ) : ?>
					<h2 class="mb-6 mt-14 font-serif text-2xl"><?php esc_html_e( 'Pages &amp; articles', 'custom-theme' ); ?></h2>
				<?php endif; ?>
				<ul class="border-t border-cs-ink/10">
					<?php foreach ( $cilla_skyn_other_ids as $cilla_skyn_other_id ) : ?>
						<li class="border-b border-cs-ink/10">
							<a href="<?php echo esc_url( get_permalink( $cilla_skyn_other_id ) ); ?>" class="group block py-5 no-underline">
								<h3 class="font-sans-cs text-base font-medium text-cs-ink transition group-hover:text-gold">
									<?php echo esc_html( get_the_title( $cilla_skyn_other_id ) ); ?>
								</h3>
								<?php $cilla_skyn_excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $cilla_skyn_other_id ) ), 28 ); ?>
								<?php if ( '' !== $cilla_skyn_excerpt ) : ?>
									<p class="mt-1 text-sm text-cs-ink/60"><?php echo esc_html( $cilla_skyn_excerpt ); ?></p>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php
			// Note: the_posts_pagination() runs 'class' through
			// sanitize_html_class(), which strips spaces -- so this must stay a
			// single class (the top margin is applied in CSS, not via mt-*).
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'class'     => 'wp-theme-search-pagination',
					'prev_text' => esc_html__( '&larr; Prev', 'custom-theme' ),
					'next_text' => esc_html__( 'Next &rarr;', 'custom-theme' ),
				)
			);
			?>

		<?php else : ?>

			<p class="max-w-prose text-sm text-cs-ink/70">
				<?php esc_html_e( 'We couldn&rsquo;t find anything matching your search. Try a different word, or browse the full collection.', 'custom-theme' ); ?>
			</p>

			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-6 flex max-w-sm gap-2">
				<label class="sr-only" for="cilla-skyn-search-results-input"><?php esc_html_e( 'Search', 'custom-theme' ); ?></label>
				<input id="cilla-skyn-search-results-input" type="search" name="s" value="<?php echo esc_attr( $cilla_skyn_search_query ); ?>" placeholder="<?php esc_attr_e( 'Search&hellip;', 'custom-theme' ); ?>" class="min-w-0 flex-1 border border-cs-ink/20 bg-cream px-3 py-2 text-sm placeholder:text-cs-ink/40 focus:border-cs-ink focus:outline-none">
				<button type="submit" class="bg-cs-ink px-4 py-2 text-sm text-cream transition hover:bg-cs-ink/85"><?php esc_html_e( 'Search', 'custom-theme' ); ?></button>
			</form>

			<?php $cilla_skyn_shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : ''; ?>
			<?php if ( $cilla_skyn_shop_url ) : ?>
				<a href="<?php echo esc_url( $cilla_skyn_shop_url ); ?>" class="mt-6 inline-block text-[13px] underline underline-offset-4 transition hover:text-gold">
					<?php esc_html_e( 'Browse all products &rarr;', 'custom-theme' ); ?>
				</a>
			<?php endif; ?>

		<?php endif; ?>

	</div>
</section>
<?php
get_footer();
