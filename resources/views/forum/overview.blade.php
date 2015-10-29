@if (count($threads))
    @foreach ($threads as $thread)
        <h2>{{ $thread->subject() }}</h2>
    @endforeach
@endif
