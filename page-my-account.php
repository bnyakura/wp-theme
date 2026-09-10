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

	/*
	 * The My Account page is one physical page shared by every account
	 * endpoint (Orders, Downloads, Addresses, Account Details, ...) --
	 * WooCommerce rewrites /my-account/orders/ etc. to this same page with
	 * a query var, it doesn't create separate pages/templates. Without
	 * this, the_title() would print "My account" on every one of those
	 * sub-pages instead of the section actually being viewed. Endpoint
	 * labels are pulled from wc_get_account_menu_items() -- the same
	 * source the account nav itself uses -- rather than hardcoded, so a
	 * plugin-added endpoint (e.g. Subscriptions) gets a correct title too.
	 */
	$cilla_skyn_account_title = get_the_title();

	if ( function_exists( 'is_wc_endpoint_url' ) && function_exists( 'WC' ) && is_wc_endpoint_url() ) {
		if ( is_wc_endpoint_url( 'view-order' ) ) {
			$cilla_skyn_account_title = __( 'Order Details', 'custom-theme' );
		} else {
			global $wp;
			$wc_endpoint_query_vars = WC()->query->get_query_vars();
			$account_menu_items     = function_exists( 'wc_get_account_menu_items' ) ? wc_get_account_menu_items() : array();

			foreach ( $wc_endpoint_query_vars as $endpoint_key => $query_var ) {
				if ( isset( $wp->query_vars[ $query_var ], $account_menu_items[ $endpoint_key ] ) ) {
					$cilla_skyn_account_title = $account_menu_items[ $endpoint_key ];
					break;
				}
			}
		}
	}
	?>
	<section class="wp-theme-account-page bg-cream px-4.5 pb-24 pt-16 font-sans-cs text-cs-ink antialiased min-[481px]:px-6 min-[1081px]:px-[5vw]">
		<div class="mx-auto max-w-[1280px]">
			<h1 class="mb-10 font-serif text-4xl leading-none sm:text-5xl">
				<?php echo esc_html( $cilla_skyn_account_title ); ?>
			</h1>
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
