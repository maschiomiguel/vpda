@props(['name' => 'video', 'page' => null])

@if ($page->videoThumb()->count() && $page->call_link)
    <section id="{{ $name }}" class="{{ $name }}-section">
        <div class="p-2 p-lg-4">
            @if ($page->videoThumb()->count() && $page->call_link)
                <div class="ratio ratio-4x3 ratio-lg-21x9">
                    <img class="object-fit-cover" src="{{ $page->videoThumb()?->first()?->url() }}" alt="{{ $page->videoThumb()?->first()?->alt }}">
                    <a href="{{ $page->call_link }}" data-fancybox="homevideo" class="stretched-link"></a>
                    <div class="play-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                        </svg>
                        <div class="circle"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif
