<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class BuscarPastasDTO extends Data
{
    public function __construct(
        public ?string $search = null,
        public ?string $pastaPai = null,
        public ?string $orderBy,
        public ?string $direction
    ) {}
}
