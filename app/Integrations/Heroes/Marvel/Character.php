<?php

namespace App\Integrations\Heroes\Marvel;

use App\Contracts\Integrations\Heroes;

class Character implements Heroes\Character
{
    private int $id;

    private string $name;

    private ?string $description;

    private string $thumbnail;

    public function __construct(array $character)
    {
        $this->id          = data_get($character, 'id');
        $this->name        = data_get($character, 'name');
        $this->description = data_get($character, 'description');
        $this->thumbnail   = $this->makeThumbnail($character);
    }

    private function makeThumbnail(array $character): string
    {
        $thumbnail = data_get($character, 'thumbnail');

        return "{$thumbnail['path']}.{$thumbnail['extension']}";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }
}
