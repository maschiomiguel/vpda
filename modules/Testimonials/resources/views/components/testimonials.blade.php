@props([
    'page' => null,
])

@if ($testimonials->count())
    <section id="testimonials" class="testimonials-section py-2 py-lg-4 pb-lg-6">
        <div class="container mb-2 mb-lg-4">
            <div class="col-lg-5 mx-auto text-center">
                <h3 class="text-gray-blue testimonial-title w-100 fw-bold">
                    {!! $page->title_2 ?: ' O que dizem sobre nós' !!}
                   
                </h3>
            </div>
        </div>
        <div class="swiper-testimonials {{ $testimonials->count() < 3 ? 'testimonials-few' : '' }} px-1 px-lg-4 position-relative h-auto mt-lg-4 mb-lg-4">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide h-auto">
                        <div class="testimony-card h-100 text-center bg-secondary justify-content-between">
                            {{-- @if ($testimonial->image->count()) --}}
                                <div class="col-3 col-lg-4 col-xl-3 col-xxl-2 picture">
                                    <div class="ratio ratio-1x1 max-w-icon">
                                        <img class="object-fit-contain bg-primary rounded-circle p-0-50" alt="Foto de perfil de {{ $testimonial->text_1 }}" title="Foto de perfil de {{ $testimonial->text_1 }}" src="front\images\icons\quote.png">
                                    </div>
                                </div>
                            {{-- @endif --}}

                            @if ($testimonial->text_3)
                                <h4 class="editor-texto mt-4 px-1 text-white">
                                    {!! nl2br(e($testimonial->text_3)) !!}
                                </h4>
                            @endif
                            @if ($testimonial->link_1)
                                @php
                                    $videoId = Str::contains($testimonial->link_1, 'youtu.be') ? Str::after($testimonial->link_1, 'youtu.be/') : Str::after($testimonial->link_1, 'watch?v=');

                                @endphp
                                <a href="https://www.youtube.com/embed/{{ $videoId }}" data-fancybox="depoimento-{{ $testimonial->id }}" class="video ratio ratio-16x9 d-block">
                                    <iframe width="100%" height="100%" class="h-100 rounded-3 pe-none mt-1" src="https://www.youtube.com/embed/{{ $videoId }}" title="Introdução a documentação" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                    </iframe>
                                </a>
                            @endif
                            <div class="d-flex align-items-center gap-1 mt-2 justify-content-center">
                                @foreach (range(0, 4) as $key => $value)
                                    <svg width="30" height="30" viewBox="0 0 33 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.1957 0.542191L20.5328 10.699C20.6385 11.0214 20.9445 11.2412 21.287 11.2412H32.0871C32.8558 11.2412 33.1746 12.2138 32.5535 12.6605L23.8153 18.9376C23.5366 19.1375 23.42 19.4905 23.5275 19.8147L26.8646 29.9716C27.1015 30.6938 26.2653 31.2954 25.6442 30.8487L16.906 24.5716C16.6273 24.3717 16.2521 24.3717 15.9734 24.5716L7.23523 30.8487C6.61407 31.2954 5.77614 30.6938 6.01477 29.9716L9.35192 19.8147C9.45757 19.4923 9.34099 19.1375 9.06411 18.9376L0.32778 12.6587C-0.293381 12.212 0.0253964 11.2394 0.794106 11.2394H11.5943C11.9386 11.2394 12.2428 11.0196 12.3484 10.6972L15.6874 0.542191C15.9242 -0.180079 16.9589 -0.180079 17.1957 0.542191Z" fill="#FFD119" />
                                    </svg>
                                @endforeach
                            </div>
                            @if ($testimonial->text_1)
                                <h3 class="fw-bold h4 mb-0 mt-1 text-white">{{ $testimonial->text_1 }}</h3>
                            @endif
                            <div class="mb-1">
                                @if ($testimonial->text_2)
                                    <span class="h6 fw-normal fst-italic text-white">{{ $testimonial->text_2 }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-custom swiper-button-prev text-dark d-flex align-items-center justify-content-center">
                <svg width="8" height="32" viewBox="0 0 8 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                          d="M0.0002 8.10766C-0.0005 7.69714 0.0797 7.29051 0.2362 6.911C0.3927 6.53149 0.6225 6.18656 0.9124 5.89591L6.0169 0.791403C6.1346 0.673753 6.2941 0.607658 6.4606 0.607658C6.6269 0.607658 6.7865 0.673753 6.9042 0.791403C7.0218 0.909053 7.0879 1.06862 7.0879 1.235C7.0879 1.40138 7.0218 1.56095 6.9042 1.6786L1.7996 6.78311C1.4486 7.13455 1.2515 7.61095 1.2515 8.10766C1.2515 8.60437 1.4486 9.08076 1.7996 9.43221L6.9042 14.5367C7.0218 14.6544 7.0879 14.8139 7.0879 14.9803C7.0879 15.1467 7.0218 15.3063 6.9042 15.4239C6.7865 15.5416 6.6269 15.6077 6.4606 15.6077C6.2941 15.6077 6.1346 15.5416 6.0169 15.4239L0.9124 10.3194C0.6225 10.0288 0.3927 9.68382 0.2362 9.30432C0.0797 8.92481 -0.0005 8.51817 0.0002 8.10766Z"
                          fill="currentColor" />
                </svg>
            </div>
            <div class="swiper-button-custom swiper-button-next text-dark d-flex align-items-center justify-content-center">
                <svg width="8" height="32" viewBox="0 0 8 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                          d="M7.9998 8.10766C8.0005 8.51817 7.9203 8.92481 7.7638 9.30432C7.6073 9.68382 7.3775 10.0288 7.0876 10.3194L1.9831 15.4239C1.8654 15.5416 1.7058 15.6077 1.5395 15.6077C1.3731 15.6077 1.2135 15.5416 1.0959 15.4239C0.9782 15.3063 0.9121 15.1467 0.9121 14.9803C0.9121 14.8139 0.9782 14.6544 1.0959 14.5367L6.2004 9.43221C6.5514 9.08076 6.7485 8.60437 6.7485 8.10766C6.7485 7.61095 6.5514 7.13455 6.2004 6.78311L1.0959 1.6786C0.9782 1.56095 0.9121 1.40138 0.9121 1.235C0.9121 1.06862 0.9782 0.909053 1.0959 0.791404C1.2135 0.673754 1.3731 0.607658 1.5395 0.607658C1.7058 0.607658 1.8654 0.673754 1.9831 0.791404L7.0876 5.89591C7.3775 6.18656 7.6073 6.53149 7.7638 6.911C7.9203 7.29051 8.0005 7.69714 7.9998 8.10766Z"
                          fill="currentColor" />
                </svg>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto  d-flex flex-lg-row flex-column gap-2 gap-lg-0 justify-content-lg-between align-items-center py-2 rounded-3 px-4">
                    <div class="text-gray-blue text-center text-lg-start call-text w-lg-50 mb-0">
                        {!! nl2br(e($page->text_5)) !!}
                    </div>
                    <div class="w-lg-50 d-flex align-items-start justify-content-lg-center justify-content-center">
                        <x-whatsapp-button :text="$page->call_text_1 ?: 'Fale com um especialista'" class="btn-solution" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
