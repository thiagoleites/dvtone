<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 1 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="relative w-full bg-slate-950 py-8 lg:py-12">
    <div class="max-w-site mx-auto px-6">
        <div class="swiper dvtone-glass-swiper relative rounded-3xl overflow-hidden shadow-2xl h-[520px] sm:h-[620px] border border-slate-800" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $s ) : ?>
                    <div class="swiper-slide relative flex items-end p-6 sm:p-12 overflow-hidden bg-slate-900">
                        <!-- Imagem de Fundo com Zoom Suave -->
                        <?php if ( ! empty( $s['image'] ) ) : ?>
                            <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <?php endif; ?>

                        <!-- Card Flutuante de Vidro Fosco (Glassmorphism) -->
                        <div class="relative z-10 max-w-2xl bg-white/10 backdrop-blur-md border border-white/20 p-6 sm:p-8 rounded-2xl text-white shadow-lg">
                            <?php if ( ! empty( $s['title'] ) ) : ?>
                                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight drop-shadow-sm">
                                    <?php echo esc_html( $s['title'] ); ?>
                                </h2>
                            <?php endif; ?>

                            <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                                <p class="mt-3 text-sm sm:text-base text-slate-200 leading-relaxed drop-shadow-sm">
                                    <?php echo nl2br( esc_html( $s['subtitle'] ) ); ?>
                                </p>
                            <?php endif; ?>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                                    <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-lg shadow-md transition">
                                        <?php echo esc_html( $s['btn1_text'] ); ?>
                                    </a>
                                <?php endif; ?>
                                <?php if ( ! empty( $s['btn2_text'] ) ) : ?>
                                    <a href="<?php echo esc_url( $s['btn2_url'] ?? '#' ); ?>" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold rounded-lg border border-white/30 transition">
                                        <?php echo esc_html( $s['btn2_text'] ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginação com Barra de Progresso Superior -->
            <div class="swiper-pagination !top-0 !bottom-auto !h-1.5 !bg-white/20 [&_.swiper-pagination-progressbar-fill]:!bg-blue-500"></div>
            
            <!-- Controles Flutuantes no Canto Inferior -->
            <div class="absolute bottom-6 right-6 z-20 flex gap-2">
                <button class="glass-prev w-10 h-10 rounded-full bg-white/20 backdrop-blur border border-white/30 text-white flex items-center justify-center hover:bg-white/40 transition">&larr;</button>
                <button class="glass-next w-10 h-10 rounded-full bg-white/20 backdrop-blur border border-white/30 text-white flex items-center justify-center hover:bg-white/40 transition">&rarr;</button>
            </div>
        </div>
    </div>
</section>