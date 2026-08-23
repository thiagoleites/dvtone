<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function dvtone_register_post_types() {
    // Custom Post Type: Projetos
    $labels_projetos = [
        'name'               => __( 'Projetos', 'dvtone' ),
        'singular_name'      => __( 'Projeto', 'dvtone' ),
        'add_new_item'       => __( 'Adicionar Novo Projeto', 'dvtone' ),
        'edit_item'          => __( 'Editar Projeto', 'dvtone' ),
        'all_items'          => __( 'Todos os Projetos', 'dvtone' ),
        'menu_name'          => __( 'Projetos', 'dvtone' ),
    ];

    $args_projetos = [
        'labels'             => $labels_projetos,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_in_rest'       => true, // Habilita o editor Gutenberg e API REST
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'rewrite'            => [ 'slug' => 'projetos' ],
    ];
    register_post_type( 'projeto', $args_projetos );

    // Taxonomia: Categorias de Projetos
    $labels_tax = [
        'name'          => __( 'Categorias de Projetos', 'dvtone' ),
        'singular_name' => __( 'Categoria de Projeto', 'dvtone' ),
    ];

    $args_tax = [
        'labels'            => $labels_tax,
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'categoria-projeto' ],
    ];
    register_taxonomy( 'categoria_projeto', [ 'projeto' ], $args_tax );
}
add_action( 'init', 'dvtone_register_post_types' );