<p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="communities-headline">
    Tags
</p>
<div class="mt-3 space-y-2" aria-labelledby="tags-menu">
    <a href="{{ route('forum') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
        All
    </a>

    @foreach (App\Models\Tag::orderBy('name')->get() as $tag)
        <a href="{{ route('forum.tag', $tag->slug()) }} "class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
            <span class="truncate">
                {{ $tag->name() }}
            </span>
        </a>
    @endforeach
</div>