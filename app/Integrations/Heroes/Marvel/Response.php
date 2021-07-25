<?php

namespace App\Integrations\Heroes\Marvel;

use App\Contracts\Integrations\Heroes;
use Illuminate\Support\Collection;

class Response implements Heroes\Response
{
    private Collection $items;

    private int $total;

    public function __construct(Collection $items, int $total)
    {
        $this->items = $items;
        $this->total = $total;
    }

    public function items(): Collection
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->total;
    }
}
