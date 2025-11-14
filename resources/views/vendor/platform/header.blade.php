@php
    $auth = $auth ?? false;
@endphp

@push('head')
    <meta name="robots" content="noindex" />
    <link href="{{ asset('/favicon.ico') }}" sizes="any" id="favicon" rel="icon">

    <!-- For Safari on iOS -->
    <meta name="theme-color" content="#21252a">
@endpush

@if ($auth && File::exists(public_path(config('app.logo_auth'))))
    <img class="w-100 h-auto" style="max-width: 12rem; object-fit: contain" src="{{ asset(config('app.logo_auth')) }}" alt="">
@elseif (!$auth && File::exists(public_path(config('app.logo'))))
    <img class="w-100 h-auto" style="max-width: 12rem; object-fit: contain" src="{{ asset(config('app.logo')) }}" alt="">
@else
    <div class="h2 fw-light d-flex align-items-center">
        <p class="ms-3 my-0 d-none d-sm-block">{{ config('app.name') }}</p>
    </div>
@endif
