<?php
/**
 * Armory — Products block — render template.
 *
 * Queries real WooCommerce products and renders them in a card grid styled
 * to match the theme (mirrors the pricing card treatment). Falls back to a
 * "Coming Soon" panel — matching the Armory hero's amber badge — when no
 * products are published yet.
 *
 * @package Iron_Gorilla
 */

$iga_armory_products_icon = static function ( $name, $classes = 'h-5 w-5' ) {
	$paths = array(
		'clock'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',
		'bell'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.86 17.08a23.85 23.85 0 0 0 5.45-1.31A8.97 8.97 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.97 8.97 0 0 1-2.31 6.02c1.75.58 3.58 1.02 5.45 1.31m5.72 0a24.3 24.3 0 0 1-5.72 0m5.72 0a3 3 0 1 1-5.72 0"/>',
		'arrow'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/>',
		'cart'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.5l.9 4.5m0 0L6.6 15.6a1.5 1.5 0 0 0 1.49 1.4h8.02a1.5 1.5 0 0 0 1.49-1.31l1.15-8.19H4.65M7.5 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm10.5 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>',
	);

	$path = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow'];

	return sprintf(
		'<svg class="%1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">%2$s</svg>',
		esc_attr( $classes ),
		$path
	);
};

$iga_armory_products_section_header = static function ( $eyebrow, $title, $subtitle = '' ) {
	?>
	<div class="mx-auto mb-12 max-w-2xl text-center">
		<div class="mb-4 flex items-center justify-center gap-3">
			<span class="h-px w-10 bg-green"></span>
			<span class="text-xs font-bold uppercase tracking-[0.22em] text-green-l"><?php echo esc_html( $eyebrow ); ?></span>
			<span class="h-px w-10 bg-green"></span>
		</div>
		<h2 class="font-display text-4xl uppercase leading-none tracking-[0.04em] text-white sm:text-5xl">
			<?php echo esc_html( $title ); ?>
		</h2>
		<?php if ( $subtitle ) : ?>
			<p class="mx-auto mt-5 max-w-xl text-sm leading-7 text-white/50"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
	<?php
};

$eyebrow  = get_field( 'eyebrow' ) ?: 'Fresh Stock';
$title    = get_field( 'title' ) ?: 'Shop The Armory';
$subtitle = get_field( 'subtitle' ) ?: 'Apparel and supplements built for training with purpose. New drops added regularly.';

$limit    = (int) ( get_field( 'limit' ) ?: 8 );
$columns  = (string) ( get_field( 'columns' ) ?: '4' );
$orderby  = get_field( 'orderby' ) ?: 'date';
$category = get_field( 'category' );

$cta_label = get_field( 'cta_label' ) ?: 'View All Products';
$cta_url   = get_field( 'cta_url' ) ?: ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '' );

$empty_title      = get_field( 'empty_title' ) ?: 'Online Shop — Coming Soon';
$empty_message    = get_field( 'empty_message' ) ?: 'New gear is being loaded into the Armory. Check back soon, or get early access the moment it drops.';
$empty_cta_label  = get_field( 'empty_cta_label' ) ?: 'Get Early Access';
$empty_cta_url    = add_query_arg( array( 'subject' => 'armory-early-access' ), home_url( '/contact/' ) );

$products = array();

if ( function_exists( 'wc_get_products' ) ) {
	$query_args = array(
		'status'  => 'publish',
		'limit'   => $limit,
		'orderby' => 'price' === $orderby ? 'price' : $orderby,
		'order'   => 'price' === $orderby ? 'ASC' : 'DESC',
	);

	if ( ! empty( $category ) ) {
		$query_args['category'] = array( sanitize_title( $category ) );
	}

	$products = wc_get_products( $query_args );
}

