@extends('layouts.app')

@section('title', 'Lista de Torrents')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-between align-center">
                <h2>Torrents Disponíveis ({{ $torrents->total() }})</h2>
                <a href="{{ route('torrents.create') }}" class="btn btn-primary">
                    Adicionar Torrent
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Filtros -->
            <form method="GET" class="mb-4" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: end;">
                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Buscar:</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nome ou descrição..." class="form-control">
                </div>

                <div style="min-width: 150px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Ordenar por:</label>
                    <select name="order" class="form-control">
                        <option value="created_at" {{ request('order') == 'created_at' ? 'selected' : '' }}>Data</option>
                        <option value="nome" {{ request('order') == 'nome' ? 'selected' : '' }}>Nome</option>
                        <option value="downloads" {{ request('order') == 'downloads' ? 'selected' : '' }}>Downloads</option>
                        <option value="tamanho" {{ request('order') == 'tamanho' ? 'selected' : '' }}>Tamanho</option>
                        <option value="seeds" {{ request('order') == 'seeds' ? 'selected' : '' }}>Seeds</option>
                    </select>
                </div>

                <div style="min-width: 100px;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Direção:</label>
                    <select name="direction" class="form-control">
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>↓ Desc</option>
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>↑ Asc</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('torrents.index') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </form>

            <!-- Lista de Torrents -->
            @if($torrents->count() > 0)
                <div class="torrents-grid">
                    @foreach($torrents as $torrent)
                        <div class="torrent-card">
                            <div class="torrent-header">
                                <h3 class="torrent-title">
                                    <a href="{{ route('torrents.show', $torrent) }}">{{ $torrent->nome }}</a>
                                </h3>
                                <div class="torrent-stats">
                                    <span class="stat seeds" title="Seeds">🟢 {{ $torrent->seeds }}</span>
                                    <span class="stat leechers" title="Leechers">🔴 {{ $torrent->leechers }}</span>
                                    <span class="stat downloads" title="Downloads">⬇️ {{ $torrent->downloads }}</span>
                                </div>
                            </div>

                            @if($torrent->descricao)
                                <p class="torrent-description">{{ Str::limit($torrent->descricao, 100) }}</p>
                            @endif

                            <div class="torrent-info">
                                <div class="info-row">
                                    <span><strong>Tamanho:</strong> {{ $torrent->getTamanhoFormatado() }}</span>
                                    <span><strong>Enviado por:</strong> {{ $torrent->user->name }}</span>
                                </div>

                                @if($torrent->pastas->count() > 0)
                                    <div class="info-row">
                                        <strong>Pastas:</strong>
                                        @foreach($torrent->pastas as $pasta)
                                            <span class="pasta-tag">{{ $pasta->nome }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="info-row">
                                    <small style="color: #6b7280;">
                                        Adicionado em {{ $torrent->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>

                            <div class="torrent-actions">
                                <a href="{{ route('torrents.download', $torrent) }}"
                                   class="btn btn-primary btn-sm">
                                    ⬇️ Download
                                </a>
                                <a href="{{ route('torrents.show', $torrent) }}"
                                   class="btn btn-secondary btn-sm">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="pagination-wrapper">
                    {{ $torrents->links('pagination.custom') }}
                </div>
            @else
                <div class="empty-state">
                    <p>Nenhum torrent encontrado.</p>
                    @if(request()->hasAny(['search', 'pasta', 'order']))
                        <a href="{{ route('torrents.index') }}" class="btn btn-secondary">Ver todos os torrents</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <style>
        .torrents-grid {
            display: grid;
            gap: 1.5rem;
        }

        .torrent-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            background: white;
            transition: box-shadow 0.2s;
        }

        .torrent-card:hover {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .torrent-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .torrent-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .torrent-title a {
            color: #1f2937;
            text-decoration: none;
        }

        .torrent-title a:hover {
            color: #3182ce;
        }

        .torrent-stats {
            display: flex;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .stat {
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .torrent-description {
            color: #6b7280;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .torrent-info {
            margin-bottom: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .pasta-tag {
            background: #e0e7ff;
            color: #3730a3;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-right: 0.5rem;
        }

        .torrent-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination-wrapper {
            margin-top: 2rem;
            text-align: center;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .torrent-header {
                flex-direction: column;
                align-items: stretch;
            }

            .torrent-stats {
                justify-content: flex-start;
            }

            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
    </style>
@endsection
