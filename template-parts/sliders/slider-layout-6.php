<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 1 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="py-16 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 text-white overflow-hidden">
    <div class="max-w-site mx-auto px-6 text-center mb-8">
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Galeria em Destaque</h2>
        <p class="mt-2 text-slate-400 text-sm">Arraste para explorar os projetos e novidades em 3D</p>
    </div>

    <div class="swiper dvtone-coverflow-swiper py-8" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
        <div class="swiper-wrapper">
            <?php foreach ( $slides as $s ) : ?>
                <div class="swiper-slide w-[300px] sm:w-[420px] bg-slate-800 rounded-3xl overflow-hidden border border-slate-700 shadow-2xl transition">
                    <div class="aspect-[4/3] w-full bg-slate-950 overflow-hidden relative">
                        <?php if ( ! empty( $s['image'] ) ) : ?>
                            <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="w-full h-full object-cover">
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                    </div>

                    <div class="p-6 text-left">
                        <?php if ( ! empty( $s['title'] ) ) : ?>
                            <h3 class="text-xl font-bold text-white mb-2 leading-snug">
                                <?php echo esc_html( $s['title'] ); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                            <p class="text-sm text-slate-300 line-clamp-2 mb-4 leading-relaxed">
                                <?php echo esc_html( $s['subtitle'] ); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                            <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-lg shadow transition">
                                <?php echo esc_html( $s['btn1_text'] ); ?> &nearr;
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="swiper-pagination mt-8 [&_.swiper-pagination-bullet]:!bg-white/40 [&_.swiper-pagination-bullet-active]:!bg-blue-500 [&_.swiper-pagination-bullet-active]:!w-6 [&_.swiper-pagination-bullet-active]:!rounded-full transition-all"></div>
    </div>
</section>