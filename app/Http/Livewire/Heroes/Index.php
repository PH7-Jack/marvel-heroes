<?php

namespace App\Http\Livewire\Heroes;

use App\Contracts\Integrations\Heroes\{Characters, Client, Response};
use App\Facades\HeroesClient;
use App\Support\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\{Collection, Str};
use Livewire\Component;

/**
 * @property-read Response $characters
 * @property-read Collection $paginationLinks
 * @property-read array $orderDirections
 * @property-read int $maxPages
 */
class Index extends Component
{
    public const LIMIT = 20;

    public const ORDER_BY = Characters::ORDER_BY_NAME;

    public string $orderDirection = Client::ORDER_ASC;

    public ?string $search = null;

    public int $page = 1;

    public bool $loaded = false;

    protected $queryString = [
        'search',
        'page'           => ['except' => 1],
        'orderDirection' => ['except' => Client::ORDER_ASC],
    ];

    public function render()
    {
        return view('livewire.heroes.index');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedOrderDirection(): void
    {
        $this->resetPage();
    }

    private function resetPage()
    {
        $this->page = 1;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function previousPage(): void
    {
        $this->page--;
    }

    public function nextPage(): void
    {
        $this->page++;
    }

    public function getCharactersProperty(): Response
    {
        return Cache::remember(
            $this->getQueryCacheKey(),
            $seconds = 60,
            function () {
                return HeroesClient::characters()
                    ->orderBy(self::ORDER_BY)
                    ->orderDirection($this->orderDirection)
                    ->limit(self::LIMIT)
                    ->search($this->search)
                    ->page($this->page)
                    ->get();
            }
        );
    }

    private function getQueryCacheKey(): string
    {
        return Str::slug("{$this->page}.{$this->orderDirection}.{$this->search}");
    }

    public function getOrderDirectionsProperty(): array
    {
        return [
            Client::ORDER_ASC  => __('Ascending Order'),
            Client::ORDER_DESC => __('Descending Order'),
        ];
    }

    public function getPaginationLinksProperty(): Collection
    {
        $paginator = new Paginator(
            total: $this->characters->total(),
            perPage: self::LIMIT,
            currentPage: $this->page,
            options: ['onEachSide' => 0]
        );

        return $paginator->links();
    }

    public function getMaxPagesProperty(): int
    {
        return ceil($this->characters->total() / self::LIMIT);
    }
}
