<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function dvtone_customize_register( $wp_customize ) {
    // 1. Painel de Opções Gerais
    $wp_customize->add_section( 'dvtone_opcoes_header', [
        'title'    => __( 'Opções do Cabeçalho', 'dvtone' ),
        'priority' => 30,
    ] );

    // Texto do Botão
    $wp_customize->add_setting( 'header_btn_text', [
        'default'           => 'Fale Conosco',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'header_btn_text', [
        'label'    => __( 'Texto do Botão', 'dvtone' ),
        'section'  => 'dvtone_opcoes_header',
        'type'     => 'text',
    ] );

    // Link do Botão
    $wp_customize->add_setting( 'header_btn_url', [
        'default'           => '#contato',
        'sanitize_callback' => 'esc_url_raw',
    ] );
    $wp_customize->add_control( 'header_btn_url', [
        'label'    => __( 'URL do Botão', 'dvtone' ),
        'section'  => 'dvtone_opcoes_header',
        'type'     => 'url',
    ] );

    // 2. Seção do Rodapé
    $wp_customize->add_section( 'dvtone_opcoes_footer', [
        'title'    => __( 'Opções do Rodapé', 'meu-tema' ),
        'priority' => 35,
    ] );

    $wp_customize->add_setting( 'footer_copyright_text', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'footer_copyright_text', [
        'label'       => __( 'Texto Personalizado de Copyright', 'meu-tema' ),
        'description' => __( 'Deixe em branco para usar o padrão.', 'meu-tema' ),
        'section'     => 'dvtone_opcoes_footer',
        'type'        => 'text',
    ] );
}
add_action( 'customize_register', 'dvtone_customize_register' );