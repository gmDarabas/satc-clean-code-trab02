<?php

namespace App\Services;

use App\DTO\BuscarArquivosDTO;
use App\Repositories\ArquivoRepository;

class ArquivoService
{
    public function __construct(
        protected ArquivoRepository $arquivoRepository
    ) {}

    public function buscarPaginado(BuscarArquivosDTO $filtros)
    {
        return $this->arquivoRepository->buscarPaginado($filtros);
    }
}
