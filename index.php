<?php get_header(); ?>

<main id="primary" class="flex-grow py-12">
    <div class="max-w-site mx-auto px-6">
        
        <!-- Título e Subtítulo da Seção -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Últimos Posts</h1>
            <p class="mt-3 text-base text-slate-600">Confira as novidades, artigos e conteúdos recentes.</p>
        </div>

        <?php if ( have_posts() ) : ?>
            <!-- Grid de Posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'flex flex-col bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition' ); ?>>
                        
                        <!-- Thumbnail -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="aspect-video w-full overflow-hidden bg-slate-100 block">
                                <?php the_post_thumbnail( 'medium_large', [ 'class' => 'w-full h-full object-cover hover:scale-105 transition duration-300' ] ); ?>
                            </a>
                        <?php else : ?>
                            <div class="aspect-video w-full bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                                Sem imagem
                            </div>
                        <?php endif; ?>

                        <!-- Conteúdo -->
                        <div class="flex flex-col flex-grow p-6">
                            <h2 class="text-xl font-bold text-slate-900 mb-2 leading-snug">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="text-slate-600 text-sm mb-4 line-clamp-3 flex-grow">
                                <?php the_excerpt(); ?>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <span><?php echo get_the_date(); ?></span>
                                <a href="<?php the_permalink(); ?>" class="font-semibold text-blue-600 hover:text-blue-700">Ler artigo &rarr;</a>
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
                <p class="text-slate-500 text-base">Nenhum post encontrado.</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>