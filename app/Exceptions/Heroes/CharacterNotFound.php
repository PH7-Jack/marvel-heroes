<?php

namespace App\Exceptions\Heroes;

use Exception;

class CharacterNotFound extends Exception
{
    public function __construct(
        $id = null,
        $code = 404,
        Exception $previous = null
    ) {
        $message = "Character not found: {$id}";

        parent::__construct($message, $code, $previous);
    }
}
