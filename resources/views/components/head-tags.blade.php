@inject('site', 'App\\Services\\SiteService')

{{-- title do site, bota o nome do site no final --}}
<title>
    @if ($site->getTitle())
        {{ $site->getTitle() }} |
    @endif
    {{ config('app.name') }}
</title>

{{-- meta tags do site --}}
@foreach ($site->getMetaTags() as $meta_tag)
    <meta @foreach($meta_tag->getAttributes() as $attribute => $value) {!! $attribute !!}="{{ $value }}" @endforeach>
@endforeach

{{-- tags de alternate, quando tem mais de um idioma --}}
@foreach ($site->getAlternates(false) as $alternate)
    <link rel="alternate" hreflang="{{ $alternate->getLanguage()->locale }}" href="{{ $alternate->getUrl() }}" />
@endforeach

@if($site->getCanonical())
    <link rel="canonical" href="{{ $site->getCanonical() }}" />
@endif
