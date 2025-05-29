<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class BuscarArquivosDTO extends Data
{
    public function __construct(
        public ?string $search = null,
        public ?string $pasta = null,
        public string $orderBy = 'created_at',
        public string $direction = 'desc'
    ) {}
}
