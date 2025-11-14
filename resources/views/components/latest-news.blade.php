@if ($posts->count())
    <section class="py-2 py-lg-4">
        <div class="container">
            <h2 class="text-primary text-center mb-2 h1">
                {{ __('Últimas notícias') }}
            </h2>
            <div class="row gy-1 gy-lg-0">
                @foreach ($posts as $post)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <x-blog-card :post="$post" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
