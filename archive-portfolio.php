<?php
get_header();

$archive_title = dvtone_get_option( 'portfolio_archive_title', 'Nosso Portfólio' );
?>

<main id="primary" class="flex-grow py-12">
    <div class="max-w-site mx-auto px-6">

        <!-- Cabeçalho da Listagem -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                <?php echo wp_kses_post( $archive_title ); ?>
            </h1>
            <p class="mt-3 text-base text-slate-600">Conheça os projetos recentes e soluções que desenvolvemos.</p>
        </div>

        <?php if ( have_posts() ) : ?>
            <!-- Grid de Projetos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ( have_posts() ) : the_post(); 
                    $client_name = get_post_meta( get_the_ID(), '_dvtone_client_name', true );
                    $terms       = get_the_terms( get_the_ID(), 'portfolio_category' );
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'group flex flex-col bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition' ); ?>>
                        
                        <!-- Thumbnail / Imagem -->
                        <div class="aspect-[16/10] w-full overflow-hidden bg-slate-100 relative">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large', [ 'class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300' ] ); ?>
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                    Sem imagem
                                </div>
                            <?php endif; ?>
                            
                            <!-- Categoria Flutuante -->
                            <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                                <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 backdrop-blur text-slate-800 text-xs font-semibold rounded-full shadow-sm">
                                    <?php echo esc_html( $terms[0]->name ); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Detalhes do Card -->
                        <div class="flex flex-col flex-grow p-6">
                            <?php if ( ! empty( $client_name ) ) : ?>
                                <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">
                                    <?php echo esc_html( $client_name ); ?>
                                </span>
                            <?php endif; ?>

                            <h2 class="text-xl font-bold text-slate-900 mb-2 leading-snug">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="text-slate-600 text-sm mb-6 line-clamp-2 flex-grow">
                                <?php the_excerpt(); ?>
                            </div>

                            <div class="pt-4 border-t border-slate-100 mt-auto flex items-center justify-between">
                                <a href="<?php the_permalink(); ?>" class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 inline-flex items-center gap-1 transition">
                                    Ver Detalhes &rarr;
                                </a>
                            </div>
                        </div>

                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Paginação -->
            <div class="mt-12 flex justify-center [&_.page-numbers]:px-4 [&_.page-numbers]:py-2 [&_.page-numbers]:border [&_.page-numbers]:border-slate-200 [&_.page-numbers]:rounded-lg [&_.page-numbers]:text-sm [&_.page-numbers]:mx-1 [&_.page-numbers:hover]:border-blue-600 [&_.page-numbers:hover]:text-blue-600 [&_.current]:bg-blue-600 [&_.current]:text-white [&_.current]:border-blue-600">
                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&laquo; Anterior',
                    'next_text' => 'Próximo &raquo;',
                ] );
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-16">
                <p class="text-slate-500 text-base">Nenhum projeto cadastrado no momento.</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();