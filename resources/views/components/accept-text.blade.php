@inject('site', 'App\\Services\\SiteService')

@if ($site->hasPrivacy())
    {!! __('site.accept-text-privacy', [
        'Link' => route_lang('privacy'),
        'Name' => config('app.name'),
    ]) !!}
@else
    {{ __('site.accept-text', ['Name' => config('app.name')]) }}
@endif
