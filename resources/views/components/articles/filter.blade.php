<div class="flex w-full rounded shadow">
    <a
        href="{{ route('articles', ['filter' => 'recent', 'tag' => $activeTag?->name()]) . '#articles' }}"
        aria-current="{{ $selectedFilter === 'recent' ? 'page' : 'false' }}"
        class="w-full flex justify-center font-medium rounded-l px-5 py-2 border {{ $selectedFilter === 'recent' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}"
    >
        Recent
    </a>

    <a
        href="{{ route('articles', ['filter' => 'popular', 'tag' => $activeTag?->name()]) . '#articles' }}"
        aria-current="{{ $selectedFilter === 'popular' ? 'page' : 'false' }}"
        class="w-full flex justify-center font-medium px-5 py-2 border-t border-b {{ $selectedFilter === 'popular' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}"
    >
        Popular
    </a>

    <a
        href="{{ route('articles', ['filter' => 'trending', 'tag' => $activeTag?->name()]) . '#articles' }}"
        aria-current="{{ $selectedFilter === 'trending' ? 'page' : 'false' }}"
        class="w-full flex items-center gap-x-2 justify-center font-medium rounded-r px-5 py-2 border {{ $selectedFilter === 'trending' ? 'bg-gray-900 text-white  border-gray-900 hover:bg-gray-800' : 'bg-white text-gray-800 border-gray-200 hover:bg-gray-100' }}"
    >
        Trending
        <x-heroicon-o-fire class="w-5 h-5" />
    </a>
</div>