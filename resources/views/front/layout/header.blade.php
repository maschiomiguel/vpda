<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <x-custom-code type="head" />

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Miguel Maschio">

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

    @if (!app(\App\Services\SiteService::class)->isMenuActive('home'))
        <x-breadcrumbs />
    @endif
