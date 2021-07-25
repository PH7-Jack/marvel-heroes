<?php

namespace App\Http\Livewire\Heroes;

use App\Contracts\Integrations\Heroes\Character;
use App\Facades\HeroesClient;
use Livewire\Component;

/**
 * @property-read Character $character
 */
class DetailsModal extends Component
{
    public bool $detailsModal = false;

    public ?int $characterId = null;

    protected $listeners = ['heroes::show' => 'setCharacterId'];

    public function render()
    {
        return view('livewire.heroes.details-modal');
    }

    public function setCharacterId(int $id): void
    {
        $this->characterId = $id;
    }

    public function getCharacterProperty(): ?Character
    {
        if (!$this->characterId) {
            return null;
        }

        return HeroesClient::characters()->find($this->characterId);
    }
}
