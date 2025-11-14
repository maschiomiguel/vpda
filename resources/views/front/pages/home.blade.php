@extends('front.layout.app')

@section('content')
    <main id="homepage">
        <h1 class="visually-hidden">{{ config('app.name') }}</h1>

        {{-- <x-banners :page="$page" /> --}}
        
        <x-company-section :page="$page" />
        
        <x-modules-differentials::differentials :page="$page" />

        <x-modules-galleries::gallery :page="$page" />

        <x-modules-videos::video :page="$page" />

        <x-cta-section :page="$page" />

        <x-modules-testimonials::testimonials name="testimonials" :page="$page" />

    </main>
@endsection
