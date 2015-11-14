@if (count($threads))
    @foreach ($threads as $thread)
        <h2><a href="{{ route('thread', $thread->slug()) }}">{{ $thread->subject() }}</a></h2>
        <p>
            {{ $thread->createdAt()->diffForHumans() }} |
            {{ count($thread->replies()) }} replies
        </p>
    @endforeach
@endif

{!! $threads->render() !!}
