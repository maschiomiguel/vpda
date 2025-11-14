@props(['type'])
{{-- type: head ou body --}}
@inject('site', 'App\\Services\\SiteService')

@if ($type === 'head')
    @if ($site->getCustomJsHead())
        {!! $site->getCustomJsHead() !!}
    @endif
@endif
@if ($type === 'body')
    @if ($site->getCustomJsBody())
        {!! $site->getCustomJsBody() !!}
    @endif
@endif
