@props([
    'active' => false,
    'menuActive' => null, // string ou array
    'anchorage' => false,
    'route' => false,
    'text' => '',
    'translateText' => true,
])

@inject('site', 'App\Services\SiteService')

@php
    if ($translateText) {
        $text = __($text);
    }

    $url = '#';
    if ($anchorage) {
        $url = $anchorage;
    }

    $isActive = false;
    if ($active) {
        $isActive = true;
    } elseif ($menuActive) {
        $isActive = $site->isMenuActive($menuActive);
    }
@endphp

<li>
    <a @if (!app(\App\Services\SiteService::class)->isMenuActive('home')) href="{{ route_lang('home') . '#' . $url }}" @endif title="{{ $text }}" class="offcanvas-link px-lg-2 py-lg-3" @if (app(\App\Services\SiteService::class)->isMenuActive('home')) data-anchoring="#{{ $url }}" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasHeader" @endif>
        {{ $text }}
    </a>
</li>

@once
    @push('js')
        <script>
            let targetToScroll = null;

            @if (app(\App\Services\SiteService::class)->isMenuActive('home'))
                $(".menu a.offcanvas-link").on("click", function(e) {
                    console.log("here");
                    if ($(window).width() < 992) {
                        e.preventDefault();
                        targetToScroll = $(this).attr('data-anchoring');
                    } else {
                        $('html, body').animate({
                            scrollTop: $($(this).attr('data-anchoring')).offset().top
                        }, 1000);
                    }
                });
            @endif

            $("#offcanvasHeader").on('hidden.bs.offcanvas', function(e) {
                if ($(window).width() < 992) {
                    if (targetToScroll && targetToScroll !== '#') {
                        document.querySelector(targetToScroll).scrollIntoView({
                            behavior: 'smooth'
                        });
                    }

                    targetToScroll = null;
                }
            });
        </script>
    @endpush
@endonce
