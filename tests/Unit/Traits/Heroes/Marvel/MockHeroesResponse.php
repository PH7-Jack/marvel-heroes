<?php

namespace Tests\Unit\Traits\Heroes\Marvel;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;

trait MockHeroesResponse
{
    public function fakeResponse(): PromiseInterface
    {
        return Http::response($this->getFakeResponseData(), status: 200);
    }

    public function getFakeResponseData(): array
    {
        $response = [
            'data' => [
                'results' => $this->getCharactersFakeData(),
            ],
        ];

        return $response;
    }

    public function getCharactersFakeData(): array
    {
        $characters = [];

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 18; $i++) {
            $characters[] = [
                'id'          => $faker->randomNumber(3),
                'name'        => $faker->name(),
                'description' => $faker->text(50),
                'thumbnail'   => [
                    'path'      => 'marvel.thumbnail.url',
                    'extension' => 'jpg',
                ],
            ];
        }

        $characters[] = [
            'id'          => $faker->randomNumber(3),
            'name'        => 'Spider Man',
            'description' => $faker->text(50),
            'thumbnail'   => [
                'path'      => 'marvel.thumbnail.url',
                'extension' => 'jpg',
            ],
        ];

        $characters[] = [
            'id'          => $faker->randomNumber(3),
            'name'        => 'Iron Man',
            'description' => $faker->text(50),
            'thumbnail'   => [
                'path'      => 'marvel.thumbnail.url',
                'extension' => 'jpg',
            ],
        ];

        return $characters;
    }
}
