<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Menu no painel
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

// 2. Registro do grupo de opções
function dvtone_register_theme_settings() {
    register_setting( 'dvtone_theme_options_group', 'dvtone_theme_options', [
        'sanitize_callback' => 'dvtone_sanitize_theme_options',
    ] );
}
add_action( 'admin_init', 'dvtone_register_theme_settings' );

// Sanitização e persistência precisa por aba
function dvtone_sanitize_theme_options( $input ) {
    $existing = get_option( 'dvtone_theme_options', [] );
    $output   = is_array( $existing ) ? $existing : [];
    $active_tab = isset( $_POST['current_tab'] ) ? sanitize_key( $_POST['current_tab'] ) : 'geral';

    if ( 'geral' === $active_tab ) {
        $output['header_btn_text'] = isset( $input['header_btn_text'] ) ? sanitize_text_field( $input['header_btn_text'] ) : '';
        $output['header_btn_url']  = isset( $input['header_btn_url'] ) ? esc_url_raw( $input['header_btn_url'] ) : '';
        $output['footer_text']     = isset( $input['footer_text'] ) ? sanitize_text_field( $input['footer_text'] ) : '';
    } elseif ( 'modulos' === $active_tab ) {
        // Se a aba for modulos e a checkbox não veio no POST, significa que foi desmarcada (0)
        $output['enable_portfolio'] = ! empty( $input['enable_portfolio'] ) ? 1 : 0;
    } elseif ( 'portfolio' === $active_tab ) {
        $output['portfolio_archive_title'] = isset( $input['portfolio_archive_title'] ) ? sanitize_text_field( $input['portfolio_archive_title'] ) : '';
        $output['portfolio_per_page']      = isset( $input['portfolio_per_page'] ) ? absint( $input['portfolio_per_page'] ) : 9;
    }

    return $output;
}

// 3. Renderização da tela
function dvtone_theme_settings_render_page() {
    $options = get_option( 'dvtone_theme_options', [] );
    
    $enable_portfolio   = isset( $options['enable_portfolio'] ) ? (int) $options['enable_portfolio'] : 1;
    $header_btn_text    = isset( $options['header_btn_text'] ) ? $options['header_btn_text'] : 'Fale Conosco';
    $header_btn_url     = isset( $options['header_btn_url'] ) ? $options['header_btn_url'] : '#contato';
    $footer_text        = isset( $options['footer_text'] ) ? $options['footer_text'] : '';
    $portfolio_per_page = isset( $options['portfolio_per_page'] ) ? $options['portfolio_per_page'] : 9;
    $portfolio_title    = isset( $options['portfolio_archive_title'] ) ? $options['portfolio_archive_title'] : 'Nosso Portfólio';

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
            <a href="?page=dvtone-settings&tab=modulos" class="nav-tab <?php echo $active_tab === 'modulos' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Módulos & CPTs', 'dvtone' ); ?>
            </a>
            <?php if ( $enable_portfolio ) : ?>
                <a href="?page=dvtone-settings&tab=portfolio" class="nav-tab <?php echo $active_tab === 'portfolio' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e( 'Portfólio', 'dvtone' ); ?>
                </a>
            <?php endif; ?>
        </h2>

        <form method="post" action="options.php" style="background: #fff; border: 1px solid #ccd0d4; padding: 20px 30px; margin-top: 15px; border-radius: 4px; max-width: 900px;">
            <?php settings_fields( 'dvtone_theme_options_group' ); ?>
            
            <!-- Campo identificador da aba atual para a sanitização -->
            <input type="hidden" name="current_tab" value="<?php echo esc_attr( $active_tab ); ?>">

            <!-- Aba: Geral -->
            <?php if ( 'geral' === $active_tab ) : ?>
                <h3><?php esc_html_e( 'Configurações de Layout Geral', 'dvtone' ); ?></h3>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="header_btn_text"><?php esc_html_e( 'Texto do Botão (Header)', 'dvtone' ); ?></label></th>
                        <td>
                            <input type="text" id="header_btn_text" name="dvtone_theme_options[header_btn_text]" value="<?php echo esc_attr( $header_btn_text ); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="header_btn_url"><?php esc_html_e( 'Link do Botão (Header)', 'dvtone' ); ?></label></th>
                        <td>
                            <input type="url" id="header_btn_url" name="dvtone_theme_options[header_btn_url]" value="<?php echo esc_url( $header_btn_url ); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="footer_text"><?php esc_html_e( 'Texto de Copyright (Footer)', 'dvtone' ); ?></label></th>
                        <td>
                            <input type="text" id="footer_text" name="dvtone_theme_options[footer_text]" value="<?php echo esc_attr( $footer_text ); ?>" class="large-text">
                        </td>
                    </tr>
                </table>

            <!-- Aba: Módulos -->
            <?php elseif ( 'modulos' === $active_tab ) : ?>
                <h3><?php esc_html_e( 'Gerenciamento de Módulos e Custom Post Types', 'dvtone' ); ?></h3>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Módulo de Portfólio', 'dvtone' ); ?></th>
                        <td>
                            <fieldset>
                                <label for="enable_portfolio">
                                    <input type="checkbox" id="enable_portfolio" name="dvtone_theme_options[enable_portfolio]" value="1" <?php checked( 1, $enable_portfolio ); ?>>
                                    <?php esc_html_e( 'Ativar Custom Post Type de Portfólio e sua aba de opções', 'dvtone' ); ?>
                                </label>
                                <p class="description"><?php esc_html_e( 'Ao desativar, o menu lateral do Portfólio e a aba de configurações sumirão do painel.', 'dvtone' ); ?></p>
                            </fieldset>
                        </td>
                    </tr>
                </table>

            <!-- Aba: Portfólio -->
            <?php elseif ( 'portfolio' === $active_tab && $enable_portfolio ) : ?>
                <h3><?php esc_html_e( 'Opções do Módulo de Portfólio', 'dvtone' ); ?></h3>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="portfolio_archive_title"><?php esc_html_e( 'Título da Página de Listagem', 'dvtone' ); ?></label></th>
                        <td>
                            <input type="text" id="portfolio_archive_title" name="dvtone_theme_options[portfolio_archive_title]" value="<?php echo esc_attr( $portfolio_title ); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="portfolio_per_page"><?php esc_html_e( 'Projetos por Página', 'dvtone' ); ?></label></th>
                        <td>
                            <input type="number" id="portfolio_per_page" name="dvtone_theme_options[portfolio_per_page]" value="<?php echo esc_attr( $portfolio_per_page ); ?>" min="1" max="50" class="small-text">
                        </td>
                    </tr>
                </table>
            <?php endif; ?>

            <?php submit_button( __( 'Salvar Alterações', 'dvtone' ) ); ?>
        </form>
    </div>
    <?php
}

// 4. Helper global
function dvtone_get_option( $key, $default = '' ) {
    $options = get_option( 'dvtone_theme_options', [] );
    return ( isset( $options[ $key ] ) && $options[ $key ] !== '' ) ? $options[ $key ] : $default;
}