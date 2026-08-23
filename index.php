<?php get_header(); ?>

<main id="primary" class="site-main py-5 flex-grow-1">
    <div class="container" style="max-width: 1400px;">
        
        <header class="mb-5 text-center">
            <h1 class="fw-bold mb-2">Últimos Posts</h1>
            <p class="text-muted">Acompanhe as atualizações e artigos recentes.</p>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="row g-4">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100 border rounded overflow-hidden shadow-sm' ); ?>>
                            
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="d-block ratio ratio-16x9">
                                    <?php the_post_thumbnail( 'medium_large', [ 'class' => 'card-img-top object-fit-cover w-100 h-100' ] ); ?>
                                </a>
                            <?php else : ?>
                                <div class="bg-light border-bottom d-flex align-items-center justify-content-center text-muted" style="height: 180px;">
                                    <span>Sem imagem</span>
                                </div>
                            <?php endif; ?>

                            <div class="card-body p-4 d-flex flex-column">
                                <h2 class="card-title h5 fw-bold mb-2">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="card-text text-muted mb-3 flex-grow-1">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center small text-muted">
                                    <span><?php echo get_the_date(); ?></span>
                                    <a href="<?php the_permalink(); ?>" class="fw-bold text-primary text-decoration-none">Ler mais &rarr;</a>
                                </div>
                            </div>

                        </article>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Paginação Centralizada -->
            <div class="d-flex justify-content-center mt-5">
                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&laquo; Anterior',
                    'next_text' => 'Próximo &raquo;',
                ] );
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-5">
                <p class="lead text-muted">Nenhum post encontrado por aqui.</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>