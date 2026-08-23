<?php
$slides   = dvtone_get_option( 'slides', [] );
$autoplay = dvtone_get_option( 'slider_autoplay', 0 );

if ( empty( $slides ) ) {
    return;
}
?>

<section class="relative w-full min-h-screen bg-slate-950 overflow-hidden flex items-center select-none" id="dvtone-immersive-hero">
    
    <!-- 1. Backgrounds Dinâmicos (Preenche toda a tela) -->
    <div class="absolute inset-0 z-0">
        <?php foreach ( $slides as $i => $s ) : ?>
            <div class="immersive-bg absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out <?php echo 0 === $i ? 'opacity-100 scale-100' : 'opacity-0 scale-105 pointer-events-none'; ?>" 
                 data-index="<?php echo $i; ?>"
                 style="background-image: url('<?php echo ! empty( $s['image'] ) ? esc_url( $s['image'] ) : ''; ?>');">
                <!-- Overlay escuro gradiente -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-black/60"></div>
                <div class="absolute inset-0 bg-black/20"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Container Central -->
    <div class="relative z-10 max-w-site w-full mx-auto px-6 py-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        
        <!-- 2. Coluna Esquerda: Timeline + Conteúdo do Slide Ativo -->
        <div class="lg:col-span-5 flex items-center gap-6 sm:gap-10">
            
            <!-- Timeline / Indicador Vertical de Pontos -->
            <div class="flex flex-col items-center justify-center relative py-6">
                <div class="w-[1px] h-48 bg-white/20 absolute"></div>
                <div class="flex flex-col gap-8 relative z-10">
                    <?php foreach ( $slides as $i => $s ) : ?>
                        <button type="button" 
                                class="timeline-dot transition-all duration-300 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold <?php echo 0 === $i ? 'bg-white text-slate-900 ring-4 ring-white/20 scale-110' : 'bg-white/40 text-transparent hover:bg-white/70'; ?>"
                                data-index="<?php echo $i; ?>">
                            <?php echo $i + 1; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Textos e Ações Dinâmicos -->
            <div class="relative flex-grow min-h-[260px] flex items-center">
                <?php foreach ( $slides as $i => $s ) : ?>
                    <div class="immersive-text-item transition-all duration-700 absolute inset-0 flex flex-col justify-center <?php echo 0 === $i ? 'opacity-100 translate-y-0 relative z-10' : 'opacity-0 translate-y-6 pointer-events-none'; ?>" 
                         data-index="<?php echo $i; ?>">
                        
                        <?php if ( ! empty( $s['title'] ) ) : ?>
                            <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-none mb-4 drop-shadow-md">
                                <?php echo esc_html( $s['title'] ); ?>
                            </h1>
                        <?php endif; ?>

                        <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                            <p class="text-sm sm:text-base text-slate-300 line-clamp-3 mb-8 max-w-md leading-relaxed drop-shadow">
                                <?php echo nl2br( esc_html( $s['subtitle'] ) ); ?>
                            </p>
                        <?php endif; ?>

                        <div class="flex items-center gap-4">
                            <?php if ( ! empty( $s['btn1_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $s['btn1_url'] ?? '#' ); ?>" class="px-7 py-3.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5">
                                    <?php echo esc_html( $s['btn1_text'] ); ?>
                                </a>
                            <?php else : ?>
                                <a href="#" class="px-7 py-3.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg transition">
                                    Explore
                                </a>
                            <?php endif; ?>

                            <?php if ( ! empty( $s['btn2_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $s['btn2_url'] ?? '#' ); ?>" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white text-sm font-semibold rounded-xl backdrop-blur border border-white/20 transition">
                                    <?php echo esc_html( $s['btn2_text'] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- 3. Coluna Direita: Cards dos Slides (Swiper) + Setas de Navegação -->
        <div class="lg:col-span-7 relative">
            <div class="swiper dvtone-travel-swiper overflow-visible py-6" data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>">
                <div class="swiper-wrapper">
                    <?php foreach ( $slides as $i => $s ) : ?>
                        <div class="swiper-slide w-[180px] sm:w-[220px] transition-all duration-500 cursor-pointer" data-index="<?php echo $i; ?>">
                            <div class="relative h-[280px] sm:h-[340px] rounded-2xl overflow-hidden border border-white/20 shadow-2xl group">
                                
                                <!-- Imagem do Card -->
                                <?php if ( ! empty( $s['image'] ) ) : ?>
                                    <img src="<?php echo esc_url( $s['image'] ); ?>" alt="<?php echo esc_attr( $s['title'] ?? '' ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <?php else : ?>
                                    <div class="w-full h-full bg-slate-800"></div>
                                <?php endif; ?>

                                <!-- Overlay e Legenda no fundo do card -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-4">
                                    <h3 class="text-base font-bold text-white leading-tight">
                                        <?php echo esc_html( $s['title'] ?? '' ); ?>
                                    </h3>
                                    <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                                        <span class="text-xs text-slate-300 truncate block mt-0.5">
                                            <?php echo esc_html( wp_trim_words( $s['subtitle'], 4, '...' ) ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Borda de destaque no card ativo -->
                                <div class="card-active-border absolute inset-0 rounded-2xl border-2 border-white/80 opacity-0 transition-opacity duration-300"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 4. Controles de Navegação Redondos (Abaixo dos cards) -->
            <div class="flex items-center gap-3 mt-4">
                <button type="button" class="travel-prev w-11 h-11 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur border border-white/20 flex items-center justify-center transition">
                    &larr;
                </button>
                <button type="button" class="travel-next w-11 h-11 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur border border-white/20 flex items-center justify-center transition">
                    &rarr;
                </button>
            </div>

        </div>

    </div>

</section>