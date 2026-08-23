<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acesso direto ao arquivo
}

function dvt_theme_setup() {
    // Título dunâmico da tag <title>
    add_theme_support( 'title-tag' );

    // Suporte a imagens destacadas
    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Suporte a menus de navegação
    register_nav_menus( [
        'primary_menu' => __( 'Menu Principal', 'dvtone' ),
        'footer_menu' => __( 'Menu do Rodapé', 'dvtone' ),
    ]);
}

add_action( 'after_setup_theme', 'dvt_theme_setup' );

function dvt_enqueue_scripts() {
// 1. Framework CSS via CDN
    wp_enqueue_style(
        'thiagoleites-framework',
        'https://cdn.jsdelivr.net/gh/thiagoleites/frameworkcss/style.css',
        [],
        null // 'null' evita query strings desnecessárias em URLs de CDN
    );

    // 2. CSS principal do tema
    wp_enqueue_style(
        'dvtone-style',
        get_stylesheet_uri(),
        [ 'thiagoleites-framework' ],
        '1.0.0'
    );

    // 3. CSS customizado adicional/sobrescritas
    wp_enqueue_style(
        'dvtone-custom-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'thiagoleites-framework', 'dvtone' ],
        '1.0.0'
    );

    // 4. JS do tema
    wp_enqueue_script(
        'dvtone-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'dvt_enqueue_scripts' );