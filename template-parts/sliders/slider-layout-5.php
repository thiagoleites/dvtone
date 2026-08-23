<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 1 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="w-full bg-slate-100 border-b border-slate-200">
    <div class="max-w-site mx-auto px-6 py-12">
        <div class="swiper dvtone-vertical-swiper h-[550px] rounded-3xl overflow-hidden bg-white border border-slate-200 shadow-sm" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $i => $s ) : ?>
                    <div class="swiper-slide h-full">
                        <div class="grid grid-cols-1 lg:grid-cols-12 h-full">
                            <!-- Coluna Esquerda: Texto Editorial com Número de Slide Grande -->
                            <div class="lg:col-span-6 p-8 sm:p-14 flex flex-col justify-between bg-white relative">
                                <span class="text-7xl font-black text-slate-100 select-none absolute top-4 right-6">
                                    0<?php echo $i + 1; ?>
                                </span>

                                <div>
                                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider rounded-full mb-4">
                                        Destaque
                                    </span>
                                    <?php if ( ! empty( $s['title'] ) ) : ?>
                                        <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                            <?php echo esc_html( $s['title'] ); ?>
                                        </h2>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                                        <p class="mt-4 text-base text-slate-600 leading-relaxed">
                                            <?php echo nl2br( esc_html( $s['subtitle'] ) ); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-8 flex flex-wrap gap-4 pt-6 border-t border-slate-100">
                                    <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                                        <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl transition">
                                            <?php echo esc_html( $s['btn1_text'] ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $s['btn2_text'] ) ) : ?>
                                        <a href="<?php echo esc_url( $s['btn2_url'] ?? '#' ); ?>" class="px-6 py-3 text-slate-700 hover:text-blue-600 font-semibold inline-flex items-center gap-1 transition">
                                            <?php echo esc_html( $s['btn2_text'] ); ?> &rarr;
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Coluna Direita: Imagem de Destaque -->
                            <div class="lg:col-span-6 h-64 lg:h-full bg-slate-900 relative overflow-hidden">
                                <?php if ( ! empty( $s['image'] ) ) : ?>
                                    <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginação Lateral de Pontos -->
            <div class="swiper-pagination !right-4 !left-auto"></div>
        </div>
    </div>
</section>