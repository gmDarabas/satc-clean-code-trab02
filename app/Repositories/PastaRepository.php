<?php

namespace App\Repositories;

use App\DTO\BuscarPastasDTO;
use App\Models\Pasta;
use App\Models\User;

class PastaRepository
{

    public function buscarPorId(int $id): Pasta
    {
        return Pasta::find($id);
    }

    public function buscar(BuscarPastasDTO $filtros) {
        $user =  User::find(1);// Auth::user(); TODO substituir quando tiver login
        $pastaPai = null;

//        if ($filtros->pastaPai) {
//            $pastaPai = Pasta::doUsuario($user->id)
//                ->findOrFail($filtros->pastaPai);
//        }

        $query = Pasta::with(['subpastas', 'arquivos'])
            ->doUsuario($user->id);

        if ($filtros->pastaPai) {
            $query->where('pasta_pai_id', $filtros->pastaPai);
        } else {
            $query->raiz();
        }

        if ($filtros->search) {
            $query->where(function($q) use ($filtros) {
                $q->where('nome', 'ILIKE', "%{$filtros->search}%")
                    ->orWhere('descricao', 'ILIKE', "%{$filtros->search}%");
            });
        }

        return $query->orderBy($filtros->orderBy ?? 'nome')
            ->paginate(12)
            ->withQueryString();
    }
}
