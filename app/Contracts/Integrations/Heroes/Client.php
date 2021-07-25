<?php

namespace App\Contracts\Integrations\Heroes;

interface Client
{
    public const ORDER_ASC  = 'asc';
    public const ORDER_DESC = 'desc';

    public function characters(): Characters;
}
