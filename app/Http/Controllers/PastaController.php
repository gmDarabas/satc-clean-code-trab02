<?php

namespace App\Http\Controllers;

use App\DTO\BuscarPastasDTO;
use App\Models\Pasta;
use App\Models\User;
use App\Services\PastaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PastaController extends Controller
{
    public function __construct(
        private readonly PastaService $pastaService,
    )
    {
    }

    public function index(BuscarPastasDTO $filtros)
    {
        $pastaPai = null;
        $pastas = $this->pastaService->buscarPaginado($filtros);
        $breadcrumb = collect();

        if ($filtros->pastaPai) {
            $pastaPai = $this->pastaService->buscarPorId($filtros->pastaPai);
            $breadcrumb = $this->buildBreadcrumb($pastaPai);
        }

        return view('pastas.index', compact('pastas', 'pastaPai', 'breadcrumb'));
    }

//    public function show($id)
//    {
//        $usuarioLogado = 1;
//
//        $pasta = Pasta::with(['subpastas', 'arquivos.user', 'user'])->findOrFail($id);
//
//        if ($pasta->user_id !== $usuarioLogado && !$pasta->publica) {
//            abort(403, 'Acesso negado');
//        }
//
//        return view('pastas.show', compact('pasta'));
//    }

    private function buildBreadcrumb($pasta)
    {
        $breadcrumb = collect();

        while ($pasta) {
            $breadcrumb->prepend([
                'nome' => $pasta->nome,
                'id' => $pasta->id
            ]);
            $pasta = $pasta->pastaPai;
        }

        return $breadcrumb;
    }
}
