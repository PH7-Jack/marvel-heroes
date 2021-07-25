<?php

namespace Tests\Unit\Livewire\Heroes;

use App\Http\Livewire\Heroes\Index;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Unit\Traits\Heroes\Marvel\MockHeroesResponse;

class ListingHeroesTest extends TestCase
{
    use MockHeroesResponse;

    public function test_it_should_render_heroes()
    {
        Http::fake(['*' => $this->fakeResponse()]);

        Livewire::test(Index::class)
            ->set('loaded', true)
            ->assertSee('Spider Man')
            ->assertSee('Iron Man');
    }

    public function test_it_should_render_filtered_heroes()
    {
        $response = $this->fakeResponse();

        $characters = collect($this->getCharactersFakeData())
            ->filter(function (array $character) {
                return str_contains('Spider Man', data_get($character, 'name'));
            })->toArray();

        $response = [
            'data' => [
                'total'   => 1,
                'results' => $characters,
            ],
        ];

        Http::fake(['*' => Http::response($response, status: 200)]);

        Livewire::test(Index::class)
            ->set('search', 'Man')
            ->set('loaded', true)
            ->assertSee('Spider Man')
            ->assertDontSee('Iron Man');
    }
}
