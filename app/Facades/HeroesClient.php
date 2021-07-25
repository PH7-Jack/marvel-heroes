<?php

namespace App\Facades;

use App\Contracts\Integrations\Heroes\Characters;
use App\Integrations\Heroes\Marvel;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Characters characters()
 */
class HeroesClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Marvel\Client::class;
    }
}
