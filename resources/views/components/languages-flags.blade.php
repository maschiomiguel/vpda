@inject('site', 'App\\Services\\SiteService')

@if ($site->getAlternates()->count() > 1)
    @foreach ($site->getAlternates() as $alternate)
        <a title="{{ $alternate->getLanguage()->name_in_language }}" href="{{ $alternate->getUrl() }}" class="p-0">
            {{-- $alternate->getLanguage()->name_in_language --}}
            <img src="{{ url("/flags/" . $alternate->getLanguage()->locale . ".png") }}" style="max-width: 25px;">
        </a>
    @endforeach
@endif
