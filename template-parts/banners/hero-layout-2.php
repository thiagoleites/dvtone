<?php
$title     = dvtone_get_option( 'banner_title', '' );
$subtitle  = dvtone_get_option( 'banner_subtitle', '' );
$btn1_text = dvtone_get_option( 'banner_btn1_text', '' );
$btn1_url  = dvtone_get_option( 'banner_btn1_url', '#' );
$btn2_text = dvtone_get_option( 'banner_btn2_text', '' );
$btn2_url  = dvtone_get_option( 'banner_btn2_url', '#' );
?>

<section class="bg-gradient-to-b from-slate-100 to-white py-20 lg:py-28 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <?php if ( ! empty( $title ) ) : ?>
            <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                <?php echo esc_html( $title ); ?>
            </h1>
        <?php endif; ?>

        <?php if ( ! empty( $subtitle ) ) : ?>
            <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                <?php echo nl2br( esc_html( $subtitle ) ); ?>
            </p>
        <?php endif; ?>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <?php if ( ! empty( $btn1_text ) ) : ?>
                <a href="<?php echo esc_url( $btn1_url ); ?>" class="px-7 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">
                    <?php echo esc_html( $btn1_text ); ?>
                </a>
            <?php endif; ?>

            <?php if ( ! empty( $btn2_text ) ) : ?>
                <a href="<?php echo esc_url( $btn2_url ); ?>" class="px-7 py-3.5 bg-white hover:bg-slate-50 text-slate-800 font-semibold rounded-xl border border-slate-300 shadow-sm transition">
                    <?php echo esc_html( $btn2_text ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>