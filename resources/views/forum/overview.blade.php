@if (count($threads))
    @foreach ($threads as $thread)
        <h2><a href="{{ route('thread', $thread->slug()) }}">{{ $thread->subject() }}</a></h2>
    @endforeach
@endif
