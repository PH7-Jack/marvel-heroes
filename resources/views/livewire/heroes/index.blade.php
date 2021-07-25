<div wire:init="$set('loaded', true)">
    <div class="py-4 sm:py-8">
        <div class="w-full sm:max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-4">
                <x-logo class="h-20 rounded-lg shadow-md" />
            </div>

            <div class="flex items-center justify-between px-2 mt-8 mb-2 sm:max-w-xs sm:mx-auto">
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

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 lg:gap-5 p-2">
                @for ($i = 0; $i < 9; $i++)
                    <div class="animate-pulse relative w-full h-56 md:h-64 bg-white
                                shadow-soft border border-primary-100 rounded-lg"
                        wire:key="loading.{{ $i }}"
                        wire:loading
                        >
                        <div class="absolute inset-0 flex items-center justify-center">
                            <x-icons.spinner class="w-6 h-6 text-primary-200" />
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
                            <div class="overflow-hidden w-full h-full bg-white shadow-soft border border-primary-100 rounded-lg">
                                <img
                                    class="object-fill w-full h-48 md:h-64"
                                    src="{{ $character->getThumbnail() }}"
                                    alt="{{ $character->getName() }}"
                                    title="{{ $character->getName() }}"
                                />

                                <div class="p-1 flex flex-col">
                                    <h3 class="truncate text-md text-primary-700" title="{{ $character->getName() }}">
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

                    @if ($this->characters->isNotEmpty())
                        <div wire:key="pagination.links" class="col-span-2 sm:col-span-3 mt-4">
                            <div class="flex gap-x-1 items-center justify-center">
                                <x-button
                                    :disabled="$page === 1"
                                    icon="chevron-left"
                                    wire:click="previousPage"
                                    rounded
                                    primary
                                    flat
                                />

                                @foreach ($this->paginationLinks as $link)
                                    @if (is_numeric($link['label']))
                                        <x-button
                                            class="h-6 w-6 md:h-8 md:w-8"
                                            :label="$link['label']"
                                            :disabled="$link['label'] == $page"
                                            :flat="! $link['active']"
                                            :outline="$link['active']"
                                            wire:click="setPage({{ $link['label'] }})"
                                            rounded
                                            primary
                                        />
                                    @else
                                        <a class="text-sm font-medium text-primary-500">
                                            {{ $link['label'] }}
                                        </a>
                                    @endif
                                @endforeach

                                <x-button
                                    :disabled="$page === $this->characters->count()"
                                    icon="chevron-right"
                                    wire:click="nextPage"
                                    rounded
                                    primary
                                    flat
                                />
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div wire:ignore>
        <livewire:heroes.details-modal />
    </div>

    <div class="hidden" x-data="{ page: @entangle('page').defer }"
        x-init="function() {
            $watch('page', () => window.scrollTo({top: 0, behavior: 'smooth'}))
        }">
    </div>
</div>
