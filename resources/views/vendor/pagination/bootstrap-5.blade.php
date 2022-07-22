@if ($paginator->hasPages())
    <div class="d-block mt-3" role="nav">
        {{-- For Smaller Screens --}}
        <ul class="pagination d-flex d-sm-none justify-content-between">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="m-1 page-item disabled" aria-disabled="true">
                    <span class="rounded page-link rounded-3">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="m-1 page-item">
                    <a class="rounded page-link rounded-3" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="m-1 page-item">
                    <a class="rounded page-link rounded-3" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="m-1 page-item disabled" aria-disabled="true">
                    <span class="rounded page-link rounded-3">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
        <div class="d-flex justify-content-between flex-fill d-sm-none">
        </div>
        
        {{-- For Tablets and Computers --}}
        <div class="d-none d-sm-block text-center">
            <p class="small text-muted mb-1">
                <div class="mb-1 small">
                    Page 
                    {{\number_format($paginator->currentPage())}} 
                    of 
                    {{\number_format($paginator->lastPage())}}
                </div>
                <div class="mb-1 small">
                    {!! __('Showing') !!}
                    <span class="font-medium">{{ \number_format($paginator->firstItem()) }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ \number_format($paginator->lastItem()) }}</span>
                    {!! __('of') !!}
                    <span class="font-medium">{{ \number_format($paginator->total()) }}</span>
                    {!! __('results') !!}
                </div>
            </p>
            
            <div class="mx-auto">
                <ul class="pagination flex-sm-fill align-items-sm-center justify-content-sm-center flex-wrap">
                    {{-- Previous Page Link --}}
                    @if ($paginator->currentPage() > 1)
                        @if ($paginator->currentPage() > ($paginator->onEachSide + 2))
                            <li class="page-item m-1">
                                <a class="page-link rounded-3" href="{{ $paginator->url(1) }}" rel="prev" aria-label="@lang('pagination.previous')">1</a>
                            </li>
                            @if ($paginator->onEachSide <= ($paginator->currentPage() - $paginator->onEachSide))
                                @if ((($paginator->currentPage() - $paginator->onEachSide) - 1) === 2)
                                    <li class="page-item m-1">
                                        <a class="page-link rounded-3" href="{{ $paginator->url((($paginator->currentPage() - $paginator->onEachSide) - 1)) }}" rel="prev" aria-label="@lang('pagination.previous')">
                                            {{(($paginator->currentPage() - $paginator->onEachSide) - 1)}}
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item m-1" style="pointer-events: none" aria-label="@lang('pagination.previous')">
                                        <span class="page-link rounded-3" aria-hidden="true">&middot;&middot;&middot;</span>
                                    </li>
                                @endif
                            @endif
                        @endif
                    @endif
                    
                    {{-- The links --}}
                    @for ($x = ($paginator->currentPage() - $paginator->onEachSide); $x < (($paginator->currentPage() + $paginator->onEachSide) + 1 ); $x++)
                        @if ($x > 0 && $x <= $paginator->lastPage())
                            <li class="page-item m-1 @if ($x === $paginator->currentPage()) active @endif" aria-disabled="true" aria-label="Page {{$x}}">
                                @if ($x === $paginator->currentPage())
                                    <span class="page-link rounded-3" aria-hidden="true">{{$x}}</span>
                                @else
                                    <a class="page-link rounded-3" href="{{ $paginator->url($x) }}" rel="prev" aria-label="Page {{$x}}">{{$x}}</a>
                                @endif
                            </li>
                        @endif
                    @endfor
                    
                    {{-- Next Page Link --}}
                    @if ($paginator->currentPage() < $paginator->lastPage())
                        @if ($paginator->currentPage() < ($paginator->lastPage() - $paginator->onEachSide - 1))
                            @if (($paginator->currentPage() + $paginator->onEachSide) + 1 === ($paginator->lastPage() - 1))
                                <li class="page-item m-1">
                                    <a class="page-link rounded-3" href="{{ $paginator->url($paginator->lastPage() - 1) }}" rel="page" aria-label="Page {{$paginator->lastPage() - 1}}}}">
                                        {{$paginator->lastPage() - 1}}
                                    </a>
                                </li>
                            @else
                                <li class="page-item m-1" style="pointer-events: none" aria-label="More next pages">
                                    <span class="page-link rounded-3" aria-hidden="true">&middot;&middot;&middot;</span>
                                </li>
                            @endif
                            <li class="page-item m-1">
                                <a class="page-link rounded-3" href="{{ $paginator->url($paginator->lastPage()) }}" rel="last" aria-label="Last Page">
                                    {{$paginator->lastPage()}}
                                </a>
                            </li>
                        @else
                            @if ($paginator->currentPage() < ($paginator->lastPage() - $paginator->onEachSide))
                                <li class="page-item m-1">
                                    <a class="page-link rounded-3" href="{{ $paginator->url($paginator->lastPage()) }}" rel="last" aria-label="Last Page">
                                        {{$paginator->lastPage()}}
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
