<?php

namespace App\Contracts\Integrations\Heroes;

use Illuminate\Support\Collection;

interface Response
{
    public function items(): Collection;

    public function total(): int;
}