$columns_class = array(
	'2' => 'min-[601px]:grid-cols-2',
	'3' => 'min-[601px]:grid-cols-2 min-[1024px]:grid-cols-3',
	'4' => 'min-[601px]:grid-cols-2 min-[1024px]:grid-cols-3 min-[1281px]:grid-cols-4',
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-theme-armory-products overflow-hidden bg-ink font-sans text-off antialiased',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<section class="px-4.5 py-20 min-[481px]:px-6 min-[1081px]:px-[5vw] min-[1081px]:py-28">
		<div class="mx-auto max-w-[1280px]">
			<?php $iga_armory_products_section_header( $eyebrow, $title, $subtitle ); ?>

			<?php if ( empty( $products ) ) : ?>

				<div class="mx-auto flex max-w-xl flex-col items-center rounded-2xl border border-dashed border-amber/30 bg-amber/5 px-8 py-14 text-center">
					<span class="mb-5 flex h-14 w-14 items-center justify-center rounded-full border border-amber/40 bg-amber/10 text-amber">
						<?php echo $iga_armory_products_icon( 'clock', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<h3 class="font-display text-2xl uppercase tracking-wide text-white"><?php echo esc_html( $empty_title ); ?></h3>
					<p class="mt-3 max-w-sm text-sm leading-7 text-white/50"><?php echo esc_html( $empty_message ); ?></p>
					<a href="<?php echo esc_url( $empty_cta_url ); ?>" class="mt-7 inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-green px-7 py-3 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-green-l hover:shadow-[0_10px_30px_rgba(58,125,68,0.35)]">
						<?php echo $iga_armory_products_icon( 'bell', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo esc_html( $empty_cta_label ); ?>
					</a>
				</div>

			<?php else : ?>

				<div class="grid grid-cols-1 gap-5 <?php echo esc_attr( $columns_class[ $columns ] ?? $columns_class['4'] ); ?>">
					<?php foreach ( $products as $product ) : ?>
						<?php
						// Sets up the $post/$product Loop globals the way WooCommerce's own
						// content-product.php does, so third-party plugins hooking things
						// like woocommerce_product_add_to_cart_text see the right product.
						wc_setup_product_data( $product );
						$image_id  = $product->get_image_id();
						$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : wc_placeholder_img_src( 'medium_large' );
						$in_stock  = $product->is_in_stock();
						$on_sale   = $product->is_on_sale();
						$cats      = wc_get_product_category_list( $product->get_id() );
						?>
						<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-line bg-s1 transition duration-300 hover:-translate-y-1 hover:border-green/50">

							<?php if ( $on_sale || ! $in_stock ) : ?>
								<span class="absolute left-3 top-3 z-10 rounded-full px-3 py-1 text-[9px] font-bold uppercase tracking-[0.14em] <?php echo $in_stock ? 'bg-green text-white' : 'bg-white/10 text-white/60'; ?>">
									<?php echo $in_stock ? esc_html__( 'Sale', 'iga' ) : esc_html__( 'Out of Stock', 'iga' ); ?>
								</span>
							<?php endif; ?>

							<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="relative block aspect-square overflow-hidden bg-s2">
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $product->get_name() ); ?>"
									class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
									loading="lazy"
								>
							</a>

							<div class="flex flex-1 flex-col p-5">
								<?php if ( $cats ) : ?>
									<div class="mb-1.5 text-[0.62rem] font-bold uppercase tracking-[0.18em] text-green-l"><?php echo wp_kses_post( $cats ); ?></div>
								<?php endif; ?>

								<h3 class="font-display text-xl uppercase tracking-wide text-white">
									<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="hover:text-green-l">
										<?php echo esc_html( $product->get_name() ); ?>
									</a>
								</h3>

								<div class="mt-2 text-sm text-white/70"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>

								<a
									href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
									class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full border px-5 py-3 text-[0.75rem] font-bold uppercase tracking-[0.1em] transition <?php echo $in_stock ? 'border-transparent bg-green text-white hover:bg-green-l' : 'pointer-events-none border-line-strong bg-transparent text-white/30'; ?>"
								>
									<?php echo $iga_armory_products_icon( 'cart', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php echo esc_html( $product->add_to_cart_text() ); ?>
								</a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<?php wp_reset_postdata(); ?>

				<?php if ( $cta_url ) : ?>
					<div class="mt-12 text-center">
						<a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/15 px-7 py-3 text-xs font-bold uppercase tracking-[0.1em] text-white transition hover:border-white/30 hover:bg-white/5">
							<?php echo esc_html( $cta_label ); ?>
							<?php echo $iga_armory_products_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					</div>
				<?php endif; ?>

			<?php endif; ?>
		</div>
	</section>
</div>
