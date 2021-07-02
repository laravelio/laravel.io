<p class="px-2 text-xs font-semibold text-gray-800 uppercase tracking-wider" id="communities-headline">
    Tags
</p>

<div class="mt-3 space-y-2" aria-labelledby="tags-menu">
    <a 
        href="{{ route('forum', ['filter' => $filter]) }}" 
        class="group flex items-center px-2.5 py-1 text-sm font-medium text-gray-600 hover:bg-white {{ ! isset($activeTag) ? 'bg-white text-lio-500 border-lio-500 border-l-2' : '' }}"
    >
        <span class="truncate">
            All
        </span>
    </a>

    @foreach ($tags as $tag)
        @if (isset($activeTag) && $activeTag->id() === $tag->id())
            <x-tag class="text-lio-600" has-dot>
                {{ $tag->name() }}
            </x-tag>
        @else
            <a href="{{ route('forum.tag', [$tag->slug(), 'filter' => $filter]) }}" class="inline-flex items-center">
                <x-tag class="hover:bg-white">
                    {{ $tag->name() }}
                </x-tag>
            </a>
        @endif
    @endforeach
</div>
