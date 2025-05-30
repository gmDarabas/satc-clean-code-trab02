@extends('layouts.app')

@section('title', 'Minhas Pastas')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-between align-center">
                <div>
                    <h2>Minhas Pastas</h2>
                    @if($pastaPai)
                        <p style="color: #6b7280; margin: 0.5rem 0 0 0;">
                            Pasta atual: <strong>{{ $pastaPai->nome }}</strong>
                        </p>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    @if($pastaPai)
                        <a href="{{ route('pastas.create', ['pastaPai' => $pastaPai->id]) }}"
                           class="btn btn-secondary">
                            📁 Nova Subpasta
                        </a>
                    @else
                        <a href="{{ route('pastas.create') }}" class="btn btn-secondary">
                            📁 Nova Pasta
                        </a>
                    @endif
                    <a href="{{ route('torrents.index') }}" class="btn btn-primary">
                        🏠 Ver Torrents
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Breadcrumb -->
            @if($breadcrumb->count() > 0 || $pastaPai)
                <nav class="breadcrumb-nav">
                    <a href="{{ route('pastas.index') }}" class="breadcrumb-link">
                        🏠 Início
                    </a>
                    @foreach($breadcrumb as $item)
                        <span class="breadcrumb-separator">></span>
                        <a href="{{ route('pastas.index', ['pastaPai' => $item['id']]) }}"
                           class="breadcrumb-link">
                            📁 {{ $item['nome'] }}
                        </a>
                    @endforeach
                </nav>
            @endif

            <!-- Filtros -->
            <form method="GET" class="mb-4" style="display: flex; gap: 1rem; align-items: end;">
                @if($pastaPai)
                    <input type="hidden" name="pastaPai" value="{{ $pastaPai->id }}">
                @endif

                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Buscar pasta:</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nome ou descrição..." class="form-control">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    @if(request()->hasAny(['search']))
                        <a href="{{ request()->url() }}{{ $pastaPai ? '?pastaPai=' . $pastaPai->id : '' }}"
                           class="btn btn-secondary">Limpar</a>
                    @endif
                </div>
            </form>

            <!-- Navegação para pasta pai -->
            @if($pastaPai && $pastaPai->pastaPai)
                <div class="navigation-actions mb-3">
                    <a href="{{ route('pastas.index', ['pastaPai' => $pastaPai->pastaPai->id]) }}"
                       class="btn btn-secondary">
                        ⬆️ Voltar para {{ $pastaPai->pastaPai->nome }}
                    </a>
                </div>
            @elseif($pastaPai)
                <div class="navigation-actions mb-3">
                    <a href="{{ route('pastas.index') }}" class="btn btn-secondary">
                        ⬆️ Voltar para Raiz
                    </a>
                </div>
            @endif

            <!-- Lista de Pastas -->
            @if($pastas->count() > 0)
                <div class="pastas-grid">
                    @foreach($pastas as $pasta)
                        <div class="pasta-card" onclick="navegarPasta({{ $pasta->id }})">
                            <div class="pasta-icon">
                                📁
                            </div>

                            <div class="pasta-info">
                                <h3 class="pasta-nome">{{ $pasta->nome }}</h3>

                                @if($pasta->descricao)
                                    <p class="pasta-descricao">{{ Str::limit($pasta->descricao, 80) }}</p>
                                @endif

                                <div class="pasta-stats">
                                <span class="stat">
                                    📁 {{ $pasta->subpastas->count() }} subpasta(s)
                                </span>
                                    <span class="stat">
                                    📄 {{ $pasta->arquivos->count() }} arquivo(s)
                                </span>
                                </div>

                                <div class="pasta-meta">
                                    <small>
                                        {{ $pasta->publica ? 'Pública' : 'Privada' }} •
                                        Criada em {{ $pasta->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>

                            <div class="pasta-actions" onclick="event.stopPropagation()">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" onclick="toggleDropdown({{ $pasta->id }})">
                                        ⋮
                                    </button>
                                    <div class="dropdown-menu" id="dropdown-{{ $pasta->id }}">
                                        <a href="{{ route('pastas.show', $pasta) }}" class="dropdown-item">
                                            👁️ Visualizar
                                        </a>
                                        <a href="{{ route('pastas.edit', $pasta) }}" class="dropdown-item">
                                            ✏️ Editar
                                        </a>
                                        <a href="{{ route('pastas.create', ['pastaPai' => $pasta->id]) }}"
                                           class="dropdown-item">
                                            📁 Nova Subpasta
                                        </a>
                                        <hr style="margin: 0.5rem 0;">
                                        <form method="POST" action="{{ route('pastas.destroy', $pasta) }}"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta pasta?')"
                                              style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete">
                                                🗑️ Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                @if($pastas->hasPages())
                    <div class="pagination-wrapper">
                        {{ $pastas->links('pagination.custom') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    @if(request('search'))
                        <div class="empty-icon">🔍</div>
                        <h3>Nenhuma pasta encontrada</h3>
                        <p>Não encontramos pastas com esse termo de busca.</p>
                        <a href="{{ request()->url() }}{{ $pastaPai ? '?pastaPai=' . $pastaPai->id : '' }}"
                           class="btn btn-secondary">Ver todas as pastas</a>
                    @else
                        <div class="empty-icon">📁</div>
                        <h3>Nenhuma pasta criada ainda</h3>
                        <p>Organize seus torrents criando pastas para categorizá-los.</p>
                        <a href="{{ route('pastas.create') }}{{ $pastaPai ? '?pastaPai=' . $pastaPai->id : '' }}"
                           class="btn btn-primary">Criar primeira pasta</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <style>
        .breadcrumb-nav {
            background: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .breadcrumb-link {
            color: #3182ce;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-link:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #6b7280;
            margin: 0 0.25rem;
        }

        .navigation-actions {
            text-align: left;
        }

        .pastas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .pasta-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            min-height: 180px;
            display: flex;
            flex-direction: column;
        }

        .pasta-card:hover {
            border-color: #3182ce;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .pasta-icon {
            font-size: 3rem;
            text-align: center;
            margin-bottom: .5rem;
        }

        .pasta-info {
            flex: 1;
            text-align: center;
        }

        .pasta-nome {
            margin: 0 0 0.5rem 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .pasta-descricao {
            color: #6b7280;
            margin-bottom: 1rem;
            line-height: 1.4;
            font-size: 0.9rem;
        }

        .pasta-stats {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .stat {
            font-size: 0.875rem;
            color: #374151;
            background: #f3f4f6;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .pasta-meta {
            color: #9ca3af;
            font-size: 0.75rem;
        }

        .pasta-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            color: #6b7280;
        }

        .dropdown-toggle:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 160px;
            z-index: 1000;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        .dropdown-item.delete {
            color: #dc2626;
        }

        .dropdown-item.delete:hover {
            background: #fef2f2;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .empty-state p {
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .pastas-grid {
                grid-template-columns: 1fr;
            }

            .breadcrumb-nav {
                font-size: 0.875rem;
            }

            .pasta-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>

    <script>
        function navegarPasta(pastaId) {
            const url = new URL(window.location.href);
            url.searchParams.set('pastaPai', pastaId);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }

        function toggleDropdown(pastaId) {
            const dropdown = document.getElementById(`dropdown-${pastaId}`);
            const isVisible = dropdown.classList.contains('show');

            // Fechar todos os dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            // Abrir o dropdown clicado se estava fechado
            if (!isVisible) {
                dropdown.classList.add('show');
            }
        }

        // Fechar dropdowns quando clicar fora
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    </script>
@endsection
