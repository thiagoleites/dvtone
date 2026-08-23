<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Registro do CPT e Taxonomia
function dvtone_register_portfolio_cpt() {

$options = get_option( 'dvtone_theme_options', [] );
    
    // Se explicitamente configurado como 0 ou falso, não registra
    if ( isset( $options['enable_portfolio'] ) && empty( $options['enable_portfolio'] ) ) {
        return;
    }

    $labels = [
        'name'               => __( 'Portfólio', 'dvtone' ),
        'singular_name'      => __( 'Projeto', 'dvtone' ),
        'add_new'            => __( 'Adicionar Projeto', 'dvtone' ),
        'add_new_item'       => __( 'Adicionar Novo Projeto', 'dvtone' ),
        'edit_item'          => __( 'Editar Projeto', 'dvtone' ),
        'new_item'           => __( 'Novo Projeto', 'dvtone' ),
        'view_item'          => __( 'Ver Projeto', 'dvtone' ),
        'search_items'       => __( 'Buscar Projetos', 'dvtone' ),
        'not_found'          => __( 'Nenhum projeto encontrado', 'dvtone' ),
        'not_found_in_trash' => __( 'Nenhum projeto na lixeira', 'dvtone' ),
        'menu_name'          => __( 'Portfólio', 'dvtone' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'rewrite'            => [ 'slug' => 'portfolio' ],
    ];
    register_post_type( 'portfolio', $args );

    $tax_labels = [
        'name'          => __( 'Categorias do Portfólio', 'dvtone' ),
        'singular_name' => __( 'Categoria', 'dvtone' ),
        'menu_name'     => __( 'Categorias', 'dvtone' ),
    ];

    register_taxonomy( 'portfolio_category', [ 'portfolio' ], [
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'portfolio-categoria' ],
    ] );
}
add_action( 'init', 'dvtone_register_portfolio_cpt' );

