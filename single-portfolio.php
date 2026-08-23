<?php
get_header();

while ( have_posts() ) : the_post();
    $client_name  = get_post_meta( get_the_ID(), '_dvtone_client_name', true );
    $project_url  = get_post_meta( get_the_ID(), '_dvtone_project_url', true );
    $project_date = get_post_meta( get_the_ID(), '_dvtone_project_date', true );
    $tech_stack   = get_post_meta( get_the_ID(), '_dvtone_tech_stack', true );
    $gallery_ids  = get_post_meta( get_the_ID(), '_dvtone_gallery_ids', true );
    $terms        = get_the_terms( get_the_ID(), 'portfolio_category' );
?>

<main id="primary" class="flex-grow py-12">
    <div class="max-w-site mx-auto px-6">

        <!-- Voltar -->
        <div class="mb-8">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                &larr; Voltar para o portfólio
            </a>
        </div>

        <!-- Cabeçalho -->
        <header class="mb-10">
            <div class="flex flex-wrap gap-2 mb-4">
                <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                    <?php foreach ( $terms as $term ) : ?>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-100">
                            <?php echo esc_html( $term->name ); ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                <?php the_title(); ?>
            </h1>
        </header>

        <!-- Imagem Principal -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-slate-200 aspect-[21/9] bg-slate-100">
                <?php the_post_thumbnail( 'full', [ 'class' => 'w-full h-full object-cover' ] ); ?>
            </div>
        <?php endif; ?>

        <!-- Conteúdo e Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <article class="lg:col-span-8 prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
                <?php the_content(); ?>

                <!-- Galeria de Imagens Adicionais -->
                <?php if ( ! empty( $gallery_ids ) ) : 
                    $images = explode( ',', $gallery_ids );
                ?>
                    <div class="mt-12 pt-8 border-t border-slate-200 not-prose">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Galeria do Projeto</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach ( $images as $image_id ) : 
                                $full_url  = wp_get_attachment_image_url( $image_id, 'full' );
                                $thumb_tag = wp_get_attachment_image( $image_id, 'large', false, [ 'class' => 'w-full h-64 object-cover rounded-xl border border-slate-200 hover:opacity-95 transition shadow-sm' ] );
                            ?>
                                <?php if ( $thumb_tag ) : ?>
                                    <a href="<?php echo esc_url( $full_url ); ?>" target="_blank" class="block overflow-hidden rounded-xl">
                                        <?php echo $thumb_tag; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>

            <!-- Sidebar Metadados -->
            <aside class="lg:col-span-4 sticky top-24">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">
                        Informações do Projeto
                    </h2>

                    <div class="space-y-4 text-sm">
                        <?php if ( ! empty( $client_name ) ) : ?>
                            <div>
                                <span class="block text-slate-400 text-xs font-semibold uppercase tracking-wider">Cliente</span>
                                <span class="text-slate-800 font-medium"><?php echo esc_html( $client_name ); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $project_date ) ) : ?>
                            <div>
                                <span class="block text-slate-400 text-xs font-semibold uppercase tracking-wider">Data / Período</span>
                                <span class="text-slate-800 font-medium"><?php echo esc_html( $project_date ); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $tech_stack ) ) : ?>
                            <div>
                                <span class="block text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Tecnologias</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <?php 
                                    $tags = explode( ',', $tech_stack );
                                    foreach ( $tags as $tag ) : 
                                    ?>
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs rounded border border-slate-200">
                                            <?php echo esc_html( trim( $tag ) ); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $project_url ) ) : ?>
                        <div class="pt-4 border-t border-slate-100">
                            <a href="<?php echo esc_url( $project_url ); ?>" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                                Visitar Projeto Online &nearr;
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>

        </div>

    </div>
</main>

<?php
endwhile;
get_footer();