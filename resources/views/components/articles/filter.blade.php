<div class="flex w-full rounded shadow">
    <a href="{{ route('articles', ['filter' => 'recent', 'tag' => $activeTag?->name()]) . '#articles' }}"
        aria-current="{{ $selectedFilter === 'recent' ? 'page' : 'false' }}"
        class="{{ $selectedFilter === 'recent' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }} flex w-full justify-center rounded-l border px-5 py-2 font-medium">
        Recent
    </a>

    <a href="{{ route('articles', ['filter' => 'popular', 'tag' => $activeTag?->name()]) . '#articles' }}"
        aria-current="{{ $selectedFilter === 'popular' ? 'page' : 'false' }}"
        class="{{ $selectedFilter === 'popular' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }} flex w-full justify-center border-b border-t px-5 py-2 font-medium">
        Popular
    </a>

    <a href="{{ route('articles', ['filter' => 'trending', 'tag' => $activeTag?->name()]) . '#articles' }}"
        aria-current="{{ $selectedFilter === 'trending' ? 'page' : 'false' }}"
        class="{{ $selectedFilter === 'trending' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }} flex w-full items-center justify-center gap-x-2 rounded-r border px-5 py-2 font-medium">
        Trending
        <x-heroicon-o-fire class="h-5 w-5" />
    </a>
</div>
