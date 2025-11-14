@props(['name' => 'about', 'page' => null])

@if ($page->title || $page->text || $page->images->count())
    <section id="{{ $name }}" class="{{ $name }}-section py-2 py-lg-4 bg-gray">
        <div class="container">
            <div class="row justify-content-center align-items-center gap-2">
                @if ($page->images->count())
                    <div class="col-lg-5">
                        <div class="abstract-gallery-swiper pb-2">
                            <div class="swiper-wrapper">
                                @foreach ($page->images as $image)
                                    <div class="swiper-slide">
                                        <div class="ratio ratio-1x1">
                                            <img src="{{ $image->url() }}" alt="{{ $image->alt }}" class="object-fit-cover">
                                            <a href="{{ $image->url() }}" data-fancybox="image" class="stretched-link"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @endif
                @if ($page->title || $page->text)
                    <div class="col-lg-5 offset-lg-1 d-flex flex-column gap-1">
                        <div class="primary-badge">
                            <h6 class="mb-0">Sobre nós</h6>
                        </div>
                        <h2>{{ $page->title }}</h2>
                        <div class="editor-texto about-us-text">
                            {!! $page->text !!}
                        </div>
                        <a class="btn btn-gradient def-btn my-lg-2" id="button-{{ $name }}">
                            <span>Tenho interesse</span>
                            <svg width="2rem" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
