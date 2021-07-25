<?php

namespace App\Contracts\Integrations\Heroes;

use Illuminate\Support\Collection;

interface Character
{
    public static function findOrFail(int $id): self;

    public static function find(int $id): ?self;

    public function getId(): int;

    public function getName(): string;

    public function getDescription(): ?string;

    public function getThumbnail(): string;

    public function getLinks(): Collection;

    public function getStories(): Collection;
}
