@inject('site', 'App\\Services\\SiteService')

@foreach ($site->getAlternates() as $alternate)
    <a title="{{ $alternate->getLanguage()->name_in_language }}" href="{{ $alternate->getUrl() }}">
        {{ $alternate->getLanguage()->name_in_language }}
    </a>
@endforeach
