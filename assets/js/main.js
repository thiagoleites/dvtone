document.addEventListener('DOMContentLoaded', function () {
    // 1. Hero Full Slider (Layout 1)
    const heroEl = document.querySelector('.dvtone-hero-swiper');
    if (heroEl) {
        const isAutoplay = heroEl.dataset.autoplay === 'true';
        new Swiper('.dvtone-hero-swiper', {
            loop: true,
            speed: 800,
            autoplay: isAutoplay ? { delay: 5000, disableOnInteraction: false } : false,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    }

    // 2. Split Slider (Layout 2)
    const splitEl = document.querySelector('.dvtone-split-swiper');
    if (splitEl) {
        const isAutoplay = splitEl.dataset.autoplay === 'true';
        new Swiper('.dvtone-split-swiper', {
            loop: true,
            speed: 600,
            autoplay: isAutoplay ? { delay: 6000, disableOnInteraction: false } : false,
            pagination: { el: '.swiper-pagination', clickable: true },
        });
    }

    // 3. Multi-Cards Carousel (Layout 3)
    const cardsEl = document.querySelector('.dvtone-cards-swiper');
    if (cardsEl) {
        const isAutoplay = cardsEl.dataset.autoplay === 'true';
        new Swiper('.dvtone-cards-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: isAutoplay ? { delay: 4000, disableOnInteraction: false } : false,
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }

    // 4. Glassmorphism com Progress Bar (Layout 4)
    const glassEl = document.querySelector('.dvtone-glass-swiper');
    if (glassEl) {
        const isAutoplay = glassEl.dataset.autoplay === 'true';
        new Swiper('.dvtone-glass-swiper', {
            loop: true,
            speed: 700,
            autoplay: isAutoplay ? { delay: 5000, disableOnInteraction: false } : false,
            pagination: {
                el: '.dvtone-glass-swiper .swiper-pagination',
                type: 'progressbar',
            },
            navigation: {
                nextEl: '.glass-next',
                prevEl: '.glass-prev',
            },
        });
    }

    // 5. Vertical Editorial Slider (Layout 5)
    const verticalEl = document.querySelector('.dvtone-vertical-swiper');
    if (verticalEl) {
        const isAutoplay = verticalEl.dataset.autoplay === 'true';
        new Swiper('.dvtone-vertical-swiper', {
            direction: 'vertical',
            loop: true,
            speed: 600,
            mousewheel: true,
            autoplay: isAutoplay ? { delay: 6000, disableOnInteraction: false } : false,
            pagination: {
                el: '.dvtone-vertical-swiper .swiper-pagination',
                clickable: true,
            },
        });
    }

    // 6. 3D Coverflow Showcase (Layout 6)
    const coverflowEl = document.querySelector('.dvtone-coverflow-swiper');
    if (coverflowEl) {
        const isAutoplay = coverflowEl.dataset.autoplay === 'true';
        new Swiper('.dvtone-coverflow-swiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            coverflowEffect: {
                rotate: 25,
                stretch: 0,
                depth: 150,
                modifier: 1,
                slideShadows: true,
            },
            autoplay: isAutoplay ? { delay: 3500, disableOnInteraction: false } : false,
            pagination: {
                el: '.dvtone-coverflow-swiper .swiper-pagination',
                clickable: true,
            },
        });
    }

    // 7. Travel Immersive Slider (Layout 7)
    const travelEl = document.querySelector('.dvtone-travel-swiper');
    if (travelEl) {
        const isAutoplay = travelEl.dataset.autoplay === 'true';
        const bgItems = document.querySelectorAll('.immersive-bg');
        const textItems = document.querySelectorAll('.immersive-text-item');
        const dotItems = document.querySelectorAll('.timeline-dot');

        const updateActiveSlide = (index) => {
            // 1. Atualiza Background
            bgItems.forEach((bg) => {
                if (parseInt(bg.dataset.index) === index) {
                    bg.classList.remove('opacity-0', 'scale-105', 'pointer-events-none');
                    bg.classList.add('opacity-100', 'scale-100');
                } else {
                    bg.classList.remove('opacity-100', 'scale-100');
                    bg.classList.add('opacity-0', 'scale-105', 'pointer-events-none');
                }
            });

            // 2. Atualiza Texto Esquerdo
            textItems.forEach((txt) => {
                if (parseInt(txt.dataset.index) === index) {
                    txt.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none');
                    txt.classList.add('opacity-100', 'translate-y-0', 'relative', 'z-10');
                } else {
                    txt.classList.remove('opacity-100', 'translate-y-0', 'relative', 'z-10');
                    txt.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none');
                }
            });

            // 3. Atualiza Pontos da Timeline
            dotItems.forEach((dot) => {
                if (parseInt(dot.dataset.index) === index) {
                    dot.className = 'timeline-dot transition-all duration-300 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold bg-white text-slate-900 ring-4 ring-white/20 scale-110';
                } else {
                    dot.className = 'timeline-dot transition-all duration-300 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold bg-white/40 text-transparent hover:bg-white/70';
                }
            });
        };

        const travelSwiper = new Swiper('.dvtone-travel-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            grabCursor: true,
            speed: 600,
            autoplay: isAutoplay ? { delay: 5500, disableOnInteraction: false } : false,
            navigation: {
                nextEl: '.travel-next',
                prevEl: '.travel-prev',
            },
            on: {
                slideChange: function () {
                    updateActiveSlide(this.realIndex);
                },
            },
        });

        // Clique direto nos cards da direita
        document.querySelectorAll('.dvtone-travel-swiper .swiper-slide').forEach((card) => {
            card.addEventListener('click', function () {
                const idx = parseInt(this.dataset.index);
                travelSwiper.slideTo(idx);
                updateActiveSlide(idx);
            });
        });

        // Clique nos pontos da timeline
        dotItems.forEach((dot) => {
            dot.addEventListener('click', function () {
                const idx = parseInt(this.dataset.index);
                travelSwiper.slideTo(idx);
                updateActiveSlide(idx);
            });
        });
    }
});