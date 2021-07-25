<?php

namespace Tests\Unit\Integrations\Heroes\Marvel;

use App\Contracts\Integrations\Heroes\Character;
use App\Integrations\Heroes\Marvel\Characters;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CharactersFetchTest extends TestCase
{
    use WithFaker;

    private Characters $fetcher;

    public function setUp(): void
    {
        parent::setUp();

        $this->fetcher = resolve(Characters::class);
    }

    public function test_it_should_throw_exception_if_resquest_fail()
    {
        Http::fake(['*' => Http::response(['code' => 500], status: 500)]);

        $this->expectException(RequestException::class);

        $this->fetcher->get();
    }

    public function test_it_should_get_characters_formatted_from_api()
    {
        Http::fake(['*' => $this->fakeResponse()]);

        $characters = $this->fetcher->get();

        $this->assertEquals(20, $characters->count());

        $characters->map(function (Character $character) {
            $this->assertTrue((bool)$character->getId());
            $this->assertTrue((bool)$character->getName());
            $this->assertTrue((bool)$character->getDescription());
            $this->assertTrue((bool)$character->getThumbnail());
        });
    }

    private function fakeResponse(): PromiseInterface
    {
        return Http::response($this->getFakeResponseData(), status: 200);
    }

    private function getFakeResponseData(): array
    {
        $response = [
            'data' => [
                'results' => $this->getCharactersFakeData(),
            ],
        ];

        return $response;
    }

    private function getCharactersFakeData(): array
    {
        $characters = [];

        for ($i = 0; $i < 20; $i++) {
            $characters[] = [
                'id'          => $this->faker->randomNumber(3),
                'name'        => $this->faker->name(),
                'description' => $this->faker->text(50),
                'thumbnail'   => [
                    'path'      => 'marvel.thumbnail.url',
                    'extension' => 'jpg',
                ],
            ];
        }

        return $characters;
    }
}
