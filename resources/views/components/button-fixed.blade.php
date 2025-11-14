@inject('contact', 'Modules\\Contact\\Services\\ContactService')

@if ($contact->getLink('sitelink'))
    <div class="display-fixed">
        <div class="button-fixed" type="button" title="Veja os produtos no site">
            <x-icons.site-link />
            <span> Ver produtos no site </span>
            <a class="stretched-link" target="_blank"
               href="{{ $contact->getLink('sitelink') ?? 'https://www.ellitedigital.com.br/' }}">
            </a>
        </div>
    </div>

    @push('js')
        <script>
            function hideLabel() {
                $('.button-fixed').hide();
            }
        </script>
    @endpush
@endif