// 2. Carregar scripts de mídia do WordPress no admin
function dvtone_portfolio_admin_scripts( $hook ) {
    global $post;
    if ( ( 'post-new.php' === $hook || 'post.php' === $hook ) && 'portfolio' === $post->post_type ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'dvtone_portfolio_admin_scripts' );

// 3. Adicionar Meta Boxes
function dvtone_portfolio_add_meta_box() {
    add_meta_box(
        'dvtone_portfolio_details',
        __( 'Detalhes e Galeria do Projeto', 'dvtone' ),
        'dvtone_portfolio_meta_box_html',
        'portfolio',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'dvtone_portfolio_add_meta_box' );

// 4. Renderização do Painel de Metadados e Galeria
function dvtone_portfolio_meta_box_html( $post ) {
    wp_nonce_field( 'dvtone_portfolio_save_meta', 'dvtone_portfolio_nonce' );

    $client_name = get_post_meta( $post->ID, '_dvtone_client_name', true );
    $project_url = get_post_meta( $post->ID, '_dvtone_project_url', true );
    $project_date = get_post_meta( $post->ID, '_dvtone_project_date', true );
    $tech_stack  = get_post_meta( $post->ID, '_dvtone_tech_stack', true );
    $gallery_ids = get_post_meta( $post->ID, '_dvtone_gallery_ids', true );
    ?>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
        <p>
            <label for="dvtone_client_name"><strong><?php esc_html_e( 'Cliente:', 'dvtone' ); ?></strong></label><br>
            <input type="text" id="dvtone_client_name" name="dvtone_client_name" value="<?php echo esc_attr( $client_name ); ?>" class="widefat" placeholder="Ex: Devt Digital">
        </p>
        <p>
            <label for="dvtone_project_url"><strong><?php esc_html_e( 'URL do Projeto:', 'dvtone' ); ?></strong></label><br>
            <input type="url" id="dvtone_project_url" name="dvtone_project_url" value="<?php echo esc_url( $project_url ); ?>" class="widefat" placeholder="https://exemplo.com">
        </p>
        <p>
            <label for="dvtone_project_date"><strong><?php esc_html_e( 'Data / Período:', 'dvtone' ); ?></strong></label><br>
            <input type="text" id="dvtone_project_date" name="dvtone_project_date" value="<?php echo esc_attr( $project_date ); ?>" class="widefat" placeholder="Ex: Agosto 2026">
        </p>
        <p>
            <label for="dvtone_tech_stack"><strong><?php esc_html_e( 'Tecnologias:', 'dvtone' ); ?></strong></label><br>
            <input type="text" id="dvtone_tech_stack" name="dvtone_tech_stack" value="<?php echo esc_attr( $tech_stack ); ?>" class="widefat" placeholder="Ex: WordPress, Tailwind CSS, PHP">
        </p>
    </div>

    <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">

    <div>
        <label><strong><?php esc_html_e( 'Galeria de Imagens do Projeto:', 'dvtone' ); ?></strong></label>
        <input type="hidden" id="dvtone_gallery_ids" name="dvtone_gallery_ids" value="<?php echo esc_attr( $gallery_ids ); ?>">
        
        <div id="dvtone_gallery_container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px;">
            <?php
            if ( ! empty( $gallery_ids ) ) {
                $ids = explode( ',', $gallery_ids );
                foreach ( $ids as $id ) {
                    $img = wp_get_attachment_image_url( $id, 'thumbnail' );
                    if ( $img ) {
                        echo '<div style="position:relative; width:80px; height:80px;" data-id="' . esc_attr( $id ) . '">';
                        echo '<img src="' . esc_url( $img ) . '" style="width:100%; height:100%; object-fit:cover; border-radius:6px; border:1px solid #ccc;" />';
                        echo '<button type="button" class="dvtone-remove-img" style="position:absolute; top:-6px; right:-6px; background:red; color:#fff; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer; font-size:12px; line-height:1;">&times;</button>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>

        <p style="margin-top: 12px;">
            <button type="button" id="dvtone_upload_gallery_btn" class="button button-secondary"><?php esc_html_e( 'Selecionar / Adicionar Imagens à Galeria', 'dvtone' ); ?></button>
            <button type="button" id="dvtone_clear_gallery_btn" class="button" style="margin-left: 8px; color: #a00;"><?php esc_html_e( 'Limpar Galeria', 'dvtone' ); ?></button>
        </p>
    </div>

    <script>
    jQuery(document).ready(function($){
        var frame;
        var galleryInput = $('#dvtone_gallery_ids');
        var galleryContainer = $('#dvtone_gallery_container');

        $('#dvtone_upload_gallery_btn').on('click', function(e){
            e.preventDefault();
            if (frame) { frame.open(); return; }

            frame = wp.media({
                title: 'Selecionar Imagens para o Portfólio',
                button: { text: 'Adicionar à Galeria' },
                multiple: true
            });

            frame.on('select', function(){
                var selection = frame.state().get('selection');
                var currentIds = galleryInput.val() ? galleryInput.val().split(',') : [];

                selection.map(function(attachment){
                    attachment = attachment.toJSON();
                    if (!currentIds.includes(attachment.id.toString())) {
                        currentIds.push(attachment.id);
                        var thumbUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                        galleryContainer.append(
                            '<div style="position:relative; width:80px; height:80px;" data-id="' + attachment.id + '">' +
                            '<img src="' + thumbUrl + '" style="width:100%; height:100%; object-fit:cover; border-radius:6px; border:1px solid #ccc;" />' +
                            '<button type="button" class="dvtone-remove-img" style="position:absolute; top:-6px; right:-6px; background:red; color:#fff; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer; font-size:12px; line-height:1;">&times;</button>' +
                            '</div>'
                        );
                    }
                });
                galleryInput.val(currentIds.join(','));
            });

            frame.open();
        });

        galleryContainer.on('click', '.dvtone-remove-img', function(){
            var parent = $(this).parent();
            var removeId = parent.data('id').toString();
            var currentIds = galleryInput.val().split(',').filter(function(id){ return id !== removeId; });
            galleryInput.val(currentIds.join(','));
            parent.remove();
        });

        $('#dvtone_clear_gallery_btn').on('click', function(){
            galleryInput.val('');
            galleryContainer.empty();
        });
    });
    </script>
    <?php
}

// 5. Salvar Metadados e Galeria
function dvtone_portfolio_save_meta( $post_id ) {
    if ( ! isset( $_POST['dvtone_portfolio_nonce'] ) || ! wp_verify_nonce( $_POST['dvtone_portfolio_nonce'], 'dvtone_portfolio_save_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['dvtone_client_name'] ) ) {
        update_post_meta( $post_id, '_dvtone_client_name', sanitize_text_field( $_POST['dvtone_client_name'] ) );
    }
    if ( isset( $_POST['dvtone_project_url'] ) ) {
        update_post_meta( $post_id, '_dvtone_project_url', esc_url_raw( $_POST['dvtone_project_url'] ) );
    }
    if ( isset( $_POST['dvtone_project_date'] ) ) {
        update_post_meta( $post_id, '_dvtone_project_date', sanitize_text_field( $_POST['dvtone_project_date'] ) );
    }
    if ( isset( $_POST['dvtone_tech_stack'] ) ) {
        update_post_meta( $post_id, '_dvtone_tech_stack', sanitize_text_field( $_POST['dvtone_tech_stack'] ) );
    }
    if ( isset( $_POST['dvtone_gallery_ids'] ) ) {
        update_post_meta( $post_id, '_dvtone_gallery_ids', sanitize_text_field( $_POST['dvtone_gallery_ids'] ) );
    }
}
add_action( 'save_post_portfolio', 'dvtone_portfolio_save_meta' );