<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Paginator
{
    public function __construct(
        private int $total,
        private int $perPage,
        private int $currentPage,
        private array $options = []
    ) {
    }

    public function links(): Collection
    {
        $paginator = new LengthAwarePaginator(
            items: [],
            total: $this->total,
            perPage: $this->perPage,
            currentPage: $this->currentPage,
            options: $this->options
        );

        $links = $paginator->linkCollection();

        $links->shift();
        $links->pop();

        return $links;
    }
}
