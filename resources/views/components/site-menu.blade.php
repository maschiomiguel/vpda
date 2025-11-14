@props(['variant' => 'header'])

@inject('site', 'App\Services\SiteService')
@inject('page', 'Modules\PageHome\Services\PageHomeService')
@php
    $page = $page->getPage();
    $isFooter = $variant === 'footer';
    $ulClasses = $isFooter 
        ? 'list-unstyled mb-0' 
        : 'mt-2 mt-lg-0 mb-0 list-unstyled d-flex flex-column flex-lg-row align-items-center gap-2 gap-lg-0';
    $liClasses = $isFooter ? 'mb-0-50' : '';
    $linkClasses = $isFooter 
        ? 'text-decoration-none' 
        : 'd-block offcanvas-link px-lg-2 py-lg-3';
    $linkStyle = $isFooter ? 'color: #6B7280;' : '';
@endphp

@if (!$isFooter)
    <nav class="menu">
@endif
        <ul class="{{ $ulClasses }}">
            <li class="{{ $liClasses }}">
                <a href="#company-section" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                    About Us
                </a>
            </li>
            @if (count(app(\Modules\Differentials\Services\DifferentialsService::class)->getDifferentials()))
                <li class="{{ $liClasses }}">
                    <a href="#differentials" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                        Case Studies
                    </a>
                </li>
            @endif
            <li class="{{ $liClasses }}">
                <a href="#cta-section" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                    Pricing
                </a>
            </li>
            @if (count(app(\Modules\Testimonials\Services\TestimonialsService::class)->getTestimonials()))
                <li class="{{ $liClasses }}">
                    <a href="#testimonials" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                        Contact
                </a>
                </li>
            @endif
            @if (app(\Modules\Galleries\Services\GalleriesService::class)->hasGalleries())
                <li class="{{ $liClasses }}">
                    <a href="#instagram-gallery" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                        Instagram Posts
                    </a>
                </li>
            @endif
            @if (!$isFooter && $page->call_text_link)
                <li>
                    <a class="d-block offcanvas-link px-lg-2 py-lg-3" href="{{ $page->call_text_link }}">
                        Central do assinante
                    </a>
                </li>
            @endif
        </ul>
@if (!$isFooter)
    </nav>
@endif
