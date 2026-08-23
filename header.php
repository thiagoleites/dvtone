<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'd-flex flex-column min-vh-100' ); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header py-3 border-bottom bg-white">
    <div class="container d-flex align-items-center justify-content-between" style="max-width: 1400px;">
        
        <!-- Logo em formato de quadro placeholder -->
        <div class="site-branding">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="d-inline-flex align-items-center justify-content-center bg-light border rounded text-decoration-none fw-bold text-dark" style="width: 150px; height: 50px;">
                <?php bloginfo( 'name' ); ?>
            </a>
        </div>

        <!-- Navbar Central -->
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary_menu',
                'menu_class'     => 'nav-menu d-flex gap-4 list-unstyled m-0',
                'container'      => false,
                'fallback_cb'    => false,
            ] );
            ?>
        </nav>

        <!-- Botão à Direita -->
        <div class="header-action">
            <a href="#contato" class="btn btn-primary">Fale Conosco</a>
        </div>

    </div>
</header>