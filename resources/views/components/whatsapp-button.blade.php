@inject('contact', 'Modules\\Contact\\Services\\ContactService')

@props([
    'text' => 'Fale conosco',
    'param' => '',
    'class' => '',
    'id' => 'whatsapp-button',
    'link' => null,
])

{{-- param --}}

@if (count($contact->getWhatsapps()))
    @php
        $whatsapp = $contact->getWhatsapps()[0]['phone_link'];
    @endphp
    <a onclick="clicarBotaoRd(event)" href="{{ $link ?: 'https://api.whatsapp.com/send?phone=' . $whatsapp }}" type="button"
        class="btn btn-primary text-white {{ $class }} w-fit"
        id="{{ $id }}" target="_blank">
        <span class="m-0">
            {{ $text }}
        </span>
    </a>
@endif
