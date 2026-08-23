<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 1 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="py-14 bg-white border-b border-slate-200">
    <div class="max-w-site mx-auto px-6">
        <div class="swiper dvtone-cards-swiper" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
            <div class="swiper-wrapper py-4">
                <?php foreach ( $slides as $s ) : ?>
                    <div class="swiper-slide h-auto">
                        <div class="flex flex-col h-full bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                            <?php if ( ! empty( $s['image'] ) ) : ?>
                                <div class="aspect-video w-full bg-slate-100 overflow-hidden">
                                    <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>

                            <div class="p-6 flex flex-col flex-grow">
                                <?php if ( ! empty( $s['title'] ) ) : ?>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2"><?php echo esc_html( $s['title'] ); ?></h3>
                                <?php endif; ?>

                                <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                                    <p class="text-sm text-slate-600 mb-6 flex-grow"><?php echo esc_html( $s['subtitle'] ); ?></p>
                                <?php endif; ?>

                                <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                                    <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="mt-auto inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
                                        <?php echo esc_html( $s['btn1_text'] ); ?> &rarr;
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="swiper-pagination mt-6"></div>
        </div>
    </div>
</section>