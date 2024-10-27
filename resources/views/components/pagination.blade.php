<!-- Pagination -->
<div class="pagination left text-primary">
    <ul class="pagination-list">
        {{-- First page link --}}
        @if (!$iterables->onFirstPage())
            <li>
                <a href="{{ $iterables->url(1) . '&' . http_build_query(request()->except('page')) }}">
                    <i class="bx bx-chevrons-left"></i>
                </a>
            </li>
        @endif

        {{-- Previous page link --}}
        @if (!$iterables->onFirstPage())
            <li>
                <a href="{{ $iterables->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                    <i class="bx bx-chevron-left"></i>
                </a>
            </li>
        @endif

        {{-- Page number links --}}
        @php
            $start = max(1, $iterables->currentPage() - 4);
            $end = min($iterables->lastPage(), $iterables->currentPage() + 4);
        @endphp

        @for ($page = $start; $page <= $end; $page++)
            <li class="{{ $iterables->currentPage() == $page ? 'active' : '' }}">
                <a
                    href="{{ $iterables->url($page) . '&' . http_build_query(request()->except('page')) }}">{{ $page }}</a>
            </li>
        @endfor

        {{-- Next page link --}}
        @if ($iterables->hasMorePages())
            <li>
                <a href="{{ $iterables->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                    <i class="bx bx-chevron-right"></i>
                </a>
            </li>
        @endif

        {{-- Last page link --}}
        @if ($iterables->hasMorePages())
            <li>
                <a
                    href="{{ $iterables->url($iterables->lastPage()) . '&' . http_build_query(request()->except('page')) }}">
                    <i class="bx bx-chevrons-right"></i>
                </a>
            </li>
        @endif
    </ul>
</div>
<!--/ End Pagination -->
