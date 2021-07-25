<?php

namespace App\Integrations\Heroes\Marvel;

use Illuminate\Support\{Arr, Str, Stringable};

class MarvelApi
{
    public const BASE_API = 'https://gateway.marvel.com/v1/public/';

    public function to(string $api): Stringable
    {
        return Str::of(self::BASE_API)
            ->append($api)
            ->append('?')
            ->append($this->authentication());
    }

    private function authentication(): string
    {
        $timestamp = now()->timestamp;

        return Arr::query([
            'apikey'  => config('marvel.keys.public'),
            'hash'    => $this->hash($timestamp),
            'ts'      => $timestamp,
        ]);
    }

    private function hash(string $timestamp): string
    {
        $keys = config('marvel.keys');

        return md5("{$timestamp}{$keys['private']}{$keys['public']}");
    }
}
