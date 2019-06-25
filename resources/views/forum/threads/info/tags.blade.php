@if (count($thread->tags()))
    <div class="thread-info-tags">
        @foreach ($thread->tags() as $tag)
            <a href="{{ route('forum.tag', $tag->slug()) }}">
                <span class="bg-gray-300 text-gray-700 rounded px-2 py-1">{{ $tag->name() }}</span>
            </a>
        @endforeach
    </div>
@endif