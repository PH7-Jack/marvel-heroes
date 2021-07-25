<?php

namespace App\Integrations\Heroes\Marvel;

use App\Contracts\Integrations\Heroes;

class Client implements Heroes\Client
{
    public function characters(): Heroes\Characters
    {
        return resolve(Characters::class);
    }
}
