<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header"
        class="fixed top-0 left-0 w-full h-20 z-[999] grid grid-cols-[auto_1fr_auto] items-center px-[5vw] transition-all duration-300
               bg-[#0A0A0A]/75 border-b border-white/7 backdrop-blur-[24px] saturate-[1.4]">
    
    <!-- Logo -->
    <?php
    $iga_header_logo_id  = get_theme_mod( 'custom_logo' );
    $iga_header_logo_url = $iga_header_logo_id
        ? wp_get_attachment_image_url( $iga_header_logo_id, 'full' )
        : get_template_directory_uri() . '/assets/images/logo.png';
    ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-[14px] pr-10 border-r border-white/7 no-underline transition-opacity hover:opacity-85">
        <img src="<?php echo esc_url( $iga_header_logo_url ); ?>"
             alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">

        <div class="font-['Bebas_Neue'] text-[1.55rem] tracking-[2px] text-white uppercase leading-none">
            Iron <span class="text-[#4E9E5A]">Gorilla</span> Army
        </div>
    </a>

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex items-center justify-center gap-1.5 px-6">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'container'      => false,
            'menu_class'     => 'flex items-center gap-1.5 primary-menu',
            'menu_id'        => 'primary-menu',
            'fallback_cb'    => false,
            'depth'          => 1,
        ]);
        ?>
        
        <!-- Legends Link -->
        <!-- <a href="<?php echo esc_url(home_url('/league')); ?>" 
           class="relative px-2.5 py-1.5 text-[0.78rem] font-bold uppercase tracking-[1.2px] text-[#C47B2B] hover:text-[#D4893A] transition-all">
            Legends
        </a> -->
    </nav>

    <!-- Header Actions -->
    <div class="flex items-center gap-2 pl-8 border-l border-white/7 md:pl-8">
        
        <!-- Desktop Book Button -->
        <a href="<?php echo esc_url( home_url( '/book/' ) ); ?>"
           class="hidden md:flex items-center gap-2 px-5 py-[10px] text-[0.8rem] font-bold uppercase tracking-[1px] rounded-full bg-[#3A7D44] text-white hover:bg-[#4E9E5A] hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(58,125,68,0.3)] transition-all no-underline">
            <i class="fa-regular fa-calendar-check"></i>
            Book Free Assessment
        </a>

        <!-- WhatsApp -->
        <?php $whatsapp = get_theme_mod('iron_gorilla_whatsapp', ''); ?>

        <?php if ($whatsapp) : ?>

            <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>?text=<?php echo urlencode('Hi Iron Gorilla Army, I want to find out more about joining The Forge.'); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="flex md:hidden items-center justify-center w-[38px] h-[38px] rounded-lg border border-white/14 text-[#25D366] hover:bg-[#25D366]/10 hover:border-[#25D366]/40 transition-all"
            aria-label="Chat on WhatsApp">

                <i class="fa-brands fa-whatsapp text-[1.15rem]"></i>

            </a>

        <?php endif; ?>

        <!-- Cart -->
        <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>

            <?php $iga_header_cart_count = WC()->cart->get_cart_contents_count(); ?>

            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
               class="relative flex items-center justify-center w-[38px] h-[38px] rounded-lg border border-white/14 text-white hover:border-[#4E9E5A] hover:text-[#4E9E5A] hover:bg-[#3A7D44]/10 transition-all"
               aria-label="<?php echo esc_attr( sprintf( _n( 'View cart (%d item)', 'View cart (%d items)', $iga_header_cart_count, 'iga' ), $iga_header_cart_count ) ); ?>">

                <i class="fa-solid fa-cart-shopping text-[0.95rem]"></i>

                <?php if ( $iga_header_cart_count > 0 ) : ?>
                    <span class="absolute -top-1.5 -right-1.5 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-[#3A7D44] px-1 text-[10px] font-bold leading-none text-white">
                        <?php echo esc_html( $iga_header_cart_count > 99 ? '99+' : $iga_header_cart_count ); ?>
                    </span>
                <?php endif; ?>

            </a>

        <?php endif; ?>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn"
                class="md:hidden flex items-center justify-center w-[38px] h-[38px] rounded-lg border border-white/14 text-white hover:border-[#4E9E5A] hover:text-[#4E9E5A] hover:bg-[#3A7D44]/10 transition-all"
                aria-label="Open menu" aria-expanded="false">
            <i class="fa-solid fa-bars text-[0.9rem]"></i>
        </button>
    </div>
</header>

<!-- Mobile Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[1998] hidden md:hidden"></div>

<!-- Mobile Drawer -->
<div id="mobile-drawer"
     class="fixed top-0 right-0 w-[min(320px,85vw)] h-dvh bg-[#141414] z-[1999] p-9 pt-20 flex flex-col border-l border-white/7 transition-transform duration-300 translate-x-full md:hidden">
    
    <button id="mobile-close-btn"
            class="absolute top-5 right-5 w-9 h-9 flex items-center justify-center rounded-full bg-[#242424] border border-white/7 text-[#888888] hover:text-white">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <nav class="flex flex-col flex-1 overflow-y-auto">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'container'      => false,
            'menu_class'     => 'mobile-nav flex flex-col',
            'fallback_cb'    => false,
            'depth'          => 1,
        ]);
        ?>
        
        <!-- <a href="<?php echo esc_url(home_url('/league')); ?>" 
           class="font-['Bebas_Neue'] text-[1.55rem] tracking-[2px] py-[9px] border-b border-white/7 text-[#C47B2B] hover:text-[#D4893A] hover:pl-2 transition-all">
            Legends
        </a> -->
    </nav>

    <div class="flex flex-col gap-2.5 mt-4 pt-4 border-t border-white/7">
        <a href="<?php echo esc_url( home_url( '/book/' ) ); ?>"
           class="flex items-center justify-center gap-2 px-5 py-4 text-[0.78rem] font-bold uppercase tracking-[0.5px] rounded-full bg-[#3A7D44] text-white no-underline">
            <i class="fa-regular fa-calendar-check"></i> Book Free Assessment
        </a>
        
        <button onclick="document.getElementById('packages-modal').classList.add('open'); closeMobileMenu();"
                class="flex items-center justify-center gap-2 px-5 py-4 text-[0.78rem] font-bold uppercase tracking-[0.5px] rounded-full border border-white/14 text-[#F2F2F2] hover:bg-white/5 transition-all">
            <i class="fa-solid fa-medal"></i> View Memberships
        </button>
    </div>
</div>