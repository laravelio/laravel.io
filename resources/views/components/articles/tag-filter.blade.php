@props([
    'selectedTag', 
    'tags', 
])

<div 
    class="flex flex-col bg-white rounded-md shadow max-h-full" 
    x-data="{ selectedTag: '{{ $selectedTag ? $selectedTag->id() : null }}', filter: '', isFiltered(value) { return !this.filter || value.toLowerCase().includes(this.filter.toLowerCase()) } }"
    x-cloak
>
    <div class="border-b">
        <div class="p-4">
            <div class="flex justify-between items-center mb-2" x-cloak>
                <h3 class="text-3xl font-semibold">Filter tag</h3>

                <button @click="$dispatch('close-modal')">
                    <x-heroicon-o-x class="w-6 h-6" />
                </button>
            </div>

            <div class="text-gray-800 mb-3">
                <p>Select a tag below to filter the results</p>
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-search class="h-5 w-5 text-gray-800"/>
                </div>

                <input 
                    type="search" 
                    name="filter" 
                    id="search" 
                    class="border block pl-10 border-gray-300 rounded w-full" 
                    placeholder="Filter by tag name"
                    x-model="filter"
                />
            </div>
        </div>
    </div>

    <div class="border-b overflow-y-scroll">
        <div class="flex flex-col text-lg p-4">
            @foreach ($tags as $tag)
                <button 
                    type="button"
                    wire:click="toggleTag('{{ $tag->slug() }}')"
                    @click="$dispatch('close-modal')"
                    class="flex items-center py-3.5 hover:text-lio-500"
                    :class="{ 'text-lio-500': '{{ $tag->id() }}' === selectedTag }"  
                    x-show="isFiltered('{{ $tag->name() }}')"
                >
                    {{ $tag->name() }}
                    <x-heroicon-o-check-circle 
                        class="ml-3 w-6 h-6 text-lio-500" 
                        x-cloak 
                        x-show="'{{ $tag->id() }}' === selectedTag" 
                    />
                </button>
            @endforeach
        </div>
    </div>

    <div class="flex gap-x-2 justify-end p-4">
        <x-buttons.secondary-button @click="$dispatch('close-modal')">
            Cancel
        </x-buttons.secondary-button>

        <x-buttons.secondary-button wire:click="toggleTag('')" @click="$dispatch('close-modal')">
            Remove filter
        </x-buttons.secondary-button>
    </div>
</div>