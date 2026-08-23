<?php
$title     = dvtone_get_option( 'banner_title', '' );
$subtitle  = dvtone_get_option( 'banner_subtitle', '' );
$image     = dvtone_get_option( 'banner_image', '' );
$btn1_text = dvtone_get_option( 'banner_btn1_text', '' );
$btn1_url  = dvtone_get_option( 'banner_btn1_url', '#' );
$btn2_text = dvtone_get_option( 'banner_btn2_text', '' );
$btn2_url  = dvtone_get_option( 'banner_btn2_url', '#' );
?>

<section class="relative bg-slate-900 py-24 lg:py-32 overflow-hidden">
    <?php if ( ! empty( $image ) ) : ?>
        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="absolute inset-0 w-full h-full object-cover opacity-30">
    <?php endif; ?>
    
    <div class="relative max-w-site mx-auto px-6">
        <div class="max-w-2xl">
            <?php if ( ! empty( $title ) ) : ?>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                    <?php echo esc_html( $title ); ?>
                </h1>
            <?php endif; ?>

            <?php if ( ! empty( $subtitle ) ) : ?>
                <p class="mt-6 text-lg sm:text-xl text-slate-300 leading-relaxed">
                    <?php echo nl2br( esc_html( $subtitle ) ); ?>
                </p>
            <?php endif; ?>

            <div class="mt-8 flex flex-wrap gap-4">
                <?php if ( ! empty( $btn1_text ) ) : ?>
                    <a href="<?php echo esc_url( $btn1_url ); ?>" class="px-6 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl shadow transition">
                        <?php echo esc_html( $btn1_text ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( ! empty( $btn2_text ) ) : ?>
                    <a href="<?php echo esc_url( $btn2_url ); ?>" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur border border-white/20 transition">
                        <?php echo esc_html( $btn2_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>