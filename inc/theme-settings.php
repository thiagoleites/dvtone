<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function dvtone_add_theme_settings_menu() {
    add_menu_page(
        __( 'Opções DVT One', 'dvtone' ),
        __( 'DVT One Opções', 'dvtone' ),
        'manage_options',
        'dvtone-settings',
        'dvtone_theme_settings_render_page',
        'dashicons-admin-generic',
        59
    );
}
add_action( 'admin_menu', 'dvtone_add_theme_settings_menu' );

function dvtone_admin_theme_settings_scripts( $hook ) {
    if ( strpos( $hook, 'dvtone-settings' ) !== false ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'dvtone_admin_theme_settings_scripts' );

function dvtone_register_theme_settings() {
    register_setting( 'dvtone_theme_options_group', 'dvtone_theme_options', [
        'sanitize_callback' => 'dvtone_sanitize_theme_options',
    ] );
}
add_action( 'admin_init', 'dvtone_register_theme_settings' );

function dvtone_sanitize_theme_options( $input ) {
    $existing   = get_option( 'dvtone_theme_options', [] );
    $output     = is_array( $existing ) ? $existing : [];
    $active_tab = isset( $_POST['current_tab'] ) ? sanitize_key( $_POST['current_tab'] ) : 'geral';

    if ( 'geral' === $active_tab ) {
        $output['header_btn_text'] = isset( $input['header_btn_text'] ) ? sanitize_text_field( $input['header_btn_text'] ) : '';
        $output['header_btn_url']  = isset( $input['header_btn_url'] ) ? esc_url_raw( $input['header_btn_url'] ) : '';
        $output['footer_text']     = isset( $input['footer_text'] ) ? sanitize_text_field( $input['footer_text'] ) : '';
    } elseif ( 'banner' === $active_tab ) {
        $output['enable_banner']    = ! empty( $input['enable_banner'] ) ? 1 : 0;
        $output['banner_layout']    = isset( $input['banner_layout'] ) ? sanitize_key( $input['banner_layout'] ) : 'layout-1';
        $output['banner_title']     = isset( $input['banner_title'] ) ? sanitize_text_field( $input['banner_title'] ) : '';
        $output['banner_subtitle']  = isset( $input['banner_subtitle'] ) ? sanitize_textarea_field( $input['banner_subtitle'] ) : '';
        $output['banner_image']     = isset( $input['banner_image'] ) ? esc_url_raw( $input['banner_image'] ) : '';
        $output['banner_btn1_text'] = isset( $input['banner_btn1_text'] ) ? sanitize_text_field( $input['banner_btn1_text'] ) : '';
        $output['banner_btn1_url']  = isset( $input['banner_btn1_url'] ) ? esc_url_raw( $input['banner_btn1_url'] ) : '';
        $output['banner_btn2_text'] = isset( $input['banner_btn2_text'] ) ? sanitize_text_field( $input['banner_btn2_text'] ) : '';
        $output['banner_btn2_url']  = isset( $input['banner_btn2_url'] ) ? esc_url_raw( $input['banner_btn2_url'] ) : '';
    } elseif ( 'slider' === $active_tab ) {
        $output['enable_slider']  = ! empty( $input['enable_slider'] ) ? 1 : 0;
        $output['slider_layout']  = isset( $input['slider_layout'] ) ? sanitize_key( $input['slider_layout'] ) : 'layout-1';
        $output['slider_autoplay']= ! empty( $input['slider_autoplay'] ) ? 1 : 0;
        
        $slides = [];
        if ( ! empty( $input['slides'] ) && is_array( $input['slides'] ) ) {
            foreach ( $input['slides'] as $slide ) {
                if ( ! empty( $slide['title'] ) || ! empty( $slide['image'] ) ) {
                    $slides[] = [
                        'title'     => sanitize_text_field( $slide['title'] ?? '' ),
                        'subtitle'  => sanitize_textarea_field( $slide['subtitle'] ?? '' ),
                        'image'     => esc_url_raw( $slide['image'] ?? '' ),
                        'btn1_text' => sanitize_text_field( $slide['btn1_text'] ?? '' ),
                        'btn1_url'  => esc_url_raw( $slide['btn1_url'] ?? '' ),
                        'btn2_text' => sanitize_text_field( $slide['btn2_text'] ?? '' ),
                        'btn2_url'  => esc_url_raw( $slide['btn2_url'] ?? '' ),
                    ];
                }
            }
        }
        $output['slides'] = $slides;
    } elseif ( 'modulos' === $active_tab ) {
        $output['enable_portfolio'] = ! empty( $input['enable_portfolio'] ) ? 1 : 0;
    } elseif ( 'portfolio' === $active_tab ) {
        $output['portfolio_archive_title'] = isset( $input['portfolio_archive_title'] ) ? sanitize_text_field( $input['portfolio_archive_title'] ) : '';
        $output['portfolio_per_page']      = isset( $input['portfolio_per_page'] ) ? absint( $input['portfolio_per_page'] ) : 9;
    }

    return $output;
}

function dvtone_theme_settings_render_page() {
    $options = get_option( 'dvtone_theme_options', [] );
    
    // Geral
    $header_btn_text    = isset( $options['header_btn_text'] ) ? $options['header_btn_text'] : 'Fale Conosco';
    $header_btn_url     = isset( $options['header_btn_url'] ) ? $options['header_btn_url'] : '#contato';
    $footer_text        = isset( $options['footer_text'] ) ? $options['footer_text'] : '';

    // CPT Portfolio
    $enable_portfolio   = isset( $options['enable_portfolio'] ) ? (int) $options['enable_portfolio'] : 1;
    $portfolio_per_page = isset( $options['portfolio_per_page'] ) ? $options['portfolio_per_page'] : 9;
    $portfolio_title    = isset( $options['portfolio_archive_title'] ) ? $options['portfolio_archive_title'] : 'Nosso Portfólio';

    // Banner
    $enable_banner      = isset( $options['enable_banner'] ) ? (int) $options['enable_banner'] : 1;
    $banner_layout      = isset( $options['banner_layout'] ) ? $options['banner_layout'] : 'layout-1';
    $banner_title       = isset( $options['banner_title'] ) ? $options['banner_title'] : 'Construa Projetos Incríveis com DVT One';
    $banner_subtitle    = isset( $options['banner_subtitle'] ) ? $options['banner_subtitle'] : 'Desenvolvimento ágil, moderno e sob medida com Tailwind CSS.';
    $banner_image       = isset( $options['banner_image'] ) ? $options['banner_image'] : '';
    $banner_btn1_text   = isset( $options['banner_btn1_text'] ) ? $options['banner_btn1_text'] : 'Começar Agora';
    $banner_btn1_url    = isset( $options['banner_btn1_url'] ) ? $options['banner_btn1_url'] : '#contato';
    $banner_btn2_text   = isset( $options['banner_btn2_text'] ) ? $options['banner_btn2_text'] : 'Ver Portfólio';
    $banner_btn2_url    = isset( $options['banner_btn2_url'] ) ? $options['banner_btn2_url'] : '#portfolio';

    // Slider
    $enable_slider      = isset( $options['enable_slider'] ) ? (int) $options['enable_slider'] : 0;
    $slider_layout      = isset( $options['slider_layout'] ) ? $options['slider_layout'] : 'layout-1';
    $slider_autoplay    = isset( $options['slider_autoplay'] ) ? (int) $options['slider_autoplay'] : 1;
    $slides             = isset( $options['slides'] ) && is_array( $options['slides'] ) ? $options['slides'] : [];

    $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'geral';

    if ( 'portfolio' === $active_tab && ! $enable_portfolio ) {
        $active_tab = 'geral';
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Painel de Configurações - Tema DVT One', 'dvtone' ); ?></h1>
        
        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=dvtone-settings&tab=geral" class="nav-tab <?php echo $active_tab === 'geral' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Geral & Layout', 'dvtone' ); ?>
            </a>
            <a href="?page=dvtone-settings&tab=banner" class="nav-tab <?php echo $active_tab === 'banner' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Banner Fixo', 'dvtone' ); ?>
            </a>
            <a href="?page=dvtone-settings&tab=slider" class="nav-tab <?php echo $active_tab === 'slider' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Sliders (Carrossel)', 'dvtone' ); ?>
            </a>
            <a href="?page=dvtone-settings&tab=modulos" class="nav-tab <?php echo $active_tab === 'modulos' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Módulos & CPTs', 'dvtone' ); ?>
            </a>
            <?php if ( $enable_portfolio ) : ?>
                <a href="?page=dvtone-settings&tab=portfolio" class="nav-tab <?php echo $active_tab === 'portfolio' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e( 'Portfólio', 'dvtone' ); ?>
                </a>
            <?php endif; ?>
        </h2>

        <form method="post" action="options.php" style="background: #fff; border: 1px solid #ccd0d4; padding: 20px 30px; margin-top: 15px; border-radius: 4px; max-width: 960px;">
            <?php settings_fields( 'dvtone_theme_options_group' ); ?>
            <input type="hidden" name="current_tab" value="<?php echo esc_attr( $active_tab ); ?>">

            <!-- Aba: Geral -->
            <?php if ( 'geral' === $active_tab ) : ?>
                <h3><?php esc_html_e( 'Configurações de Layout Geral', 'dvtone' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="header_btn_text"><?php esc_html_e( 'Texto do Botão (Header)', 'dvtone' ); ?></label></th>
                        <td><input type="text" id="header_btn_text" name="dvtone_theme_options[header_btn_text]" value="<?php echo esc_attr( $header_btn_text ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="header_btn_url"><?php esc_html_e( 'Link do Botão (Header)', 'dvtone' ); ?></label></th>
                        <td><input type="url" id="header_btn_url" name="dvtone_theme_options[header_btn_url]" value="<?php echo esc_url( $header_btn_url ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="footer_text"><?php esc_html_e( 'Texto de Copyright (Footer)', 'dvtone' ); ?></label></th>
                        <td><input type="text" id="footer_text" name="dvtone_theme_options[footer_text]" value="<?php echo esc_attr( $footer_text ); ?>" class="large-text"></td>
                    </tr>
                </table>

            <!-- Aba: Banner Fixo -->
            <?php elseif ( 'banner' === $active_tab ) : ?>
                <h3><?php esc_html_e( 'Gerenciador do Banner Fixo', 'dvtone' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Exibir Banner', 'dvtone' ); ?></th>
                        <td>
                            <label for="enable_banner">
                                <input type="checkbox" id="enable_banner" name="dvtone_theme_options[enable_banner]" value="1" <?php checked( 1, $enable_banner ); ?>>
                                <?php esc_html_e( 'Ativar exibição do banner estático', 'dvtone' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="banner_layout"><?php esc_html_e( 'Modelo de Banner', 'dvtone' ); ?></label></th>
                        <td>
                            <select id="banner_layout" name="dvtone_theme_options[banner_layout]">
                                <option value="layout-1" <?php selected( 'layout-1', $banner_layout ); ?>><?php esc_html_e( 'Modelo 1 - Split (Texto + Imagem)', 'dvtone' ); ?></option>
                                <option value="layout-2" <?php selected( 'layout-2', $banner_layout ); ?>><?php esc_html_e( 'Modelo 2 - Centralizado', 'dvtone' ); ?></option>
                                <option value="layout-3" <?php selected( 'layout-3', $banner_layout ); ?>><?php esc_html_e( 'Modelo 3 - Full Cover Escuro', 'dvtone' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="banner_title"><?php esc_html_e( 'Título', 'dvtone' ); ?></label></th>
                        <td><input type="text" id="banner_title" name="dvtone_theme_options[banner_title]" value="<?php echo esc_attr( $banner_title ); ?>" class="large-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="banner_subtitle"><?php esc_html_e( 'Subtítulo', 'dvtone' ); ?></label></th>
                        <td><textarea id="banner_subtitle" name="dvtone_theme_options[banner_subtitle]" rows="3" class="large-text"><?php echo esc_textarea( $banner_subtitle ); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Imagem do Banner', 'dvtone' ); ?></th>
                        <td>
                            <input type="text" id="banner_image_input" name="dvtone_theme_options[banner_image]" value="<?php echo esc_url( $banner_image ); ?>" class="regular-text">
                            <button type="button" id="dvtone_upload_banner_btn" class="button"><?php esc_html_e( 'Selecionar Imagem', 'dvtone' ); ?></button>
                            <div id="banner_image_preview" style="margin-top: 10px;">
                                <?php if ( ! empty( $banner_image ) ) : ?><img src="<?php echo esc_url( $banner_image ); ?>" style="max-height: 100px; border-radius: 6px;"><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Botão 1 (Principal)', 'dvtone' ); ?></th>
                        <td>
                            <input type="text" name="dvtone_theme_options[banner_btn1_text]" value="<?php echo esc_attr( $banner_btn1_text ); ?>" placeholder="Texto" class="regular-text">
                            <input type="url" name="dvtone_theme_options[banner_btn1_url]" value="<?php echo esc_url( $banner_btn1_url ); ?>" placeholder="URL" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Botão 2 (Opcional)', 'dvtone' ); ?></th>
                        <td>
                            <input type="text" name="dvtone_theme_options[banner_btn2_text]" value="<?php echo esc_attr( $banner_btn2_text ); ?>" placeholder="Texto" class="regular-text">
                            <input type="url" name="dvtone_theme_options[banner_btn2_url]" value="<?php echo esc_url( $banner_btn2_url ); ?>" placeholder="URL" class="regular-text">
                        </td>
                    </tr>
                </table>

            <!-- Aba: Sliders Dinâmicos -->
            <?php elseif ( 'slider' === $active_tab ) : ?>
                <h3><?php esc_html_e( 'Gerenciador de Sliders & Carrossel', 'dvtone' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Ativar Slider', 'dvtone' ); ?></th>
                        <td>
                            <label for="enable_slider">
                                <input type="checkbox" id="enable_slider" name="dvtone_theme_options[enable_slider]" value="1" <?php checked( 1, $enable_slider ); ?>>
                                <?php esc_html_e( 'Exibir carrossel de slides na página inicial', 'dvtone' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="slider_layout"><?php esc_html_e( 'Modelo de Slider', 'dvtone' ); ?></label></th>
                        <td>
                            <select id="slider_layout" name="dvtone_theme_options[slider_layout]">
                                <option value="layout-1" <?php selected( 'layout-1', $slider_layout ); ?>><?php esc_html_e( 'Modelo 1 - Full Hero Slider (Transição Suave / Fundo Total)', 'dvtone' ); ?></option>
                                <option value="layout-2" <?php selected( 'layout-2', $slider_layout ); ?>><?php esc_html_e( 'Modelo 2 - Split Slider (Texto à Esquerda + Card Visual à Direita)', 'dvtone' ); ?></option>
                                <option value="layout-3" <?php selected( 'layout-3', $slider_layout ); ?>><?php esc_html_e( 'Modelo 3 - Multi-Cards Carousel (Vários Slides em Carrossel)', 'dvtone' ); ?></option>
                                <option value="layout-4" <?php selected( 'layout-4', $slider_layout ); ?>><?php esc_html_e( 'Modelo 4 - Glassmorphism & Barra de Progresso', 'dvtone' ); ?></option>
                                <option value="layout-5" <?php selected( 'layout-5', $slider_layout ); ?>><?php esc_html_e( 'Modelo 5 - Editorial Split (Transição Vertical)', 'dvtone' ); ?></option>
                                <option value="layout-6" <?php selected( 'layout-6', $slider_layout ); ?>><?php esc_html_e( 'Modelo 6 - Vitrine 3D Coverflow Interativo', 'dvtone' ); ?></option>
                                <option value="layout-7" <?php selected( 'layout-7', $slider_layout ); ?>><?php esc_html_e( 'Modelo 7 - Immersive Travel Showcase (Fundo Fullscreen + Mini Cards)', 'dvtone' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Autoplay', 'dvtone' ); ?></th>
                        <td>
                            <label for="slider_autoplay">
                                <input type="checkbox" id="slider_autoplay" name="dvtone_theme_options[slider_autoplay]" value="1" <?php checked( 1, $slider_autoplay ); ?>>
                                <?php esc_html_e( 'Transição automática de slides (5 segundos)', 'dvtone' ); ?>
                            </label>
                        </td>
                    </tr>
                </table>

                <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

                <h4><?php esc_html_e( 'Lista de Slides Cadastrados', 'dvtone' ); ?></h4>
                <div id="slides-container" style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px;">
                    <?php if ( ! empty( $slides ) ) : ?>
                        <?php foreach ( $slides as $i => $s ) : ?>
                            <div class="slide-item" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 16px; position: relative;">
                                <button type="button" class="button remove-slide-btn" style="position: absolute; top: 12px; right: 12px; color: #dc2626;">&times; Remover Slide</button>
                                <h4 style="margin: 0 0 12px 0;">Slide #<span class="slide-index"><?php echo $i + 1; ?></span></h4>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                    <p>
                                        <label><strong>Título do Slide:</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][<?php echo $i; ?>][title]" value="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="widefat">
                                    </p>
                                    <p>
                                        <label><strong>Imagem URL:</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][<?php echo $i; ?>][image]" value="<?php echo esc_url( $s['image'] ?? '' ); ?>" class="widefat slide-img-input">
                                        <button type="button" class="button button-small select-slide-img" style="margin-top:4px;">Upload Imagem</button>
                                    </p>
                                </div>
                                <p>
                                    <label><strong>Subtítulo / Descrição:</strong></label><br>
                                    <textarea name="dvtone_theme_options[slides][<?php echo $i; ?>][subtitle]" rows="2" class="widefat"><?php echo esc_textarea( $s['subtitle'] ?? '' ); ?></textarea>
                                </p>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                    <p>
                                        <label><strong>Botão 1 (Texto / URL):</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][<?php echo $i; ?>][btn1_text]" value="<?php echo esc_attr( $s['btn1_text'] ?? '' ); ?>" placeholder="Texto Botão 1" style="width:48%;">
                                        <input type="url" name="dvtone_theme_options[slides][<?php echo $i; ?>][btn1_url]" value="<?php echo esc_url( $s['btn1_url'] ?? '' ); ?>" placeholder="URL" style="width:48%;">
                                    </p>
                                    <p>
                                        <label><strong>Botão 2 (Texto / URL):</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][<?php echo $i; ?>][btn2_text]" value="<?php echo esc_attr( $s['btn2_text'] ?? '' ); ?>" placeholder="Texto Botão 2" style="width:48%;">
                                        <input type="url" name="dvtone_theme_options[slides][<?php echo $i; ?>][btn2_url]" value="<?php echo esc_url( $s['btn2_url'] ?? '' ); ?>" placeholder="URL" style="width:48%;">
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <button type="button" id="add-new-slide-btn" class="button button-secondary">+ Adicionar Novo Slide</button>

                <script>
                jQuery(document).ready(function($){
                    // Adicionar Slide
                    $('#add-new-slide-btn').on('click', function(){
                        var index = $('#slides-container .slide-item').length;
                        var tpl = `
                            <div class="slide-item" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 16px; position: relative;">
                                <button type="button" class="button remove-slide-btn" style="position: absolute; top: 12px; right: 12px; color: #dc2626;">&times; Remover Slide</button>
                                <h4 style="margin: 0 0 12px 0;">Slide #<span class="slide-index">${index + 1}</span></h4>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                    <p>
                                        <label><strong>Título do Slide:</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][${index}][title]" class="widefat" placeholder="Ex: Grande Lançamento">
                                    </p>
                                    <p>
                                        <label><strong>Imagem URL:</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][${index}][image]" class="widefat slide-img-input">
                                        <button type="button" class="button button-small select-slide-img" style="margin-top:4px;">Upload Imagem</button>
                                    </p>
                                </div>
                                <p>
                                    <label><strong>Subtítulo / Descrição:</strong></label><br>
                                    <textarea name="dvtone_theme_options[slides][${index}][subtitle]" rows="2" class="widefat" placeholder="Descrição do slide..."></textarea>
                                </p>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                    <p>
                                        <label><strong>Botão 1 (Texto / URL):</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][${index}][btn1_text]" placeholder="Texto Botão 1" style="width:48%;">
                                        <input type="url" name="dvtone_theme_options[slides][${index}][btn1_url]" placeholder="URL" style="width:48%;">
                                    </p>
                                    <p>
                                        <label><strong>Botão 2 (Texto / URL):</strong></label><br>
                                        <input type="text" name="dvtone_theme_options[slides][${index}][btn2_text]" placeholder="Texto Botão 2" style="width:48%;">
                                        <input type="url" name="dvtone_theme_options[slides][${index}][btn2_url]" placeholder="URL" style="width:48%;">
                                    </p>
                                </div>
                            </div>
                        `;
                        $('#slides-container').append(tpl);
                    });

                    // Remover Slide
                    $(document).on('click', '.remove-slide-btn', function(){
                        $(this).closest('.slide-item').remove();
                    });

                    // Upload Imagem de Slide
                    $(document).on('click', '.select-slide-img', function(e){
                        e.preventDefault();
                        var btn = $(this);
                        var input = btn.siblings('.slide-img-input');
                        var frame = wp.media({
                            title: 'Selecionar Imagem do Slide',
                            button: { text: 'Usar Imagem' },
                            multiple: false
                        });
                        frame.on('select', function(){
                            var attachment = frame.state().get('selection').first().toJSON();
                            input.val(attachment.url);
                        });
                        frame.open();
                    });
                });
                </script>

            <!-- Aba: Módulos -->
            <?php elseif ( 'modulos' === $active_tab ) : ?>
                <h3><?php esc_html_e( 'Gerenciamento de Módulos e Custom Post Types', 'dvtone' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Módulo de Portfólio', 'dvtone' ); ?></th>
                        <td>
                            <label for="enable_portfolio">
                                <input type="checkbox" id="enable_portfolio" name="dvtone_theme_options[enable_portfolio]" value="1" <?php checked( 1, $enable_portfolio ); ?>>
                                <?php esc_html_e( 'Ativar Custom Post Type de Portfólio e sua aba de opções', 'dvtone' ); ?>
                            </label>
                        </td>
                    </tr>
                </table>

            <!-- Aba: Portfólio -->
            <?php elseif ( 'portfolio' === $active_tab && $enable_portfolio ) : ?>
                <h3><?php esc_html_e( 'Opções do Módulo de Portfólio', 'dvtone' ); ?></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="portfolio_archive_title"><?php esc_html_e( 'Título da Página de Listagem', 'dvtone' ); ?></label></th>
                        <td><input type="text" id="portfolio_archive_title" name="dvtone_theme_options[portfolio_archive_title]" value="<?php echo esc_attr( $portfolio_title ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="portfolio_per_page"><?php esc_html_e( 'Projetos por Página', 'dvtone' ); ?></label></th>
                        <td><input type="number" id="portfolio_per_page" name="dvtone_theme_options[portfolio_per_page]" value="<?php echo esc_attr( $portfolio_per_page ); ?>" min="1" max="50" class="small-text"></td>
                    </tr>
                </table>
            <?php endif; ?>

            <?php submit_button( __( 'Salvar Alterações', 'dvtone' ) ); ?>
        </form>
    </div>
    <?php
}

function dvtone_get_option( $key, $default = '' ) {
    $options = get_option( 'dvtone_theme_options', [] );
    return ( isset( $options[ $key ] ) && $options[ $key ] !== '' ) ? $options[ $key ] : $default;
}