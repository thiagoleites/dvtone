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

    // Suporte a menus de navegação
    register_nav_menus( [
        'primary_menu' => __( 'Menu Principal', 'dvtone' ),
        'footer_menu' => __( 'Menu do Rodapé', 'dvtone' ),
    ]);
}

add_action( 'after_setup_theme', 'dvt_theme_setup' );

function dvt_enqueue_scripts() {
    // Enfileira o arquivo CSS principal do tema
    wp_enqueue_style( 'dvt-style', get_stylesheet_uri(), [], '1.0.0' );

    // Enfileira o arquivo JavaScript principal do tema
    wp_enqueue_script( 'dvt-script', get_template_directory_uri() . '/js/main.js', [], '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'dvt_enqueue_scripts' );