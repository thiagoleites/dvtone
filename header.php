<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'flex flex-col min-h-screen bg-slate-50 text-slate-800 antialiased' ); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="bg-white border-b border-slate-200 py-4 sticky top-0 z-50">
    <div class="max-w-site mx-auto px-6 flex items-center justify-between">
        
        <!-- 1. Logo à Esquerda -->
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center justify-center px-4 h-12 bg-slate-100 border border-slate-300 rounded-lg text-slate-900 font-bold text-base hover:bg-slate-200 transition">
                    <?php bloginfo( 'name' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- 2. Menu no Centro -->
        <nav id="site-navigation" class="hidden md:flex">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary_menu',
                'menu_class'     => 'flex items-center gap-8 text-sm font-medium text-slate-700 hover:[&>li>a]:text-blue-600 [&>li>a]:transition',
                'container'      => false,
                'fallback_cb'    => false,
            ] );
            ?>
        </nav>

        <!-- 3. Botão à Direita (com fallback/Customizer) -->
        <?php 
        $btn_text = get_theme_mod( 'header_btn_text', 'Fale Conosco' );
        $btn_url  = get_theme_mod( 'header_btn_url', '#contato' );
        ?>
        <div class="header-action">
            <a href="<?php echo esc_url( $btn_url ); ?>" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                <?php echo esc_html( $btn_text ); ?>
            </a>
        </div>

    </div>
</header>