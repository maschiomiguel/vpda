@props(['page'])

@if ($galleries->count())
    <section class="pt-4 instagram-gallery" id="instagram-gallery">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fw-bold mb-3">
                    Our <span class="text-gradient">Instagram Posts</span>
                </h2>
                <p class="section-subtitle text-muted">
                    Scroll-stopping visuals that command attention and drive engagement
                </p>
            </div>
        </div>

        <div class="gallery-posts-carousel">
            <div class="gallery-posts-wrapper">
                @foreach ($galleries->get() as $gallery)
                    @if ($gallery->image->count())
                        <div class="gallery-posts-slide">
                            <div class="gallery-post-card" style="transition: transform 0.3s ease;">
                                <div class="gallery-post-image">
                                    <img src="{{ $gallery->image->first()?->url() }}" alt="{{ $gallery->title ?? '' }}"
                                        class="img-fluid">
                                </div>
                                <div class="gallery-post-overlay">
                                    <div class="gallery-post-stats">
                                        <span class="gallery-stat-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M20.84 4.61C20.3292 4.099 19.7228 3.69364 19.0554 3.41708C18.3879 3.14052 17.6725 2.99817 16.95 2.99817C16.2275 2.99817 15.5121 3.14052 14.8446 3.41708C14.1772 3.69364 13.5708 4.099 13.06 4.61L12 5.67L10.94 4.61C9.9083 3.57831 8.50903 2.99871 7.05 2.99871C5.59096 2.99871 4.19169 3.57831 3.16 4.61C2.1283 5.64169 1.54871 7.04097 1.54871 8.5C1.54871 9.95903 2.1283 11.3583 3.16 12.39L4.22 13.45L12 21.23L19.78 13.45L20.84 12.39C21.351 11.8792 21.7563 11.2728 22.0329 10.6053C22.3095 9.93789 22.4518 9.22248 22.4518 8.5C22.4518 7.77752 22.3095 7.06211 22.0329 6.39464C21.7563 5.72718 21.351 5.12075 20.84 4.61Z"
                                                    fill="white" />
                                            </svg>
                                            <span>{{ $gallery->short_text }}</span>
                                        </span>
                                        <span class="gallery-stat-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7117 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0034 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92176 4.44061 8.37485 5.27072 7.03255C6.10083 5.69025 7.28825 4.60557 8.7 3.9C9.87812 3.30493 11.1801 2.99656 12.5 3H13C15.0843 3.11499 17.053 3.99476 18.5291 5.47086C20.0052 6.94696 20.885 8.91565 21 11V11.5Z"
                                                    fill="white" />
                                            </svg>
                                            <span>{{ $gallery->text }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="separator-container text-center my-4">
            <svg width="80%" height="2" viewBox="0 0 100 2" preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="1" x2="100" y2="1" stroke="#e0e0e0" stroke-width="2"
                    vector-effect="non-scaling-stroke" />
            </svg>
        </div>
    </section>



    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.querySelector('#instagram-gallery .gallery-posts-wrapper');
                const originalSlides = Array.from(document.querySelectorAll('#instagram-gallery .gallery-posts-slide'));

                if (!wrapper || originalSlides.length === 0) return;

                // Duplicar slides suficientes para criar loop suave
                const timesToDuplicate = Math.min(3, Math.ceil(10 / originalSlides.length));

                for (let i = 0; i < timesToDuplicate; i++) {
                    originalSlides.forEach(slide => {
                        const clone = slide.cloneNode(true);
                        wrapper.appendChild(clone);
                    });
                }

                const slideWidth = originalSlides[0].offsetWidth;
                const gap = 24;
                const totalWidth = (slideWidth + gap) * originalSlides.length;

                // Iniciar da direita (posição negativa) para mover para esquerda
                let currentPosition = -totalWidth;
                const normalSpeed = 1;
                const slowSpeed = 0.2;
                let currentSpeed = normalSpeed;
                let isHovering = false;

                // Adicionar eventos de hover em todos os cards
                const allSlides = document.querySelectorAll('#instagram-gallery .gallery-posts-slide');
                allSlides.forEach(slide => {
                    const card = slide.querySelector('.gallery-post-card');
                    
                    slide.addEventListener('mouseenter', () => {
                        isHovering = true;
                        currentSpeed = slowSpeed;
                        card.style.transform = 'scale(1.1)';
                        card.style.zIndex = '10';
                    });
                    
                    slide.addEventListener('mouseleave', () => {
                        isHovering = false;
                        currentSpeed = normalSpeed;
                        card.style.transform = 'scale(1)';
                        card.style.zIndex = '1';
                    });
                });

                function autoScroll() {
                    currentPosition += currentSpeed;

                    // Quando chegar em 0, resetar para o início negativo
                    if (currentPosition >= 0) {
                        currentPosition = -totalWidth;
                    }

                    wrapper.style.transform = `translateX(${currentPosition}px)`;
                    requestAnimationFrame(autoScroll);
                }

                wrapper.style.transition = 'none';
                autoScroll();
            });
        </script>
    @endpush
@endif
