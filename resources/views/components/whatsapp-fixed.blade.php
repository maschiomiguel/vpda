@inject('contact', 'Modules\\Contact\\Services\\ContactService')

@if (count($contact->getWhatsapps()) > 1)
    <div class="whatsapp-form-wrapper position-fixed bottom-0 end-0 m-1" style="z-index: 999;">
        <button class="btn btn-whatsapp d-flex align-items-center gap-0-50" type="button" title="Fale conosco através do WhatsApp">
            <x-icons.whatsapp class="z-index-1 position-relative" id="whatsapp" width="1.75em" height="1.75em" />
        </button>
        <div class="whatsapp-form w-max position-absolute end-0 bottom-0" id="whatsapp-form">
            <form class="d-flex flex-column w-auto" method="post" action="">
                <div class="d-flex align-items-center w-100 whatsapp-form-header ps-1 gap-1">
                    <h4 class="fw-bold mb-0 h6 text-white">
                        Entre em contato!
                    </h4>
                    <button type="button" class="btn whatsapp-form-close text-white ms-auto p-0-50">
                        <x-icons.close width="1.5em" height="1.5em" />
                    </button>
                </div>
                <div class="p-1 bg-white d-flex flex-column gap-0-50">
                    @foreach ($contact->getWhatsapps() as $whatsapp)
                        <a href="https://api.whatsapp.com/send?phone={{ onlyNumbers($whatsapp['phone_link']) }}" class="btn-whatsapp-anchor d-lg-none" target="_blank">{{ $whatsapp['phone'] }}</a>
                        <a href="https://web.whatsapp.com/send?phone={{ onlyNumbers($whatsapp['phone_link']) }}" class="btn-whatsapp-anchor d-none d-lg-block" target="_blank">{{ $whatsapp['phone'] }}</a>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
@elseif(count($contact->getWhatsapps()) === 1)
    <a href="https://api.whatsapp.com/send?phone={{ onlyNumbers($contact->getWhatsapps()[0]['phone_link']) }}" target="_blank" class="btn btn-whatsapp fixed d-flex d-lg-none" title="Fale conosco através do WhatsApp">
        <x-icons.whatsapp class="z-index-1 position-relative" id="whatsapp" width="1.75em" height="1.75em" />
    </a>
    <a href="https://web.whatsapp.com/send?phone={{ onlyNumbers($contact->getWhatsapps()[0]['phone_link']) }}" target="_blank" class="btn btn-whatsapp fixed d-none d-lg-flex" title="Fale conosco através do WhatsApp">
        <x-icons.whatsapp class="z-index-1 position-relative" id="whatsapp" width="1.75em" height="1.75em" />
    </a>
@endif
