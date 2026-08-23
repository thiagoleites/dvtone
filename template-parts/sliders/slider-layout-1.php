<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 1 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="relative w-full overflow-hidden bg-slate-950">
    <div class="swiper dvtone-hero-swiper relative h-[500px] sm:h-[600px] w-full" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
        <div class="swiper-wrapper">
            <?php foreach ( $slides as $s ) : ?>
                <div class="swiper-slide relative flex items-center justify-center bg-slate-900 overflow-hidden">
                    <?php if ( ! empty( $s['image'] ) ) : ?>
                        <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="absolute inset-0 w-full h-full object-cover opacity-40">
                    <?php endif; ?>

                    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center text-white">
                        <?php if ( ! empty( $s['title'] ) ) : ?>
                            <h2 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                                <?php echo esc_html( $s['title'] ); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                            <p class="mt-4 sm:mt-6 text-base sm:text-xl text-slate-200 max-w-2xl mx-auto leading-relaxed">
                                <?php echo nl2br( esc_html( $s['subtitle'] ) ); ?>
                            </p>
                        <?php endif; ?>

                        <div class="mt-8 flex flex-wrap justify-center gap-4">
                            <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg transition">
                                    <?php echo esc_html( $s['btn1_text'] ); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ( ! empty( $s['btn2_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $s['btn2_url'] ?? '#' ); ?>" class="px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl backdrop-blur border border-white/30 transition">
                                    <?php echo esc_html( $s['btn2_text'] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginação & Navegação -->
        <div class="swiper-pagination !bottom-6"></div>
        <div class="swiper-button-prev !text-white !w-10 !h-10 after:!text-xl hidden md:flex"></div>
        <div class="swiper-button-next !text-white !w-10 !h-10 after:!text-xl hidden md:flex"></div>
    </div>
</section>