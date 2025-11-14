@props(['page' => null])

<section class="py-5" id="company-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="section-title fw-bold text-dark mb-3">
                        {!! nl2br(e($page->title_1)) !!}
                    </h2>
                    <p class="section-subtitle text-muted">
                        {!! $page->text !!}
                    </p>
                </div>

                @if ($page->count_up != null && count($page->count_up))
                    <div class="row numbers-up g-4 justify-content-center">
                        @foreach ($page->count_up as $count_up)
                            @if ($count_up['num_target'])
                                <div class="col-md-6 col-lg-3">
                                    <div class="countup-item text-center">
                                        <div class="countup-number mb-2">
                                            <span class="number-value counter-up" 
                                                data-val="{{ $count_up['num_target'] }}"
                                                data-prefix="{{ $count_up['num_prefix'] ?? '' }}"
                                                data-suffix="{{ $count_up['num_suffix'] ?? '' }}">0</span><span class="number-suffix">{{ $count_up['num_suffix'] ?? '' }}</span>
                                        </div>
                                        <div class="countup-label">
                                            <div class="label-main">{{ $count_up['num_unity'] }}</div>
                                            @if(!empty($count_up['num_subject']))
                                                <div class="label-sub">{{ $count_up['num_subject'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('js')
    {{-- Count-ups --}}
    <script>
        const numObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        observer.unobserve(entry.target);
                        let valueDisplays = document.querySelectorAll(".counter-up");

                        valueDisplays.forEach((valueDisplay) => {
                            let startValue = 0;
                            let endValue = parseInt(valueDisplay.getAttribute("data-val"));
                            let prefix = valueDisplay.getAttribute("data-prefix") || '';
                            let suffix = valueDisplay.getAttribute("data-suffix") || '';
                            let duration = 2000; // 2 seconds
                            let interval = 50; // 50 milliseconds

                            let countPlus = endValue / (duration / interval);
                            let counter = setInterval(function() {
                                startValue += countPlus;
                                if (startValue >= endValue) {
                                    valueDisplay.textContent = prefix + numberFormat(Math.ceil(endValue));
                                    clearInterval(counter);
                                } else {
                                    valueDisplay.textContent = prefix + numberFormat(Math.ceil(startValue));
                                }
                            }, interval);
                        });
                    }
                });
            }, {
                rootMargin: "0px 0px -100px 0px",
            }
        );

        if (document.querySelector(".numbers-up")) {
            numObserver.observe(document.querySelector(".numbers-up"));
        }

        function numberFormat(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endpush
