<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Announcement Bar -->
<div class="relative bg-cream border-b border-cs-ink/10 px-6 py-2 text-center text-[11px] uppercase tracking-[0.22em] text-cs-ink/70 font-sans-cs">
    <span><?php echo esc_html( get_theme_mod( 'cilla_skyn_announcement', __( 'Thoughtfully formulated. Purposefully layered. Inspired by nature.', 'custom-theme' ) ) ); ?></span>
    <span class="absolute right-6 top-1/2 hidden -translate-y-1/2 items-center gap-3 normal-case tracking-normal text-cs-ink/60 md:flex">
        <span><?php esc_html_e( 'Worldwide Shipping', 'custom-theme' ); ?></span>
        <span class="text-cs-ink/30">|</span>
        <span><?php esc_html_e( 'A More Radiant You', 'custom-theme' ); ?></span>
    </span>
</div>

<header id="site-header" class="border-b border-cs-ink/10 bg-cream font-sans-cs text-cs-ink">
    <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-6 px-6 py-4 md:px-10">

        <!-- Logo -->
        <?php $cilla_skyn_logo_id = get_theme_mod( 'custom_logo' ); ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 leading-none no-underline">
            <?php if ( $cilla_skyn_logo_id ) : ?>
                <img src="<?php echo esc_url( wp_get_attachment_image_url( $cilla_skyn_logo_id, 'full' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="h-10 w-auto">
            <?php endif; ?>
            <span>
                <span class="block font-serif text-2xl tracking-[0.15em] md:text-3xl">
                    <?php bloginfo( 'name' ); ?><sup class="align-super text-[10px]">&trade;</sup>
                </span>
                <span class="mt-1 block text-[9px] uppercase tracking-[0.22em] text-cs-ink/60">
                    <?php echo esc_html( get_theme_mod( 'cilla_skyn_tagline', __( 'Skin for a Brighter Tomorrow', 'custom-theme' ) ) ); ?>
                </span>
            </span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden items-center gap-8 text-[13px] tracking-wide text-cs-ink/80 lg:flex" aria-label="<?php esc_attr_e( 'Primary navigation', 'custom-theme' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary_navigation',
                    'container'      => false,
                    'menu_class'     => 'flex items-center gap-8 cilla-skyn-primary-menu',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                )
            );
            ?>
        </nav>

        <!-- Header Actions -->
        <div class="flex items-center gap-5 text-cs-ink">

            <!-- Search -->
            <details class="group relative">
                <summary class="flex cursor-pointer list-none items-center transition hover:opacity-60" aria-label="<?php esc_attr_e( 'Search', 'custom-theme' ); ?>">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3" stroke-linecap="round"/></svg>
                </summary>
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="absolute right-0 top-full z-10 mt-3 flex w-56 gap-1 border border-cs-ink/15 bg-cream p-2 shadow-lg">
                    <label class="sr-only" for="cilla-skyn-search"><?php esc_html_e( 'Search', 'custom-theme' ); ?></label>
                    <input id="cilla-skyn-search" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search…', 'custom-theme' ); ?>" class="min-w-0 flex-1 border border-cs-ink/20 bg-cream px-2 py-1.5 text-sm placeholder:text-cs-ink/40 focus:border-cs-ink focus:outline-none">
                    <button type="submit" class="bg-cs-ink px-3 py-1.5 text-cream transition hover:bg-cs-ink/85" aria-label="<?php esc_attr_e( 'Submit search', 'custom-theme' ); ?>">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3" stroke-linecap="round"/></svg>
                    </button>
                </form>
            </details>

            <!-- Account -->
            <?php $cilla_skyn_account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url(); ?>
            <a href="<?php echo esc_url( $cilla_skyn_account_url ); ?>" aria-label="<?php esc_attr_e( 'Account', 'custom-theme' ); ?>" class="flex items-center transition hover:opacity-60">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke-linecap="round"/></svg>
            </a>

            <!-- Cart -->
            <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
                <?php $cilla_skyn_cart_count = WC()->cart->get_cart_contents_count(); ?>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative flex items-center transition hover:opacity-60" aria-label="<?php echo esc_attr( sprintf( _n( 'View cart (%d item)', 'View cart (%d items)', $cilla_skyn_cart_count, 'custom-theme' ), $cilla_skyn_cart_count ) ); ?>">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 8h12l-1 12H7L6 8z"/><path d="M9 8V6a3 3 0 016 0v2" stroke-linecap="round"/></svg>
                    <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-cs-ink text-[9px] text-cream"><?php echo esc_html( $cilla_skyn_cart_count > 99 ? '99+' : $cilla_skyn_cart_count ); ?></span>
                </a>
            <?php endif; ?>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="flex items-center lg:hidden" aria-label="<?php esc_attr_e( 'Open menu', 'custom-theme' ); ?>" aria-expanded="false">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Overlay -->
<div id="mobile-overlay" class="fixed inset-0 z-[1998] hidden bg-cs-ink/50 backdrop-blur-sm"></div>

<!-- Mobile Drawer -->
<div id="mobile-drawer" class="fixed right-0 top-0 z-[1999] flex h-dvh w-[min(320px,85vw)] translate-x-full flex-col border-l border-cs-ink/10 bg-cream p-8 pt-20 font-sans-cs text-cs-ink transition-transform duration-300">
    <button id="mobile-close-btn" class="absolute right-5 top-5 flex h-9 w-9 items-center justify-center rounded-full border border-cs-ink/15" aria-label="<?php esc_attr_e( 'Close menu', 'custom-theme' ); ?>">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/></svg>
    </button>

    <nav class="flex flex-1 flex-col gap-1 overflow-y-auto text-sm tracking-wide" aria-label="<?php esc_attr_e( 'Mobile navigation', 'custom-theme' ); ?>">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary_navigation',
                'container'      => false,
                'menu_class'     => 'cilla-skyn-mobile-nav flex flex-col',
                'fallback_cb'    => false,
                'depth'          => 1,
            )
        );
        ?>
    </nav>
</div>
