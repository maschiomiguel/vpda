@inject('site', 'App\\Services\\SiteService')

<section class="bg-light py-lg-2 py-1">
    <div class="container">
        <nav aria-label="breadcrumb" class="d-flex flex-column flex-sm-row gap-0-50 align-items-center justify-content-between">
            @if ($site->getBreadTitle())
                <h1 class="h3 mb-0">
                    {{ $site->getBreadTitle() }}
                </h1>
            @endif
            <ol class="breadcrumb">
                @foreach ($site->getBreadCrumbs() as $bread)
                    @if ($loop->last)
                        <li class="breadcrumb-item active" aria-current="{{ $bread->getText() }}">{{ $bread->getText() }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $bread->getUrl() }}">{{ $bread->getText() }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</section>
