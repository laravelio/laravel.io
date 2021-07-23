<div class="flex w-full rounded shadow">
    <button 
        wire:click="sortBy('recent')" type="button"
        aria-current="{{ $selectedSortBy === 'recent' ? 'page' : 'false' }}"
        class="w-full flex justify-center font-medium rounded-l px-5 py-2 border {{ $selectedSortBy === 'recent' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}"
    >
        Recent
    </a>

    <button 
        wire:click="sortBy('popular')" type="button"
        aria-current="{{ $selectedSortBy === 'popular' ? 'page' : 'false' }}"
        class="w-full flex justify-center font-medium px-5 py-2 border-t border-b {{ $selectedSortBy === 'popular' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}"
    >
        Popular
    </a>

    <button 
        wire:click="sortBy('trending')" type="button"
        aria-current="{{ $selectedSortBy === 'trending' ? 'page' : 'false' }}"
        class="w-full flex items-center gap-x-2 justify-center font-medium rounded-r px-5 py-2 border {{ $selectedSortBy === 'trending' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}"
    >
        Trending
        <x-heroicon-o-fire class="w-5 h-5" />
    </a>
</div>