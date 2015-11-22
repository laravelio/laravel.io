@extends('layouts.default')

@section('content')
    <h1>{{ $thread->subject() }}</h1>

    @md($thread->body())

    <p>
        <a href="{{ route('threads.edit', $thread->slug()) }}">Edit</a> |
        <a href="{{ route('threads.delete', $thread->slug()) }}">Delete</a>
    </p>

    <hr>

    @if (count($replies = $thread->replies()))
        @foreach ($replies as $reply)
            <p>@md($reply->body())</p>
            <p>By {{ $reply->author()->name() }} - {{ $reply->createdAt()->diffForHumans() }}</p>
            <p>
                <a href="{{ route('replies.edit', $thread->id()) }}">Edit</a> |
                <a href="{{ route('replies.delete', $thread->id()) }}">Delete</a>
            </p>
            <hr>
        @endforeach
    @endif

    {!! Form::open(['route' => 'replies.store']) !!}
        {!! Form::textarea('body') !!}
        {!! Form::hidden('replyable_id', $thread->id()) !!}
        {!! Form::hidden('replyable_type', 'threads') !!}
        {!! Form::submit('Reply') !!}
    {!! Form::close() !!}
@stop
