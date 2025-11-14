@props(['page' => null])

<section class="mt-0 py-lg-4 py-2 bg-differentials" id="home-gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto text-center">
                <h3 class=" text-white w-100 fw-bold mb-1 font-barlow">
                    {!! $page->title_2 !!}
                </h3>
            </div>
        </div>
        <div class="row mt-lg-3 mt-1">
            @if ($page->images->count())
                <div class="col-lg-12">
                    <div class="swiper-projects pb-2 position-relative">
                        <div class="swiper-wrapper">
                            @foreach ($page->images as $index => $image)
                                <div class="swiper-slide">
                                    <a href="{{ $image->url() }}" data-fancybox="gallery"
                                        data-caption="{{ $image->description }}">
                                        <div class="ratio ratio-16x9">
                                            <img class="object-fit-cover rounded-20" src="{{ $image->url() }}"
                                                alt="{{ $image->title }}">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination pagination-white"></div>
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex flex-column flex-lg-row justify-content-evenly align-items-center mt-1">
            <div class="text-white text-center text-lg-start h5">
                {!! nl2br(e($page->text_5)) !!}
            </div>
            <a onclick="clicarBotaoRd(event)" href="{{ $page->call_link_1 ?: firstWhatsAppUrl() }}" class="mx-auto btn-section mx-lg-0 d-inline-block text-center fw-bold"
                style="min-width: 300px; padding: 10px 0; border-radius: 100px; background: #fff; color: #159947; font-size: 16px; box-shadow: none; border: none; text-decoration: none; transition: background 0.2s;">
                {{ $page->call_text_1 }}
            </a>
        </div>
    </div>
</section>
