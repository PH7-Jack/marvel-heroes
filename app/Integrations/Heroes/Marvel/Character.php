<?php

namespace App\Integrations\Heroes\Marvel;

use App\Contracts\Integrations\Heroes;
use App\Exceptions\Heroes\CharacterNotFound;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Cache, Http};

class Character implements Heroes\Character
{
    private int $id;

    private string $name;

    private ?string $description;

    private string $thumbnail;

    private Collection $links;

    private Collection $stories;

    public function __construct(array $character)
    {
        $this->id          = data_get($character, 'id');
        $this->name        = data_get($character, 'name');
        $this->description = data_get($character, 'description');
        $this->thumbnail   = $this->makeThumbnail($character);
        $this->links       = $this->makeLinks($character);
        $this->stories     = $this->makeStories($character);
    }

    public static function findOrFail(int $id): self
    {
        return Cache::remember("marvel.heroes.{$id}", 60 * 60, function () use ($id) {
            $url = (new MarvelApi())->to(Characters::API . "/{$id}");

            $response = Http::get($url)->throw()->json();

            $character = data_get($response, 'data.results.0', false);

            throw_unless($character, new CharacterNotFound($id));

            return (new static($character));
        });
    }

    public static function find(int $id): ?self
    {
        try {
            return static::findOrFail($id);
        } catch (CharacterNotFound) {
            return null;
        }
    }

    private function makeThumbnail(array $character): string
    {
        $thumbnail = data_get($character, 'thumbnail');

        return "{$thumbnail['path']}.{$thumbnail['extension']}";
    }

    private function makeLinks(array $character): Collection
    {
        return collect(data_get($character, 'urls', []))
            ->map(function (array $link) {
                $type = data_get($link, 'type');
                $name = match ($type) {
                    'comiclink' => 'Comic',
                    default     => $type
                };

                return [
                    'name' => $name,
                    'url'  => data_get($link, 'url'),
                ];
            });
    }

    private function makeStories(array $character): Collection
    {
        return collect(data_get($character, 'stories.items', []))->pluck('name');
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

    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function getStories(): Collection
    {
        return $this->stories;
    }
}
