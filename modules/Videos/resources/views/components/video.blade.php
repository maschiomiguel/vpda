@props(['page'])

@if ($videos->count())
    <section class="pb-3 instagram-video" id="instagram-video">
        {{-- <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fw-bold mb-3">
                    Our <span class="text-gradient">Instagram Videos</span>
                </h2>
                <p class="section-subtitle text-muted">
                    Scroll-stopping visuals that command attention and drive engagement
                </p>
            </div>
        </div> --}}

        <div class="video-reels-carousel">
            <div class="video-reels-wrapper">
                @foreach ($videos->get() as $video)
                    @if ($video->image->count())
                        <div class="video-reels-slide">
                            <div class="video-reel-card" style="transition: transform 0.3s ease;">
                                <div class="video-reel-container">
                                    <video 
                                        src="{{ $video->image->first()?->url() }}" 
                                        autoplay 
                                        muted 
                                        loop 
                                        playsinline
                                        class="video-reel-player"
                                        style="pointer-events: none;">
                                    </video>
                                </div>
                                <div class="video-reel-overlay">
                                    <div class="video-reel-stats">
                                        <span class="video-stat-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20.84 4.61C20.3292 4.099 19.7228 3.69364 19.0554 3.41708C18.3879 3.14052 17.6725 2.99817 16.95 2.99817C16.2275 2.99817 15.5121 3.14052 14.8446 3.41708C14.1772 3.69364 13.5708 4.099 13.06 4.61L12 5.67L10.94 4.61C9.9083 3.57831 8.50903 2.99871 7.05 2.99871C5.59096 2.99871 4.19169 3.57831 3.16 4.61C2.1283 5.64169 1.54871 7.04097 1.54871 8.5C1.54871 9.95903 2.1283 11.3583 3.16 12.39L4.22 13.45L12 21.23L19.78 13.45L20.84 12.39C21.351 11.8792 21.7563 11.2728 22.0329 10.6053C22.3095 9.93789 22.4518 9.22248 22.4518 8.5C22.4518 7.77752 22.3095 7.06211 22.0329 6.39464C21.7563 5.72718 21.351 5.12075 20.84 4.61Z" fill="white"/>
                                            </svg>
                                            <span>{{ $video->short_text}}</span>
                                        </span>
                                        <span class="video-stat-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7117 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0034 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92176 4.44061 8.37485 5.27072 7.03255C6.10083 5.69025 7.28825 4.60557 8.7 3.9C9.87812 3.30493 11.1801 2.99656 12.5 3H13C15.0843 3.11499 17.053 3.99476 18.5291 5.47086C20.0052 6.94696 20.885 8.91565 21 11V11.5Z" fill="white"/>
                                            </svg>
                                            <span>{{ $video->text}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.querySelector('#instagram-video .video-reels-wrapper');
            const originalSlides = Array.from(document.querySelectorAll('#instagram-video .video-reels-slide'));
            
            if (!wrapper || originalSlides.length === 0) return;

            let currentPosition = 0;
            const normalSpeed = 1;
            const slowSpeed = 0.2;
            let currentSpeed = normalSpeed;
            let hoverCount = 0;
            const slideWidth = originalSlides[0].offsetWidth;
            const gap = 24;
            const totalWidth = (slideWidth + gap) * originalSlides.length;

            // Adicionar eventos de hover ANTES de clonar
            originalSlides.forEach(slide => {
                const card = slide.querySelector('.video-reel-card');
                
                slide.addEventListener('mouseenter', () => {
                    hoverCount++;
                    currentSpeed = slowSpeed;
                    card.style.transform = 'scale(1.1)';
                    card.style.zIndex = '10';
                });
                
                slide.addEventListener('mouseleave', () => {
                    hoverCount--;
                    if (hoverCount <= 0) {
                        hoverCount = 0;
                        currentSpeed = normalSpeed;
                    }
                    card.style.transform = 'scale(1)';
                    card.style.zIndex = '1';
                });
            });

            // Duplicar slides suficientes para criar loop suave
            const timesToDuplicate = Math.min(3, Math.ceil(10 / originalSlides.length));
            
            for (let i = 0; i < timesToDuplicate; i++) {
                originalSlides.forEach(slide => {
                    const clone = slide.cloneNode(true);
                    const cloneCard = clone.querySelector('.video-reel-card');
                    
                    clone.addEventListener('mouseenter', () => {
                        hoverCount++;
                        currentSpeed = slowSpeed;
                        cloneCard.style.transform = 'scale(1.1)';
                        cloneCard.style.zIndex = '10';
                    });
                    
                    clone.addEventListener('mouseleave', () => {
                        hoverCount--;
                        if (hoverCount <= 0) {
                            hoverCount = 0;
                            currentSpeed = normalSpeed;
                        }
                        cloneCard.style.transform = 'scale(1)';
                        cloneCard.style.zIndex = '1';
                    });
                    
                    wrapper.appendChild(clone);
                });
            }

            // Desabilitar qualquer interação que possa afetar a velocidade
            wrapper.style.pointerEvents = 'auto';
            wrapper.style.userSelect = 'none';

            let lastTime = performance.now();
            const targetFPS = 60;
            const frameTime = 1000 / targetFPS;

            function autoScroll(currentTime) {
                const deltaTime = currentTime - lastTime;
                const speedMultiplier = deltaTime / frameTime;
                
                currentPosition -= currentSpeed * speedMultiplier;

                if (Math.abs(currentPosition) >= totalWidth) {
                    currentPosition = 0;
                }

                wrapper.style.transform = `translateX(${currentPosition}px)`;
                lastTime = currentTime;
                requestAnimationFrame(autoScroll);
            }

            wrapper.style.transition = 'none';
            requestAnimationFrame(autoScroll);
        });
    </script>
    @endpush
@endif
