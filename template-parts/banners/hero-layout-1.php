<?php
$title     = dvtone_get_option( 'banner_title', '' );
$subtitle  = dvtone_get_option( 'banner_subtitle', '' );
$image     = dvtone_get_option( 'banner_image', '' );
$btn1_text = dvtone_get_option( 'banner_btn1_text', '' );
$btn1_url  = dvtone_get_option( 'banner_btn1_url', '#' );
$btn2_text = dvtone_get_option( 'banner_btn2_text', '' );
$btn2_url  = dvtone_get_option( 'banner_btn2_url', '#' );
?>

<section class="relative bg-white border-b border-slate-200 py-16 lg:py-24">
    <div class="max-w-site mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7">
            <?php if ( ! empty( $title ) ) : ?>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    <?php echo esc_html( $title ); ?>
                </h1>
            <?php endif; ?>

            <?php if ( ! empty( $subtitle ) ) : ?>
                <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl">
                    <?php echo nl2br( esc_html( $subtitle ) ); ?>
                </p>
            <?php endif; ?>

            <div class="mt-8 flex flex-wrap gap-4">
                <?php if ( ! empty( $btn1_text ) ) : ?>
                    <a href="<?php echo esc_url( $btn1_url ); ?>" class="px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                        <?php echo esc_html( $btn1_text ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( ! empty( $btn2_text ) ) : ?>
                    <a href="<?php echo esc_url( $btn2_url ); ?>" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl border border-slate-200 transition">
                        <?php echo esc_html( $btn2_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="lg:col-span-5">
            <?php if ( ! empty( $image ) ) : ?>
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-full h-auto rounded-2xl shadow-xl object-cover aspect-[4/3]">
            <?php else : ?>
                <div class="w-full aspect-[4/3] bg-slate-100 border border-dashed border-slate-300 rounded-2xl flex items-center justify-center text-slate-400">
                    Insira uma imagem no painel
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>