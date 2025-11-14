@inject('contact', 'Modules\\Contact\\Services\\ContactService')

@php
    $socials = array_filter([
        'facebook' => $contact->getSocial('facebook'),
        'instagram' => $contact->getSocial('instagram'),
        'youtube' => $contact->getSocial('youtube'),
        'linkedin' => $contact->getSocial('linkedin'),
    ]);
@endphp

@if (count($socials))
    <ul class="list-unstyled mb-0 p-0 d-flex flex-lg-column gap-0-50 justify-content-center align-items-center">
        @foreach ($socials as $icon => $link)
            <li>
                <a href="{{ $link }}" class="d-flex" target="_blank" rel="noopener nofollow noreferer noreferrer">
                    <x-dynamic-component :component="'icons.' . $icon" class="w-1-50 h-1-50" />
                </a>
            </li>
        @endforeach
    </ul>
@endif
