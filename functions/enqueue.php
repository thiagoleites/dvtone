<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acesso direto ao arquivo
}

// 1. Scripts e Estilos do Frontend
function dvtone_enqueue_scripts() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // 1.1 Swiper CSS (CDN) para suportar os Sliders
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    // 1.2 Cabeçalho padrão do tema (style.css na raiz)
    wp_enqueue_style(
        'dvtone-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    // 1.3 CSS compilado do Tailwind (assets/css/main.css)
    $css_file = $theme_dir . '/assets/css/main.css';
    $css_version = file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0';

    wp_enqueue_style(
        'dvtone-tailwind',
        $theme_uri . '/assets/css/main.css',
        [ 'dvtone-style', 'swiper-css' ],
        $css_version
    );

    // 1.4 Swiper JS (CDN)
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );

    // 1.5 JS principal do tema (assets/js/main.js)
    $js_file = $theme_dir . '/assets/js/main.js';
    $js_version = file_exists( $js_file ) ? filemtime( $js_file ) : '1.0.0';

    wp_enqueue_script(
        'dvtone-main-js',
        $theme_uri . '/assets/js/main.js',
        [ 'swiper-js' ],
        $js_version,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'dvtone_enqueue_scripts' );


// 2. Scripts do Painel Administrativo (Media Uploader)
function dvtone_admin_enqueue_scripts( $hook ) {
    // Carrega o wp.media na tela de Opções DVT One e no CPT Portfolio
    if ( strpos( $hook, 'dvtone-settings' ) !== false || 'post.php' === $hook || 'post-new.php' === $hook ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'dvtone_admin_enqueue_scripts' );