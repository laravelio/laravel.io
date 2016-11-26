@title('Forum')

@extends('layouts.default')

@section('content')
    @if (isset($topic))
        <h1>{{ $topic->name() }}</h1>

        @php($threads = $topic->paginatedThreads())
    @else
        <h1>{{ $title }}</h1>

        @foreach ($topics as $topic)
            <h2><a href="{{ route('forum.topic', $topic->slug()) }}">{{ $topic->name() }}</a></h2>
            <p>
                {{ $topic->createdAt()->diffForHumans() }}
            </p>
        @endforeach
    @endif

    @foreach ($threads as $thread)
        <h2><a href="{{ route('thread', $thread->slug()) }}">{{ $thread->subject() }}</a></h2>
        <p>
            Topic: {{ $thread->topic()->name() }} |
            {{ $thread->createdAt()->diffForHumans() }} |
            {{ count($thread->replies()) }} replies
        </p>
    @endforeach

    <div class="text-center">
        {!! $threads->render() !!}
    </div>
@endsection
