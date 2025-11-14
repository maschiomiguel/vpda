@if ($paginator->hasPages())
    <ul class="pagination">

        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="{{ __('Ir para a primeira página') }}" title="{{ __('Ir para a primeira página') }}">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.7779 1.22719C14.4817 0.92427 14.0015 0.92427 13.7054 1.22719L8.66638 6.38154C7.77809 7.29015 7.77786 8.76311 8.66577 9.67206L13.6485 14.7728C13.9447 15.0757 14.4249 15.0757 14.721 14.7728C15.0172 14.4699 15.0172 13.9787 14.721 13.6757L9.73698 8.57763C9.44076 8.27463 9.44076 7.78352 9.73698 7.48059L14.7779 2.32431C15.074 2.02131 15.074 1.53019 14.7779 1.22719Z" fill="currentColor" />
                        <path d="M7.77788 1.22719C7.48171 0.92427 7.00154 0.92427 6.70537 1.22719L1.66638 6.38154C0.778091 7.29015 0.777863 8.76311 1.66577 9.67206L6.64853 14.7728C6.9447 15.0757 7.42488 15.0757 7.72104 14.7728C8.0172 14.4699 8.0172 13.9787 7.72104 13.6757L2.73698 8.57763C2.44076 8.27463 2.44076 7.78352 2.73698 7.48059L7.77788 2.32431C8.07404 2.02131 8.07404 1.53019 7.77788 1.22719Z" fill="currentColor" />
                    </svg>
                </a>
            </li>

            {{-- <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __("Ir para a página anterior") }}" title="{{ __("Ir para a página anterior") }}">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7779 1.22719C10.4817 0.92427 10.0015 0.92427 9.70537 1.22719L4.66638 6.38154C3.77809 7.29015 3.77786 8.76311 4.66577 9.67206L9.64853 14.7728C9.9447 15.0757 10.4249 15.0757 10.721 14.7728C11.0172 14.4699 11.0172 13.9787 10.721 13.6757L5.73698 8.57763C5.44076 8.27463 5.44076 7.78352 5.73698 7.48059L10.7779 2.32431C11.074 2.02131 11.074 1.53019 10.7779 1.22719Z" fill="currentColor" />
                    </svg>
                </a>
            </li> --}}
        @endif

        @php
            $pages = $paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2));
        @endphp

        @foreach ($pages as $page => $url)
            <li class="page-item {{ $page != $paginator->currentPage() ?: 'active' }}">
                <a href="{{ $url }}" class="page-link">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        @if ($paginator->hasMorePages())
            {{-- <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __("Ir para a próxima página") }}" title="{{ __("Ir para a próxima página") }}">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.22212 14.7728C4.51829 15.0757 4.99846 15.0757 5.29463 14.7728L10.3336 9.61846C11.2219 8.70985 11.2221 7.23689 10.3342 6.32794L5.35147 1.22721C5.0553 0.924263 4.57512 0.924263 4.27896 1.22721C3.9828 1.53015 3.9828 2.02132 4.27896 2.32426L9.26302 7.42237C9.55924 7.72537 9.55924 8.21648 9.26302 8.51941L4.22212 13.6757C3.92596 13.9787 3.92596 14.4698 4.22212 14.7728Z" fill="currentColor" />
                    </svg>
                </a>
            </li> --}}

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="{{ __('Ir para a última página') }}" title="{{ __('Ir para a última página') }}">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.22212 14.7728C1.51829 15.0757 1.99846 15.0757 2.29463 14.7728L7.33362 9.61846C8.22191 8.70985 8.22214 7.23689 7.33423 6.32794L2.35147 1.22721C2.0553 0.924263 1.57512 0.924263 1.27896 1.22721C0.9828 1.53015 0.9828 2.02132 1.27896 2.32426L6.26302 7.42237C6.55924 7.72537 6.55924 8.21648 6.26302 8.51941L1.22212 13.6757C0.92596 13.9787 0.92596 14.4698 1.22212 14.7728Z" fill="currentColor" />
                        <path d="M8.22212 14.7728C8.51829 15.0757 8.99846 15.0757 9.29463 14.7728L14.3336 9.61846C15.2219 8.70985 15.2221 7.23689 14.3342 6.32794L9.35147 1.22721C9.0553 0.924263 8.57512 0.924263 8.27896 1.22721C7.9828 1.53015 7.9828 2.02132 8.27896 2.32426L13.263 7.42237C13.5592 7.72537 13.5592 8.21648 13.263 8.51941L8.22212 13.6757C7.92596 13.9787 7.92596 14.4698 8.22212 14.7728Z" fill="currentColor" />
                    </svg>
                </a>
            </li>
        @endif
    </ul>
@endif
