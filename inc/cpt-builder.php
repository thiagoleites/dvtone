<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Cria o submenu "Construtor de CPTs" dentro de Opções DVT One
function dvtone_cpt_builder_menu() {
    add_submenu_page(
        'dvtone-settings',
        __( 'Construtor de CPTs', 'dvtone' ),
        __( 'Criar Novo CPT', 'dvtone' ),
        'manage_options',
        'dvtone-cpt-builder',
        'dvtone_cpt_builder_render_page'
    );
}
add_action( 'admin_menu', 'dvtone_cpt_builder_menu' );

// 2. Processamento do Formulário (Adicionar e Deletar CPTs)
function dvtone_cpt_builder_process_actions() {
    if ( ! isset( $_POST['dvtone_cpt_nonce'] ) || ! wp_verify_nonce( $_POST['dvtone_cpt_nonce'], 'dvtone_cpt_action' ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $cpts = get_option( 'dvtone_dynamic_cpts', [] );

    // Ação: Adicionar novo CPT
    if ( isset( $_POST['action_type'] ) && 'add_cpt' === $_POST['action_type'] ) {
        $slug     = sanitize_key( $_POST['cpt_slug'] );
        $singular = sanitize_text_field( $_POST['cpt_singular'] );
        $plural   = sanitize_text_field( $_POST['cpt_plural'] );
        $icon     = sanitize_text_field( $_POST['cpt_icon'] );

        // Trata os campos personalizados dinâmicos (metaboxes)
        $fields = [];
        if ( ! empty( $_POST['field_keys'] ) && is_array( $_POST['field_keys'] ) ) {
            foreach ( $_POST['field_keys'] as $index => $key ) {
                $clean_key = sanitize_key( $key );
                if ( ! empty( $clean_key ) ) {
                    $fields[] = [
                        'key'   => $clean_key,
                        'label' => sanitize_text_field( $_POST['field_labels'][ $index ] ),
                        'type'  => sanitize_text_field( $_POST['field_types'][ $index ] ),
                    ];
                }
            }
        }

        if ( ! empty( $slug ) && ! empty( $singular ) && ! empty( $plural ) ) {
            $cpts[ $slug ] = [
                'slug'     => $slug,
                'singular' => $singular,
                'plural'   => $plural,
                'icon'     => ! empty( $icon ) ? $icon : 'dashicons-admin-post',
                'fields'   => $fields,
            ];

            update_option( 'dvtone_dynamic_cpts', $cpts );
            flush_rewrite_rules(); // Atualiza regras de URL
            wp_safe_redirect( admin_url( 'admin.php?page=dvtone-cpt-builder&success=added' ) );
            exit;
        }
    }

    // Ação: Deletar CPT
    if ( isset( $_POST['action_type'] ) && 'delete_cpt' === $_POST['action_type'] ) {
        $slug = sanitize_key( $_POST['delete_slug'] );
        if ( isset( $cpts[ $slug ] ) ) {
            unset( $cpts[ $slug ] );
            update_option( 'dvtone_dynamic_cpts', $cpts );
            flush_rewrite_rules();
            wp_safe_redirect( admin_url( 'admin.php?page=dvtone-cpt-builder&success=deleted' ) );
            exit;
        }
    }
}
add_action( 'admin_init', 'dvtone_cpt_builder_process_actions' );

// 3. Renderização da Tela de Gestão e Criação de CPTs
function dvtone_cpt_builder_render_page() {
    $cpts = get_option( 'dvtone_dynamic_cpts', [] );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Construtor de Custom Post Types', 'dvtone' ); ?></h1>
        <p class="description"><?php esc_html_e( 'Crie e gerencie novos tipos de postagens e seus campos customizados sem nenhum plugin.', 'dvtone' ); ?></p>

        <?php if ( isset( $_GET['success'] ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php esc_html_e( 'Alterações salvas com sucesso! As rotas e menus foram atualizados.', 'dvtone' ); ?></p>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px; margin-top: 20px;">
            
            <!-- Formulário de Criação -->
            <div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; border-radius: 6px;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'Novo Custom Post Type', 'dvtone' ); ?></h2>
                
                <form method="post">
                    <?php wp_nonce_field( 'dvtone_cpt_action', 'dvtone_cpt_nonce' ); ?>
                    <input type="hidden" name="action_type" value="add_cpt">

                    <p>
                        <label><strong><?php esc_html_e( 'Slug do Post Type (único, sem espaços):', 'dvtone' ); ?></strong></label><br>
                        <input type="text" name="cpt_slug" required class="widefat" placeholder="ex: servicos, depoimentos, vagas">
                    </p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <p>
                            <label><strong><?php esc_html_e( 'Nome Singular:', 'dvtone' ); ?></strong></label><br>
                            <input type="text" name="cpt_singular" required class="widefat" placeholder="ex: Serviço">
                        </p>
                        <p>
                            <label><strong><?php esc_html_e( 'Nome Plural:', 'dvtone' ); ?></strong></label><br>
                            <input type="text" name="cpt_plural" required class="widefat" placeholder="ex: Serviços">
                        </p>
                    </div>

                    <p>
                        <label><strong><?php esc_html_e( 'Ícone Dashicon:', 'dvtone' ); ?></strong></label><br>
                        <input type="text" name="cpt_icon" value="dashicons-admin-post" class="widefat">
                        <small class="description">Ex: dashicons-hammer, dashicons-testimonial, dashicons-businessperson</small>
                    </p>

                    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

                    <h3><?php esc_html_e( 'Campos Personalizados (Metaboxes)', 'dvtone' ); ?></h3>
                    <div id="cpt_fields_container" style="margin-bottom: 15px;"></div>

                    <button type="button" id="add_field_btn" class="button button-secondary" style="margin-bottom: 20px;">
                        + <?php esc_html_e( 'Adicionar Campo Extra', 'dvtone' ); ?>
                    </button>

                    <div>
                        <button type="submit" class="button button-primary button-large"><?php esc_html_e( 'Criar e Registrar Post Type', 'dvtone' ); ?></button>
                    </div>
                </form>
            </div>

            <!-- Lista de CPTs Atuais -->
            <div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; border-radius: 6px;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'CPTs Ativos Criados', 'dvtone' ); ?></h2>

                <?php if ( empty( $cpts ) ) : ?>
                    <p class="text-muted"><?php esc_html_e( 'Nenhum CPT dinâmico criado ainda.', 'dvtone' ); ?></p>
                <?php else : ?>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php esc_html_e( 'Nome / Slug', 'dvtone' ); ?></th>
                                <th><?php esc_html_e( 'Campos Extras', 'dvtone' ); ?></th>
                                <th><?php esc_html_e( 'Ações', 'dvtone' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $cpts as $slug => $data ) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html( $data['plural'] ); ?></strong><br>
                                        <code><?php echo esc_html( $slug ); ?></code>
                                    </td>
                                    <td>
                                        <?php 
                                        if ( ! empty( $data['fields'] ) ) {
                                            foreach ( $data['fields'] as $f ) {
                                                echo '<span style="display:inline-block; background:#f0f0f1; padding:2px 6px; border-radius:4px; margin:2px; font-size:11px;">' . esc_html( $f['label'] ) . ' (' . esc_html( $f['type'] ) . ')</span> ';
                                            }
                                        } else {
                                            echo '<span class="description">Nenhum</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <form method="post" onsubmit="return confirm('Deseja realmente remover este Custom Post Type?');">
                                            <?php wp_nonce_field( 'dvtone_cpt_action', 'dvtone_cpt_nonce' ); ?>
                                            <input type="hidden" name="action_type" value="delete_cpt">
                                            <input type="hidden" name="delete_slug" value="<?php echo esc_attr( $slug ); ?>">
                                            <button type="submit" class="button button-link-delete"><?php esc_html_e( 'Excluir', 'dvtone' ); ?></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Script para adicionar campos dinamicamente no formulário -->
    <script>
    jQuery(document).ready(function($){
        $('#add_field_btn').on('click', function(){
            var fieldHTML = `
                <div class="cpt-field-row" style="display:grid; grid-template-columns: 1.2fr 1fr 1fr auto; gap: 8px; align-items: center; margin-bottom: 8px; background: #f8f9fa; padding: 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
                    <input type="text" name="field_labels[]" placeholder="Rótulo (ex: Preço)" required class="widefat" />
                    <input type="text" name="field_keys[]" placeholder="slug_campo (ex: preco)" required class="widefat" />
                    <select name="field_types[]" class="widefat">
                        <option value="text">Texto</option>
                        <option value="textarea">Área de Texto</option>
                        <option value="url">URL</option>
                        <option value="number">Número</option>
                    </select>
                    <button type="button" class="button remove-field" style="color:red;">&times;</button>
                </div>
            `;
            $('#cpt_fields_container').append(fieldHTML);
        });

        $(document).on('click', '.remove-field', function(){
            $(this).closest('.cpt-field-row').remove();
        });
    });
    </script>
    <?php
}

// 4. Engine de Registro Dinâmico de CPTs e Metaboxes no WordPress
function dvtone_register_dynamic_cpts() {
    $cpts = get_option( 'dvtone_dynamic_cpts', [] );

    if ( empty( $cpts ) || ! is_array( $cpts ) ) {
        return;
    }

    foreach ( $cpts as $slug => $cpt ) {
        $labels = [
            'name'          => $cpt['plural'],
            'singular_name' => $cpt['singular'],
            'add_new_item'  => sprintf( __( 'Adicionar Novo %s', 'dvtone' ), $cpt['singular'] ),
            'edit_item'     => sprintf( __( 'Editar %s', 'dvtone' ), $cpt['singular'] ),
            'all_items'     => sprintf( __( 'Todos os %s', 'dvtone' ), $cpt['plural'] ),
            'menu_name'     => $cpt['plural'],
        ];

        register_post_type( $slug, [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'menu_icon'          => ! empty( $cpt['icon'] ) ? $cpt['icon'] : 'dashicons-admin-post',
            'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'rewrite'            => [ 'slug' => $slug ],
        ] );
    }
}
add_action( 'init', 'dvtone_register_dynamic_cpts' );

// 5. Adiciona as Metaboxes registradas dinamicamente
function dvtone_dynamic_add_meta_boxes() {
    $cpts = get_option( 'dvtone_dynamic_cpts', [] );

    foreach ( $cpts as $slug => $cpt ) {
        if ( ! empty( $cpt['fields'] ) ) {
            add_meta_box(
                "dvtone_{$slug}_metas",
                sprintf( __( 'Campos Extras de %s', 'dvtone' ), $cpt['singular'] ),
                'dvtone_dynamic_render_metabox',
                $slug,
                'normal',
                'high',
                [ 'fields' => $cpt['fields'] ]
            );
        }
    }
}
add_action( 'add_meta_boxes', 'dvtone_dynamic_add_meta_boxes' );

function dvtone_dynamic_render_metabox( $post, $metabox ) {
    wp_nonce_field( 'dvtone_dynamic_meta_save', 'dvtone_dynamic_meta_nonce' );
    $fields = $metabox['args']['fields'];

    echo '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">';
    foreach ( $fields as $f ) {
        $meta_key = '_dvtone_' . $f['key'];
        $val      = get_post_meta( $post->ID, $meta_key, true );
        
        echo '<p>';
        echo '<label><strong>' . esc_html( $f['label'] ) . ':</strong></label><br>';

        if ( 'textarea' === $f['type'] ) {
            echo '<textarea name="dvtone_meta[' . esc_attr( $meta_key ) . ']" class="widefat" rows="3">' . esc_textarea( $val ) . '</textarea>';
        } elseif ( 'number' === $f['type'] ) {
            echo '<input type="number" name="dvtone_meta[' . esc_attr( $meta_key ) . ']" value="' . esc_attr( $val ) . '" class="widefat" />';
        } elseif ( 'url' === $f['type'] ) {
            echo '<input type="url" name="dvtone_meta[' . esc_attr( $meta_key ) . ']" value="' . esc_url( $val ) . '" class="widefat" />';
        } else {
            echo '<input type="text" name="dvtone_meta[' . esc_attr( $meta_key ) . ']" value="' . esc_attr( $val ) . '" class="widefat" />';
        }

        echo '</p>';
    }
    echo '</div>';
}

// 6. Salva os campos dinâmicos automaticamente
function dvtone_dynamic_save_post_meta( $post_id ) {
    if ( ! isset( $_POST['dvtone_dynamic_meta_nonce'] ) || ! wp_verify_nonce( $_POST['dvtone_dynamic_meta_nonce'], 'dvtone_dynamic_meta_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( ! empty( $_POST['dvtone_meta'] ) && is_array( $_POST['dvtone_meta'] ) ) {
        foreach ( $_POST['dvtone_meta'] as $key => $value ) {
            update_post_meta( $post_id, sanitize_key( $key ), sanitize_text_field( $value ) );
        }
    }
}
add_action( 'save_post', 'dvtone_dynamic_save_post_meta' );