@props([
    'activeTag',
    'tags',
    'filter',
    'route' => 'forum.tag',
    'cancelRoute' => 'forum',
    'jumpTo' => null,
])

<div
    class="flex max-h-full flex-col rounded-md bg-white shadow"
    x-data="{
        activeTag: '{{ $activeTag ? $activeTag->id() : null }}',
        filter: '',
        isFiltered(value) {
            return (
                ! this.filter ||
                value.toLowerCase().includes(this.filter.toLowerCase())
            )
        },
    }"
    x-cloak
>
    <div class="border-b">
        <div class="p-4">
            <div class="mb-2 flex items-center justify-between" x-cloak>
                <h3 class="text-3xl font-semibold">Filter tag</h3>

                <button @click="activeModal = false">
                    <x-heroicon-o-x-mark class="h-6 w-6" />
                </button>
            </div>

            <div class="mb-3 text-gray-800">
                <p>Select a tag below to filter the results</p>
            </div>

            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-800" />
                </div>

                <input
                    type="search"
                    name="filter"
                    id="search"
                    class="block w-full rounded border border-gray-300 pl-10"
                    placeholder="Filter by tag name"
                    x-model="filter"
                />
            </div>
        </div>
    </div>

    <div class="overflow-y-scroll border-b">
        <div class="flex flex-col p-4 text-lg">
            @foreach ($tags as $tag)
                <a
                    href="{{ route($route, ['tag' => $tag->slug(), 'filter' => $filter]) }}{{ $jumpTo ? '#'.$jumpTo : '' }}"
                    class="flex items-center py-3.5 hover:text-lio-500"
                    :class="{ 'text-lio-500': '{{ $tag->id() }}' === activeTag }"
                    x-show="isFiltered('{{ $tag->name() }}')"
                >
                    {{ $tag->name() }}
                    <x-heroicon-o-check-circle class="ml-3 h-6 w-6 text-lio-500" x-cloak x-show="'{{ $tag->id() }}' === activeTag" />
                </a>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end gap-x-2 p-4">
        <x-buttons.secondary-button @click="activeModal = false">Cancel</x-buttons.secondary-button>

        <x-buttons.secondary-button href="{{ route($cancelRoute) }}" x-show="activeTag">Remove filter</x-buttons.secondary-button>
    </div>
</div>
