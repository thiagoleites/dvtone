<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 1 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="bg-slate-50 border-b border-slate-200 py-12 lg:py-16">
    <div class="max-w-site mx-auto px-6">
        <div class="swiper dvtone-split-swiper" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $s ) : ?>
                    <div class="swiper-slide">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center bg-white border border-slate-200 rounded-3xl p-8 lg:p-12 shadow-sm">
                            <div class="lg:col-span-7">
                                <?php if ( ! empty( $s['title'] ) ) : ?>
                                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                        <?php echo esc_html( $s['title'] ); ?>
                                    </h2>
                                <?php endif; ?>

                                <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                                    <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                                        <?php echo nl2br( esc_html( $s['subtitle'] ) ); ?>
                                    </p>
                                <?php endif; ?>

                                <div class="mt-8 flex flex-wrap gap-4">
                                    <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                                        <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow transition">
                                            <?php echo esc_html( $s['btn1_text'] ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $s['btn2_text'] ) ) : ?>
                                        <a href="<?php echo esc_url( $s['btn2_url'] ?? '#' ); ?>" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl border border-slate-200 transition">
                                            <?php echo esc_html( $s['btn2_text'] ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="lg:col-span-5">
                                <?php if ( ! empty( $s['image'] ) ) : ?>
                                    <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="w-full aspect-[4/3] object-cover rounded-2xl shadow-md border border-slate-100">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="swiper-pagination !-bottom-2 mt-6"></div>
        </div>
    </div>
</section>