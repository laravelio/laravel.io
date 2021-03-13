@if (count($thread->tags()))
    <div class="thread-info-tags">
        @foreach ($thread->tags() as $tag)
            <a href="{{ route('forum.tag', $tag->slug()) }}">
                <x-tag>
                    {{ $tag->name() }}
                </x-tag>
            </a>
        @endforeach
    </div>
@endif
