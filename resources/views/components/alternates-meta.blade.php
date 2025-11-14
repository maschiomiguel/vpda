@inject('alternates', 'App\\Services\\AlternatesService')

@foreach ($alternates->getAlternates(false) as $alternate)
    <link rel="alternate" hreflang="{{ $alternate->getLanguage()->locale }}" href="{{ $alternate->getUrl() }}" />
@endforeach
