<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acesso direto ao arquivo
}

function dvt_enqueue_scripts() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // 1. Cabeçalho padrão do tema (style.css na raiz)
    wp_enqueue_style(
        'dvtone-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    // 2. CSS compilado do Tailwind (assets/css/main.css)
    $css_file = $theme_dir . '/assets/css/main.css';
    $css_version = file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0';

    wp_enqueue_style(
        'dvtone-tailwind',
        $theme_uri . '/assets/css/main.css',
        [ 'dvtone-style' ],
        $css_version
    );

    // 3. JS do tema (assets/js/main.js)
    $js_file = $theme_dir . '/assets/js/main.js';
    $js_version = file_exists( $js_file ) ? filemtime( $js_file ) : '1.0.0';

    wp_enqueue_script(
        'dvtone-main-js',
        $theme_uri . '/assets/js/main.js',
        [],
        $js_version,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'dvt_enqueue_scripts' );