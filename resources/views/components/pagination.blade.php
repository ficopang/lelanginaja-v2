<!-- Pagination -->
<div class="pagination left text-primary">
    <ul class="pagination-list">
        @if ($iterables->onFirstPage())
            <!-- No previous page available -->
            <li class="disabled">
                <span><i class="bx bx-chevron-left"></i></span>
            </li>
        @else
            <!-- Previous page available -->
            <li>
                <a href="{{ $iterables->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                    <i class="bx bx-chevron-left"></i>
                </a>
            </li>
        @endif

        @foreach ($iterables->links()->elements[0] as $page => $url)
            <li class="{{ $iterables->currentPage() == $page ? 'active' : '' }}">
                <a href="{{ $url . '&' . http_build_query(request()->except('page')) }}">{{ $page }}</a>
            </li>
        @endforeach

        @if ($iterables->hasMorePages())
            <!-- Next page available -->
            <li>
                <a href="{{ $iterables->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                    <i class="bx bx-chevron-right"></i>
                </a>
            </li>
        @else
            <!-- No next page available -->
            <li class="disabled">
                <span><i class="bx bx-chevron-right"></i></span>
            </li>
        @endif
    </ul>
</div>

<!--/ End Pagination -->
