<?php

namespace App\Services;

use App\DTO\BuscarArquivosDTO;
use App\DTO\BuscarPastasDTO;
use App\Repositories\ArquivoRepository;
use App\Repositories\PastaRepository;

class PastaService
{
    public function __construct(
        protected PastaRepository $pastaRepository
    ) {}

    public function buscarPaginado(BuscarPastasDTO $filtros)
    {
        return $this->pastaRepository->buscar($filtros);
    }

    public function buscarPorId(int $id)
    {
        return $this->pastaRepository->buscarPorId($id);
    }
}
