@extends('front.layout.app')

@section('content')

    @inject('site', 'App\\Services\\SiteService')

    @if ($page->text)
        <main id="empresa">
            <section class="empresa pb-2">
                <div class="container py-lg-4 py-2">
                    <div class="row">
                        <div class="col-lg-12 conteudo d-flex align-items-center py-4 py-sm-4 py-md-4 py-lg-0 py-xl-0 py-xxl-0">
                            <div class="row">
                                <div class="col-12 p px-xl-4 px-lg-2 ">
                                    {!! $privacyText !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @endif
@endsection
