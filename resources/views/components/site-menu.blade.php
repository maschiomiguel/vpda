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
    $linkClasses = $isFooter ? 'text-decoration-none' : 'd-block offcanvas-link px-lg-2 py-lg-3';
    $linkStyle = $isFooter ? 'color: #6B7280;' : '';
@endphp

@if (!$isFooter)
    <nav class="menu">
@endif
<ul class="{{ $ulClasses }}">
    @if (count(app(\Modules\Differentials\Services\DifferentialsService::class)->getDifferentials()))
        <li class="{{ $liClasses }}">
            <a href="#differentials" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                What we deliver
            </a>
        </li>
    @endif
    <li class="{{ $liClasses }}">
        <a href="#company-section" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
            Our numbers
        </a>
    </li>
    @if (app(\Modules\Galleries\Services\GalleriesService::class)->hasGalleries())
        <li class="{{ $liClasses }}">
            <a href="#instagram-gallery" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                Instagram Posts
            </a>
        </li>
    @endif
    @if (app(\Modules\Videos\Services\VideosService::class)->hasVideos())
        <li class="{{ $liClasses }}">
            <a href="#instagram-video" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                Instagram Reels
            </a>
        </li>
    @endif
    @if (app(\Modules\Questions\Services\QuestionsService::class)->hasQuestions())
        <li class="{{ $liClasses }}">
            <a href="#faq-section" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
                FAQ
            </a>
        </li>
    @endif
    <li class="{{ $liClasses }}">
        <a href="#cta-section" class="{{ $linkClasses }}" style="{{ $linkStyle }}">
            Contact us
        </a>
    </li>
</ul>
@if (!$isFooter)
    </nav>
@endif
