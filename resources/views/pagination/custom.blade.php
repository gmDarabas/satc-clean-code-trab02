@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <div class="pagination-info">
            <p>
                Mostrando {{ $paginator->firstItem() }} até {{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados
            </p>
        </div>

        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">« Anterior</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">« Anterior</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Próximo »</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Próximo »</span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination-info {
            text-align: center;
            margin-bottom: 1rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .page-item {
            display: inline-block;
        }

        .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            color: #374151;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .page-link:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
            color: #111827;
        }

        .page-item.active .page-link {
            background: #3182ce;
            border-color: #3182ce;
            color: white;
        }

        .page-item.active .page-link:hover {
            background: #2c5282;
            border-color: #2c5282;
        }

        .page-item.disabled .page-link {
            color: #9ca3af;
            background: #f9fafb;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }

        .page-item.disabled .page-link:hover {
            background: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .pagination {
                flex-wrap: wrap;
                gap: 0.125rem;
            }

            .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
@endif
