<div wire:init="$set('loaded', true)">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-4">
                <x-logo class="h-20 rounded-lg shadow-md" />
            </div>

            <div class="flex items-center justify-between px-2 mt-8 sm:max-w-xs sm:mx-auto">
                <div class="overflow-hidden rounded-full shadow mr-3">
                    <x-input
                        class="h-10 pl-10"
                        wire:model.debounce.750ms="search"
                        icon="search"
                        borderless
                        shadowless
                    />
                </div>

                <x-dropdown>
                    <x-slot name="trigger">
                        <x-button class="mr-1" primary flat rounded>
                            <x-icon name="filter" class="w-5 h-5" />
                        </x-button>
                    </x-slot>

                    @foreach ($this->orderDirections as $direction => $label)
                        <x-dropdown.item
                            wire:key="directions.{{ $direction }}"
                            wire:click="$set('orderDirection', '{{ $direction }}')"
                            :label="$label"
                        />
                    @endforeach
                </x-dropdown>
            </div>

            <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3 lg:gap-5 p-2">
                @for ($i = 0; $i < 9; $i++)
                    <div class="animate-pulse relative w-full md:w-56 h-48 md:h-56 lg:h-64 bg-white
                                shadow-soft border border-gray-100 rounded-lg"
                        wire:key="loading.{{ $i }}"
                        wire:loading>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <x-icons.spinner class="w-6 h-6 text-gray-200" />
                        </div>
                    </div>
                @endfor

                @if ($loaded)
                    @forelse ($this->characters as $character)
                        <x-button
                            class="!p-0 text-left"
                            wire:key="characters.{{ $character->getId() }}"
                            onclick="
                                $openModal('detailsModal')
                                Livewire.emit('heroes::show', {{ $character->getId() }})
                            "
                            flat
                            primary>
                            <div class="overflow-hidden w-full h-full bg-white shadow-soft border border-gray-100 rounded-lg">
                                <img
                                    class="object-fill h-48 md:h-56 lg:h-64 w-full"
                                    src="{{ $character->getThumbnail() }}"
                                    alt="{{ $character->getName() }}"
                                    title="{{ $character->getName() }}"
                                />

                                <div class="p-2 flex flex-col">
                                    <h3 class="truncate text-md text-gray-700" title="{{ $character->getName() }}">
                                        {{ $character->getName() }}
                                    </h3>
                                </div>
                            </div>
                        </x-button>
                    @empty
                        <div class="col-span-2 text-center pt-16 pb-8 text-primary-400">
                            <x-icons.spider class="w-32 h-32 mx-auto" />

                            <p class="text-xs">
                                @lang('Empty Characters')
                            </p>
                        </div>
                    @endforelse
                @endif
            </div>
        </div>
    </div>

    <div wire:ignore>
        <livewire:heroes.details-modal />
    </div>
</div>
