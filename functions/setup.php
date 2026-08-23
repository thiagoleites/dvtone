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