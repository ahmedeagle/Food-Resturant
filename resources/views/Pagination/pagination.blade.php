

@if ($paginator->hasPages())
<nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
    <ul class="pagination pr-0">
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                href="{{ $paginator->previousPageUrl() }}">السابق</a>
            </li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <span>...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                               href="">{{ $page }}</a>
                        </li>
                    @else

                        <li class="page-item">
                            <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                               href="{{ $url }}">{{ $page }}</a>
                        </li>

                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                   href="{{ $paginator->nextPageUrl() }}">التالي</a>
            </li>
        @endif
    </ul>
</nav>
@endif



    
    
    
    
    