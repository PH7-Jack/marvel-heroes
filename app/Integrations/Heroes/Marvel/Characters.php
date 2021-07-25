<?php

namespace App\Integrations\Heroes\Marvel;

use App\Contracts\Integrations\Heroes;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\{Arr, Collection, Str, Stringable};

class Characters implements Heroes\Characters
{
    private const API = 'characters';

    private ?string $search = null;

    private string $orderBy = self::ORDER_BY_NAME;

    private string $orderDirection = Client::ORDER_ASC;

    private int $limit = 20;

    private int $page = 1;

    public function get(): Collection
    {
        $response = Http::get($this->getUrl())->throw()->json();

        return $this->formatResults(
            data_get($response, 'data.results', [])
        );
    }

    private function formatResults(array $characters): Collection
    {
        return collect($characters)->map(function (array $character) {
            return new Character($character);
        });
    }

    private function getUrl(): string
    {
        return (new MarvelApi())
            ->to(self::API)
            ->append('&')
            ->append($this->getQueryParams());
    }

    private function getQueryParams(): string
    {
        return Arr::query($this->getParams());
    }

    private function getParams(): array
    {
        return collect([
            'orderBy'        => $this->getFormatedOrderBy(),
            'limit'          => $this->getLimit(),
            'offset'         => $this->getOffset(),
            'nameStartsWith' => $this->getSearch(),
        ])->filter()->toArray();
    }

    private function getFormatedOrderBy(): string
    {
        return Str::of($this->orderBy)->when(
            $this->orderDirection === Client::ORDER_DESC,
            fn (Stringable $str) => $str->prepend('-')
        );
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    private function getOffset(): string
    {
        return ($this->page * $this->limit) - $this->limit;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function search(?string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function orderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function orderDirection(string $orderDirection): self
    {
        $this->orderDirection = $orderDirection;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }
}
