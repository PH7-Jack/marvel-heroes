<?php

namespace Tests\Unit\Integrations\Heroes\Marvel;

use App\Integrations\Heroes\Marvel\MarvelApi;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MarvelApiTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('marvel.keys.public', 'public');
        Config::set('marvel.keys.private', 'private');
    }

    public function test_it_should_create_a_valid_url_base_api()
    {
        $url = (new MarvelApi())->to('testing-api');

        $this->assertStringContainsString('/testing-api', $url);
        $this->assertStringContainsString('hash=', $url);
        $this->assertStringContainsString('ts=' . now()->timestamp, $url);
        $this->assertStringContainsString('apikey=' . config('marvel.keys.public'), $url);
    }
}
