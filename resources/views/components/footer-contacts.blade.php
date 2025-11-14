@inject('contact', 'Modules\\Contact\\Services\\ContactService')

<ul class="mb-0 list-unstyled p-0 row g-0-50 row-cols-1 row-cols-lg-2">

    @foreach ($contact->getAdresses() as $address)
        <li class="col address">
            <a @if ($address['link']) href="{{ $address['link'] }}" target="_blank" @endif>
                <x-icons.marker class="w-1-25 h-1-25" />
                {{ $address['address'] }}
            </a>
        </li>
    @endforeach

    @foreach ($contact->getPhones() as $phone)
        <li class="col">
            <a href="tel:+{{ onlyNumbers($phone['phone_link']) }}">
                <x-icons.phone class="w-1-25 h-1-25" />
                {{ $phone['phone'] }}
            </a>
        </li>
    @endforeach

    @foreach ($contact->getWhatsapps() as $whatsapp)
        <li class="col">
            <a href="https://api.whatsapp.com/send?phone={{ onlyNumbers($whatsapp['phone_link']) }}">
                <x-icons.whatsapp id="whatsapp" class="w-1-25 h-1-25" width="1.25em" height="1.25em" />
                {{ $whatsapp['phone'] }}
            </a>
        </li>
    @endforeach

    @foreach ($contact->getEmails() as $email)
        <li class="col">
            <a href="mailto:{{ $email['email'] }}">
                <x-icons.email class="w-1-25 h-1-25" />
                {{ $email['email'] }}
            </a>
        </li>
    @endforeach
</ul>
