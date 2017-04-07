<h3>Topics</h3>

<div class="list-group">
    <a href="{{ route('forum') }}" class="list-group-item {{ active('forum*', ! isset($activeTopic) || $activeTopic === null) }}">All</a>

    @foreach (App\Models\Topic::all() as $topic)
        <a href="{{ route('forum.topic', $topic->slug()) }}"
           class="list-group-item{{ isset($activeTopic) && $topic->matches($activeTopic) ? ' active' : '' }}">
            {{ $topic->name() }}
        </a>
    @endforeach
</div>
