<?php

namespace App\Http\Controllers;

use App\DTO\BuscarArquivosDTO;
use App\Models\Arquivo;
use App\Services\ArquivoService;

class TorrentController extends Controller
{
    public function __construct(
        private readonly ArquivoService $arquivoService
    ) {}

    public function index(BuscarArquivosDTO $filtros)
    {
        $torrents = $this->arquivoService->buscarPaginado($filtros);

        return view('torrents.index', compact('torrents'));
    }

//    public function show(Arquivo $arquivo)
//    {
//        $arquivo->load(['user', 'pastas']);
//
//        return view('torrents.show', compact('arquivo'));
//    }

}
