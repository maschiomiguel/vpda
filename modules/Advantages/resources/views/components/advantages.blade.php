@props(['page'])

@if ($advantages->count())
    <section class="mt-0 py-lg-6 py-4 bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h3 class="text-primary fw-bold mb-2">{{ $page->title_10 }}</h3>
                    <h6 class="mb-4">{!! $page->text_10 !!}</h6>
                </div>
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        @foreach ($advantages as $advantage)
                            <div class="col-lg-4 d-flex gap-1 justify-content-center align-items-center">
                                @if ($advantage->image->count())
                                    <div class="ratio ratio-1x1" style="width: 80px;">
                                        <img class="object-fit-cover" src="{{ $advantage->image->first()->url() }}"
                                             alt="{{ $advantage->title_1 }}" title="{{ $advantage->title_1 }}">
                                    </div>
                                @endif
                                <div class="">
                                    <h3 class="text-primary fw-bold mb-1">{{ $advantage->name }}</h3>
                                    <h5 class="fw-bold">{{ $advantage->text_1 }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
