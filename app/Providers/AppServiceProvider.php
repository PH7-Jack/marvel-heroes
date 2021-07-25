<?php

namespace App\Providers;

use App\Contracts\Integrations\Heroes\{Character, Characters};
use App\Integrations\Heroes\Marvel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        Characters::class => Marvel\Characters::class,
        Character::class  => Marvel\Character::class,
    ];

    public function register()
    {
    }

    public function boot()
    {
    }
}
