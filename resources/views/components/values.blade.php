@props(['name' => 'values', 'page' => null])

@if (isset($page->values) && is_array($page->values) && count($page->values))
    <section id="{{ $name }}" class="{{ $name }}-section py-2 py-lg-4">
        <div class="container">
            <div class="row justify-content-center gap-2 pb-2">
                <div class="white-badge text-white">
                    <h6 class="mb-0">O que nos move</h6>
                </div>
                <h2>{{ $page->title_3 }}</h2>
                <div class="editor-texto about-us-text">
                    {!! $page->text_1 !!}
                </div>
            </div>
            <div class="row gap-1 gap-lg-0">
                @foreach ($page->values as $value)
                    <div class="col-lg-{{ 12 / count($page->values) }}">
                        <div class="value-card">
                            <h3 class="title">{{ $value['title'] }}</h3>
                            <div class="editor-texto">
                                {!! $value['text'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
