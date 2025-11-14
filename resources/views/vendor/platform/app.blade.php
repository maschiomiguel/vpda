<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-controller="html-load" dir="{{ \Orchid\Support\Locale::currentDir() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>
        @yield('title', config('app.name'))
        @hasSection('title')
            - {{ config('app.name') }}
        @endif
    </title>
    <meta name="csrf_token" content="{{ csrf_token() }}" id="csrf_token">
    <meta name="auth" content="{{ Auth::check() }}" id="auth">
    @if (\Orchid\Support\Locale::currentDir(app()->getLocale()) == 'rtl')
        <link rel="stylesheet" type="text/css" href="{{ mix('/css/orchid.rtl.css', 'vendor/orchid') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ mix('/css/orchid.css', 'vendor/orchid') }}">
    @endif

    @stack('head')

    <meta name="turbo-root" content="{{ Dashboard::prefix() }}">
    <meta name="dashboard-prefix" content="{{ parse_url(url('/panel'), PHP_URL_PATH) }}">

    @if (!config('platform.turbo.cache', false))
        <meta name="turbo-cache-control" content="no-cache">
    @endif

    <script src="{{ mix('/js/manifest.js', 'vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js', 'vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/orchid.js', 'vendor/orchid') }}" type="text/javascript"></script>

    @foreach (Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{ $stylesheet }}">
    @endforeach


    @stack('stylesheets')

    @vite(['resources/restrita/sass/main.scss'])

    @foreach (Dashboard::getResource('scripts') as $scripts)
        <script src="{{ $scripts }}" defer type="text/javascript"></script>
    @endforeach

</head>

<body class="{{ \Orchid\Support\Names::getPageNameClass() }}" data-controller="pull-to-refresh">

    <div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

        <div class="row">
            @yield('body-left')
            <div class="col min-vh-100" style="overflow-x: clip;">
                <div class="d-flex flex-column-fluid {{ in_array(\Orchid\Support\Names::getPageNameClass(), ['page-platform-login', 'page-platform-password-send-recovery']) ? 'top-50 translate-middle-y position-relative' : '' }}">
                    <div class="container-md h-full px-0 px-md-5">
                        @yield('body-right')
                    </div>
                </div>
            </div>
        </div>


        @include('platform::partials.toast')
    </div>

    @stack('scripts')
    @vite('resources/restrita/js/dashboard.js')

</body>

</html>
<script> 
    let save_button = document.getElementById('save-button');

    if(save_button){
        document.addEventListener("keydown", 
                function (event) { 
                    if (event.ctrlKey && event.key == "Enter") { 
                        event.preventDefault();
                        save_button.click();
                    } 
                }); 
    }
</script> 
