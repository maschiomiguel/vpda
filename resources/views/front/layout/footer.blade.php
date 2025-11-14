@inject('contact', 'Modules\\Contact\\Services\\ContactService')

<footer id="footer" class="overflow-hidden">
    <div class="bg-light py-3">
        <div class="container">
            <div class="row g-5">
                {{-- Logo e Tagline --}}
                <div class="col-12 col-lg-4">
                    <a class="d-inline-block mb-3" href="{{ route_lang('home') }}" title="Página principal">
                        <img style="max-width: 100px;" src="{{ app(\App\Services\SiteService::class)->getSiteLogo() }}"
                            alt="Logo {{ config('app.name') }}" title="Logo {{ config('app.name') }}">
                    </a>
                    <p class="text-muted mb-0" style="color: #6B7280;">Transform your Instagram presence with data-driven content strategy.</p>
                </div>

                {{-- Company --}}
                <div class="col-12 col-lg-4">
                    <h5 class="fw-bold mb-1" style="color: #111827;">Fast links</h5>
                    <x-site-menu variant="footer" />
                </div>

                {{-- Get in Touch --}}
                <div class="col-12 col-lg-4">
                    <h5 class="fw-bold mb-1" style="color: #111827;">Get in Touch</h5>
                    <div class="d-flex flex-column gap-0-50">
                        @if (count($contact->getPhones()) > 0)
                            @php $phone = $contact->getPhones()[0]; @endphp
                            <a href="tel:{{ $phone['phone_link'] }}" class="text-decoration-none d-flex align-items-center gap-0-50" style="color: #6B7280;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4742 21.8325 20.7293C21.7209 20.9845 21.5573 21.2136 21.3521 21.4019C21.1468 21.5901 20.9046 21.7335 20.6407 21.8227C20.3769 21.9119 20.0974 21.9451 19.82 21.92C16.7428 21.5856 13.787 20.5341 11.19 18.85C8.77382 17.3147 6.72533 15.2662 5.18999 12.85C3.49997 10.2412 2.44824 7.27097 2.11999 4.18C2.095 3.90347 2.12787 3.62476 2.21649 3.36162C2.30512 3.09849 2.44756 2.85669 2.63476 2.65162C2.82196 2.44655 3.0498 2.28271 3.30379 2.17052C3.55777 2.05833 3.83233 2.00026 4.10999 2H7.10999C7.5953 1.99522 8.06579 2.16708 8.43376 2.48353C8.80173 2.79999 9.04207 3.23945 9.10999 3.72C9.23662 4.68007 9.47144 5.62273 9.80999 6.53C9.94454 6.88792 9.97366 7.27691 9.8939 7.65088C9.81415 8.02485 9.62886 8.36811 9.35999 8.64L8.08999 9.91C9.51355 12.4135 11.5864 14.4864 14.09 15.91L15.36 14.64C15.6319 14.3711 15.9751 14.1858 16.3491 14.1061C16.7231 14.0263 17.1121 14.0555 17.47 14.19C18.3773 14.5286 19.3199 14.7634 20.28 14.89C20.7658 14.9585 21.2094 15.2032 21.5265 15.5775C21.8437 15.9518 22.0122 16.4296 22 16.92Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $phone['phone'] }}</span>
                            </a>
                        @endif

                        @if (count($contact->getEmails()) > 0)
                            @php $email = $contact->getEmails()[0]; @endphp
                            <a href="mailto:{{ $email['email'] }}" class="text-decoration-none d-flex align-items-center gap-0-50" style="color: #6B7280;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $email['email'] }}</span>
                            </a>
                        @endif

                        @php
                            $instagram = $contact->getSocial('instagram');
                            $instagramUsername = $contact->getSocial('instagram_username');
                            $facebook = $contact->getSocial('facebook');
                            $facebookUsername = $contact->getSocial('facebook_username');
                            $linkedin = $contact->getSocial('linkedin');
                            $linkedinUsername = $contact->getSocial('linkedin_username');
                        @endphp

                        @if ($instagram && $instagramUsername)
                            <a href="{{ $instagram }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-0-50" style="color: #6B7280;">
                                <x-icons.instagram width="20" height="20" />
                                <span>{{ $instagramUsername }}</span>
                            </a>
                        @endif

                        @if ($facebook && $facebookUsername)
                            <a href="{{ $facebook }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-0-50" style="color: #6B7280;">
                                <x-icons.facebook width="20" height="20" />
                                <span>{{ $facebookUsername }}</span>
                            </a>
                        @endif

                        @if ($linkedin && $linkedinUsername)
                            <a href="{{ $linkedin }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-0-50" style="color: #6B7280;">
                                <x-icons.linkedin width="20" height="20" />
                                <span>{{ $linkedinUsername }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-light pb-1">
        <div class="container">
            <div class="text-center">
                <small style="color: #6B7280;">
                    &copy; {{ date('Y') }} VPdA Marketing Agency. All rights reserved.
                </small>
            </div>
        </div>
    </div>
</footer>

{{-- Whatsapp fixed button --}}
{{-- <x-whatsapp-fixed /> --}}

{{-- Site fixed button --}}
{{-- <x-button-fixed /> --}}

@if (strpos(Request::fullUrl(), 'projetos.ellite.local') === false)
    {{-- GTM AQUI --}}
@endif

{{-- Jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
    integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Swiper.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.2.0/swiper-bundle.min.js"
    integrity="sha512-KBCt3sdFOcFtYTgEfE3uJckVpvPr1w8HPugyPgHFE/4iJOwhwj6eSaF27bDJTHRX2jyAFOgV3Ve9vOD97rbjrg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Fancybox --}}
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

{{-- GSAP (caso necessário) --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script> --}}

{{-- AOS --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init();
</script>

{{-- Front js --}}
@vite(['resources/front/js/vendors/bootstrap.bundle.min.js', 'resources/front/js/main.js'])

@stack('js')

@livewireScripts

@stack('js-post-livewire')

</body>

</html>
