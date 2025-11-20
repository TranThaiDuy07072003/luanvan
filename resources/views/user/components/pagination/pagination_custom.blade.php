{{-- <ul>
    <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
    <li><a href="#">1</a></li>
    <li class="active"><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">...</a></li>
    <li><a href="#">10</a></li>
    <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
</ul> --}}


@if ($paginator->hasPages())
    <ul>
        {{-- Nút Quay Lại (Previous) --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true">
                <span><i class="fas fa-angle-double-left"></i></span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-angle-double-left"></i></a>
            </li>
        @endif

        {{-- Các số trang --}}
        @foreach ($elements as $element)
            {{-- Dấu "..." (Ellipsis) --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Mảng các số trang --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Nút Tới (Next) --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-angle-double-right"></i></a>
            </li>
        @else
            <li class="disabled" aria-disabled="true">
                <span><i class="fas fa-angle-double-right"></i></span>
            </li>
        @endif
    </ul>
@endif
