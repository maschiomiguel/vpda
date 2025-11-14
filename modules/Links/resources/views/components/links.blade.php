@props(['page'])

@if ($links->count())
    <div class="footer-links">
        <h5 class="text-white fw-bold mb-1 text-center text-lg-start">Links úteis</h5>
        <div class="d-flex flex-column gap-1">
            @foreach ($links as $link)
                <div class="d-flex flex-row gap-1 position-relative footer-link-wrapper align-items-center justify-content-center justify-content-lg-start">
                    @if($link->image->count())
                        <div class="flex-shrink-0 ratio ratio-1x1 d-none d-lg-flex" style="width: 36px; height: 36px;">
                            <img class="object-fit-contain" src="{{ $link->image->first()->url() }}"
                                alt="{{ $link->text_1 }}">
                        </div>
                    @endif
                    <div class="d-flex flex-column">
                        @if($link->text_2)
                            <a href="{{ $link->text_2 }}" class="stretched-link text-white footer-link">
                                {{ $link->text_1 }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
