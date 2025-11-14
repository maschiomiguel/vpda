<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <x-custom-code type="head" />

    @if (strpos(Request::fullUrl(), 'projetos.ellite.local') === false)
        {{-- GTM AQUI --}}
    @endif

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agência Ellite Digital">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('front/images/favicons/favicon-48x48.png') }}" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('front/images/favicons/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('front/images/favicons/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/images/favicons/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('front/images/favicons/site.webmanifest') }}" />

    {{-- Fontes principais --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@100;200;300;400;500;600;700;800;900&family=Poppins:wght@400;500;700&family=Barlow+Semi+Condensed:wght@400;700&display=swap" rel="stylesheet">
    {{-- Swiper.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.2.0/swiper-bundle.min.css"
          integrity="sha512-Ja1oxinMmERBeokXx+nbQVVXeNX771tnUSWWOK4mGIbDAvMrWcRsiteRyTP2rgdmF8bwjLdEJADIwdMXQA5ccg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Fancybox --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Front css --}}
    @vite(['resources/front/sass/vendors/bootstrap/bootstrap.scss', 'resources/front/sass/main.scss'])

    <x-head-tags />
    @livewireStyles
</head>

<body>

    {{-- <x-custom-color /> --}}

    <x-custom-code type="body" />

    <header
            class="header w-100 isolation-isolate position-{{ app(\App\Services\SiteService::class)->isMenuActive('home') ? 'absolute' : '' }} top-0 start-0 w-100 py-2 py-lg-0">
        <div class="container">
            <div
                 class="d-flex flex-row {{ app(\App\Services\SiteService::class)->isMenuActive('home') ? 'align-items-center' : 'justify-content-center py-1 py-lg-2' }}">
                <div class="col-auto">
                    <a class="d-flex header-logo top-lg-3 position-relative" href="{{ route_lang('home') }}" title="Página principal">
                        <img class="w-100 h-100 object-fit-contain" style="max-width: 159px"
                             src="{{ app(\App\Services\SiteService::class)->getSiteLogo() }}"
                             alt="Logo {{ config('app.name') }}" title="Logo {{ config('app.name') }}">
                    </a>
                </div>

                @if (app(\App\Services\SiteService::class)->isMenuActive('home'))
                    <div class="col-auto ms-auto">

                        {{-- Botão mobile --}}
                        <button class="d-lg-none btn p-0" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasHeader" aria-controls="offcanvasHeader">
                            <x-icons.menu-bars class="menu-bars text-white" />
                        </button>

                        <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="offcanvasHeader"
                             aria-labelledby="offcanvasHeaderLabel">
                            <div class="offcanvas-header d-flex justify-content-center position-relative">
                                <a class="d-flex d-lg-none header-logo" title="Página principal">
                                    <img class="w-100 h-100 object-fit-contain"
                                         src="{{ app(\App\Services\SiteService::class)->getSiteLogo() }}"
                                         alt="Logo {{ config('app.name') }}" title="Logo {{ config('app.name') }}">
                                </a>
                                <button type="button"
                                        class="btn-close btn-close-white position-absolute absolute-offcanvas-btn"
                                        data-bs-dismiss="offcanvas" data-bs-target="#offcanvasHeader"
                                        aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="">
                                    <x-site-menu />
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </header>

    @if (!app(\App\Services\SiteService::class)->isMenuActive('home'))
        <x-breadcrumbs />
    @endif
