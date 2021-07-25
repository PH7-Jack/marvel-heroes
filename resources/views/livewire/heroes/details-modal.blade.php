<div>
    <x-modal wire:model.defer="detailsModal">
        <x-card>
            <div wire:loading class="flex flex-col w-full">
                <div class="animate-pulse rounded-lg w-56 h-56 mx-auto bg-gray-100 mb-2"></div>
                <div class="animate-pulse rounded-lg w-48 h-4 mx-auto bg-gray-100 mb-4"></div>

                <div class="animate-pulse rounded-lg w-32 h-4 bg-gray-100 mb-1"></div>

                <div class="flex flex-col space-y-2">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="animate-pulse rounded-lg w-full h-10 mx-auto bg-gray-100"
                            wire:key="loading.{{ $i }}">
                        </div>
                    @endfor
                </div>
            </div>

            <div wire:loading.remove class="flex flex-col text-gray-600">
                <img
                    class="w-56 h-auto md:h-60 rounded-lg shadow-soft border border-gray-100 mx-auto mb-2"
                    src="{{ $this->character?->getThumbnail() }}"
                />

                <h4 class="text-md mx-auto mb-1">
                    {{ $this->character?->getName() }}
                </h4>

                @if ($this->character?->getLinks()->isNotEmpty())
                    <div wire:key="character.links" class="flex justify-center text-sm gap-x-4 mb-2">
                        @foreach ($this->character?->getLinks() as $link)
                            <a class="text-info-400 capitalize" href="{{ data_get($link, 'url') }}" target="_Blank">
                                {{ data_get($link, 'name') }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <p class="text-sm mx-auto text-justify">
                    {{ $this->character?->getDescription() }}
                </p>

                <div class="flex gap-x-3 items-center mt-4 mb-3">
                    <div class="h-0.5 w-full bg-gray-200"></div>

                    <p class="uppercase flex-shrink-0 text-xs">
                        {{ __('Stories') }}
                    </p>

                    <div class="h-0.5 w-full bg-gray-200"></div>
                </div>

                @if ($this->character)
                    <div wire:key="character.stories" class="max-h-96 overflow-y-auto">
                        @forelse ($this->character?->getStories() as $story)
                            <div class="text-sm border-b-2 last:border-0 p-2 mb-1">
                                {{ $story }}
                            </div>
                        @empty
                            <div class="text-sm border-b-2 last:border-0 p-2 mb-1">
                                {{ __('Empty Stories') }}
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-button x-on:click="close" :label="__('Close')" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
