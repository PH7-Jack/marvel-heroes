<?php

namespace App\Http\Livewire\Heroes;

use App\Contracts\Integrations\Heroes\{Characters, Client};
use App\Facades\HeroesClient;
use Illuminate\Support\Collection;
use Livewire\Component;

/**
 * @property-read Collection $characters
 * @property-read array $orderDirections
 */
class Index extends Component
{
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

    public function getCharactersProperty(): Collection
    {
        return HeroesClient::characters()
            ->orderBy(self::ORDER_BY)
            ->orderDirection($this->orderDirection)
            ->search($this->search)
            ->page($this->page)
            ->get();
    }

    public function getOrderDirectionsProperty(): array
    {
        return [
            Client::ORDER_ASC  => __('Ascending Order'),
            Client::ORDER_DESC => __('Descending Order'),
        ];
    }
}
