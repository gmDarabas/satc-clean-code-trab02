<?php

namespace App\Repositories;

use App\DTO\BuscarArquivosDTO;
use App\Models\Arquivo;

class ArquivoRepository
{
    public function buscarPaginado(BuscarArquivosDTO $filtros)
    {
        $query = Arquivo::with(['user', 'pastas'])
            ->where('ativo', true);

        if ($filtros->search) {
            $query->where(function ($q) use ($filtros) {
                $q->where('nome', 'ILIKE', "%{$filtros->search}%")
                    ->orWhere('descricao', 'ILIKE', "%{$filtros->search}%");
            });
        }

        if ($filtros->pasta) {
            $query->whereHas('pastas', function ($q) use ($filtros) {
                $q->where('pastas.id', $filtros->pasta);
            });
        }

        if (in_array($filtros->orderBy, ['nome', 'created_at', 'downloads', 'tamanho', 'seeds'])) {
            $query->orderBy($filtros->orderBy, $filtros->direction);
        }

        return $query->paginate(20)->withQueryString();
    }
}
