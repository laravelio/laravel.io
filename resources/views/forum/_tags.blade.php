<h3>Tags</h3>

<div class="list-group">
    <a href="{{ route('forum') }}" class="list-group-item {{ active('forum*', ! isset($activeTag) || $activeTag === null) }}">All</a>

    @foreach (App\Models\Tag::orderBy('name')->get() as $tag)
        <a href="{{ route('forum.tag', $tag->slug()) }}"
           class="list-group-item{{ isset($activeTag) && $tag->matches($activeTag) ? ' active' : '' }}">
            {{ $tag->name() }}
        </a>
    @endforeach
</div>
