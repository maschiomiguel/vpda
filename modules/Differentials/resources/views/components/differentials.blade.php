@props([
    'page' => null,
])

@if ($differentialsSection->count())
    <section class="py-5 differentials" id="differentials">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fw-bold mb-1">
                    Our <span class="text-gradient">Process</span>
                </h2>
                <p class="section-subtitle text-muted">
                    Complete Instagram performance solutions tailored to your brand
                </p>
            </div>

            <div class="row g-4">
                @foreach ($differentialsSection as $differential)
                    <div class="col-md-6 col-lg-3">
                        <div class="differential-card h-100 p-1 p-xxl-2 rounded-4 bg-white border">
                            @if ($differential->image()->count())
                                <div class="differential-icon mb-1">
                                    <div class="icon-wrapper rounded-3 d-inline-flex align-items-center justify-content-center">
                                        <img src="{{ $differential->image()->first()->url() }}"
                                            alt="{{ $differential->text_1 }}" 
                                            title="{{ $differential->text_1 }}"
                                            class="img-fluid" 
                                            style="max-width: 48px; max-height: 48px;">
                                    </div>
                                </div>
                            @endif
                            <h3 class="differential-title h5 fw-bold mb-1 text-dark">
                                {{ $differential->text_1 }}
                            </h3>
                            <p class="differential-description mb-0 text-muted">
                                {{ $differential->text_2 }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
