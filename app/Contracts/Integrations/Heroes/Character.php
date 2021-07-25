<?php

namespace App\Contracts\Integrations\Heroes;

interface Character
{
    public function getId(): int;

    public function getName(): string;

    public function getDescription(): ?string;

    public function getThumbnail(): string;
}
