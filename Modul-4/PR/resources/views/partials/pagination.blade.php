{{-- Pagination polos, tanpa CSS framework / icon library apa pun. --}}
@if ($paginator->hasPages())
    <nav class="simple-pagination">
        @if ($paginator->onFirstPage())
            <span class="page-link disabled">&laquo; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link">&laquo; Sebelumnya</a>
        @endif

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="page-link active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link">Berikutnya &raquo;</a>
        @else
            <span class="page-link disabled">Berikutnya &raquo;</span>
        @endif
    </nav>
@endif
