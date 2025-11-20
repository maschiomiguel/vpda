@props(['page'])

@if ($advantages->count())
    <section class="advantages-section mt-0 py-lg-6 py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center mb-2">
                    <h2 class="advantages-title fw-bold mb-3">Why Choose Instagram</h2>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($advantages as $index => $advantage)
                    <div class="col-lg-4 col-md-6">
                        <div class="advantage-card card h-100 border-0 shadow-sm" style="background-color: {{ $advantage->color_code ?? '#e3f2fd' }};">
                            <div class="card-body p-4">
                                @if ($advantage->image->count())
                                    <div class="advantage-image-wrapper d-flex justify-content-center mb-4">
                                        <div class="advantage-image-container bg-white d-flex align-items-center justify-content-center p-3">
                                            <img src="{{ $advantage->image->first()->url() }}" 
                                                 alt="{{ $advantage->title_1 }}" 
                                                 title="{{ $advantage->title_1 }}"
                                                 class="advantage-image">
                                        </div>
                                    </div>
                                @endif
                                <h4 class="advantage-card-title fw-bold mb-3">{{ $advantage->name }}</h4>
                                <div class="advantage-card-text text-muted mb-3">{!! $advantage->text_1 !!}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="#contact" class="advantage-cta-btn btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">
                        Book a Call 
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="advantage-cta-arrow">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
