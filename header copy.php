<?php
/**
 * The header for the custom-theme.
 *
 * @package custom-theme
 */

$primary_colour   = get_field( 'primary_colour', 'option' ) ?: '#0057ff';
$secondary_colour = get_field( 'secondary_colour', 'option' ) ?: '#00a6a6';
$base_colour      = get_field( 'base_colour', 'option' ) ?: '#ffffff';
$heading_colour   = get_field( 'heading_colour', 'option' ) ?: '#111827';
$font_colour      = get_field( 'font_colour', 'option' ) ?: '#374151';

$heading_font = get_field( 'heading_font_family', 'option' ) ?: 'Inter';
$body_font    = get_field( 'body_font_family', 'option' ) ?: 'Inter';

$site_name = get_bloginfo( 'name' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

	<style>
		:root {
			--color-primary: <?php echo esc_attr( $primary_colour ); ?>;
			--color-secondary: <?php echo esc_attr( $secondary_colour ); ?>;
			--color-base: <?php echo esc_attr( $base_colour ); ?>;
			--color-heading: <?php echo esc_attr( $heading_colour ); ?>;
			--color-font: <?php echo esc_attr( $font_colour ); ?>;

			--font-heading: "<?php echo esc_attr( $heading_font ); ?>", sans-serif;
			--font-body: "<?php echo esc_attr( $body_font ); ?>", sans-serif;
		}
	</style>
</head>

<body <?php body_class( 'bg-base text-font font-body antialiased' ); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-white focus:px-4 focus:py-2 focus:text-black" href="#main-content">
	<?php esc_html_e( 'Skip to content', 'custom-theme' ); ?>
</a>

<header class="site-header border-b border-gray-200 bg-base">
	<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 lg:px-8">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="font-heading text-xl font-bold text-heading" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php echo esc_html( $site_name ); ?>
				</a>
			<?php endif; ?>
		</div>

		<nav class="hidden items-center gap-8 md:flex" aria-label="<?php esc_attr_e( 'Primary navigation', 'custom-theme' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary_navigation',
					'container'      => false,
					'menu_class'     => 'flex items-center gap-8 text-sm font-medium',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<button
			class="inline-flex items-center justify-center rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-font md:hidden"
			type="button"
			aria-controls="mobile-navigation"
			aria-expanded="false"
			data-mobile-menu-toggle
		>
			<span class="sr-only"><?php esc_html_e( 'Open menu', 'custom-theme' ); ?></span>
			<?php esc_html_e( 'Menu', 'custom-theme' ); ?>
		</button>
	</div>

	<nav id="mobile-navigation" class="hidden border-t border-gray-200 px-4 py-4 md:hidden" aria-label="<?php esc_attr_e( 'Mobile navigation', 'custom-theme' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary_navigation',
				'container'      => false,
				'menu_class'     => 'space-y-4 text-sm font-medium',
				'fallback_cb'    => false,
				'depth'          => 2,
			)
		);
		?>
	</nav>
</header>

<main id="main-content" class="site-main">