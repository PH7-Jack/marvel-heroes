<?php

namespace App\Contracts\Integrations\Heroes;

interface Characters
{
    public const ORDER_BY_NAME = 'name';

    public function find(int $id): ?Character;

    public function get(): Response;

    public function getLimit(): int;

    public function getPage(): int;

    public function getOrderBy(): string;

    public function getOrderDirection(): string;

    public function getSearch(): ?string;

    public function search(?string $search): self;

    public function orderBy(string $orderBy): self;

    public function orderDirection(string $orderDirection): self;

    public function limit(int $limit): self;

    public function page(int $page): self;
}
