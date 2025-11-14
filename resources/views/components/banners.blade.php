@props(['page' => null])

@if ($banners->count())
    <section class="banner ratio ratio-6x9 ratio-md-21x9 overflow-hidden">
        <div class="banner-swiper">
            <div class="swiper-wrapper">
                @foreach ($banners as $index => $banner)
                    <div class="swiper-slide banner-slide position-relative">
                        @php
                            $desktopUrl = $banner->getImagemDesktop()?->url();
                            $mobileUrl = $banner->getImagemMobile()?->url();
                            $desktopPath = $desktopUrl ? parse_url($desktopUrl, PHP_URL_PATH) : null;
                            $mobilePath = $mobileUrl ? parse_url($mobileUrl, PHP_URL_PATH) : null;
                            $desktopExtension = $desktopPath ? strtolower(pathinfo($desktopPath, PATHINFO_EXTENSION)) : null;
                            $mobileExtension = $mobilePath ? strtolower(pathinfo($mobilePath, PATHINFO_EXTENSION)) : null;
                            $isVideoBanner = in_array('mp4', array_filter([$desktopExtension, $mobileExtension]), true);
                            $posterUrl = null;

                            if ($isVideoBanner) {
                                if ($desktopExtension !== 'mp4' && $desktopUrl) {
                                    $posterUrl = $desktopUrl;
                                } elseif ($mobileExtension !== 'mp4' && $mobileUrl) {
                                    $posterUrl = $mobileUrl;
                                }
                            }
                        @endphp

                        @if ($isVideoBanner)
                            <video class="object-fit-cover w-100 h-100" autoplay muted loop playsinline @if ($posterUrl) poster="{{ $posterUrl }}" @endif>
                                @if ($desktopExtension === 'mp4')
                                    <source src="{{ $desktopUrl }}" media="(min-width: 767px)" type="video/mp4">
                                @endif
                                @if ($mobileExtension === 'mp4')
                                    <source src="{{ $mobileUrl }}" type="video/mp4">
                                @endif
                            </video>
                        @else
                        <picture>
                            {{-- Desktop --}}
                            <source srcset="{{ $desktopUrl }}" media="(min-width: 767px)">
                            {{-- Mobile --}}
                            <img class="object-fit-cover w-100 h-100" src="{{ $mobileUrl }}" alt="">
                        </picture>
                        @endif

                        @if ($banner->text_1 || $banner->text_2)
                            <div class="banner-content-overlay d-flex align-items-center justify-content-center">
                                <div class="container">
                                    <div class="row justify-content-center justify-content-lg-start">
                                        <div class="col-12 col-lg-6 text-center text-lg-start">
                                            <h2 class="text-white banner-title fw-700 mt-4 mb-2 poppins">
                                                {!! nl2br(e($banner->text_1)) !!}
                                            </h2>
                                            <h4 class="fw-light text-white"
                                                style="text-shadow: 3px 3px 2px rgba(0,0,0,1)">
                                                {!! nl2br(e($banner->text_2)) !!}
                                            </h4>
                                            <x-whatsapp-button text="{{ $banner->text_3 ?: 'Fale com um especialista' }}" link="{{ $banner->link_1 ?: '' }}" class="btn-cta mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-custom swiper-button-background bg-white swiper-button-prev">
                <svg width="16" height="32" viewBox="0 0 8 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.000249475 8.10766C-0.000483905 7.69714 0.0797015 7.29051 0.236221 6.911C0.392741 6.53149 0.622525 6.18656 0.912438 5.89591L6.01695 0.791403C6.1346 0.673753 6.29417 0.607658 6.46055 0.607658C6.62693 0.607658 6.7865 0.673753 6.90415 0.791403C7.0218 0.909053 7.08789 1.06862 7.08789 1.235C7.08789 1.40138 7.0218 1.56095 6.90415 1.6786L1.79964 6.78311C1.44863 7.13455 1.25147 7.61095 1.25147 8.10766C1.25147 8.60437 1.44863 9.08076 1.79964 9.43221L6.90415 14.5367C7.0218 14.6544 7.08789 14.8139 7.08789 14.9803C7.08789 15.1467 7.0218 15.3063 6.90415 15.4239C6.7865 15.5416 6.62693 15.6077 6.46055 15.6077C6.29417 15.6077 6.1346 15.5416 6.01695 15.4239L0.912438 10.3194C0.622525 10.0288 0.392741 9.68382 0.236221 9.30432C0.0797015 8.92481 -0.000483895 8.51817 0.000249475 8.10766Z"
                        fill="black" />
                </svg>
            </div>
            <div class="swiper-button-custom swiper-button-background bg-white swiper-button-next">
                <svg width="16" height="32" viewBox="0 0 8 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.99975 8.10766C8.00048 8.51817 7.9203 8.92481 7.76378 9.30432C7.60726 9.68382 7.37747 10.0288 7.08756 10.3194L1.98305 15.4239C1.8654 15.5416 1.70583 15.6077 1.53945 15.6077C1.37307 15.6077 1.2135 15.5416 1.09585 15.4239C0.978204 15.3063 0.912109 15.1467 0.912109 14.9803C0.912109 14.8139 0.978204 14.6544 1.09585 14.5367L6.20036 9.43221C6.55137 9.08076 6.74853 8.60437 6.74853 8.10766C6.74853 7.61095 6.55137 7.13455 6.20036 6.78311L1.09585 1.6786C0.978204 1.56095 0.912109 1.40138 0.912109 1.235C0.912109 1.06862 0.978204 0.909053 1.09585 0.791404C1.2135 0.673754 1.37307 0.607658 1.53945 0.607658C1.70583 0.607658 1.8654 0.673754 1.98305 0.791404L7.08756 5.89591C7.37747 6.18656 7.60726 6.53149 7.76378 6.911C7.9203 7.29051 8.00048 7.69714 7.99975 8.10766Z"
                        fill="black" />
                </svg>
            </div>
        </div>
    </section>
@endif

{{-- @if ($banners->count())
    @pushOnce('js')
        <script>
            setTimeout(typeWriter, 100);

            function typeWriter() {
                var textdiv = $('.typing-text');

                var textsArray = {!! json_encode(array_column($banners->first()->words, 'name')) !!};
                var currentTextIndex = 0;
                var text = textsArray[currentTextIndex];
                var i = 0;
                var speed = 100;
                var isUntyping = false;

                function type() {
                    if (!isUntyping && i < text.length) {
                        if (!textdiv.hasClass('is-typing')) {
                            textdiv.addClass('is-typing');
                        }
                        textdiv.html(text.substring(0, i + 1) + '<span class="blinking-cursor">|</span>');
                        i++;
                        setTimeout(type, speed);
                    } else if (isUntyping && i > 0) {
                        if (!textdiv.hasClass('is-typing')) {
                            textdiv.addClass('is-typing');
                        }
                        textdiv.html(text.substring(0, i - 1) + '<span class="blinking-cursor">|</span>');
                        i--;
                        setTimeout(type, speed);
                    } else {
                        // Toggle between typing and untyping
                        if (isUntyping) {
                            isUntyping = false;
                            currentTextIndex = (currentTextIndex + 1) % textsArray.length; // Move to the next text
                            text = textsArray[currentTextIndex];
                            setTimeout(type, 200);
                        } else {
                            isUntyping = true;
                            textdiv.removeClass('is-typing');
                            setTimeout(type, 3000);
                        }
                    }
                }

                type();
            }
        </script>
    @endpushOnce
@endif --}}
