@title($thread->subject())

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <h2>{{ $thread->topic()->name() }}</h2>

    @md($thread->body())

    @if (count($thread->tags()))
        <p>
            @tags($thread->tags())
        </p>
    @endif

    @can('update', $thread)
        <p>
            <a href="{{ route('threads.edit', $thread->slug()) }}">Edit</a> |
            <a href="{{ route('threads.delete', $thread->slug()) }}">Delete</a>
        </p>
    @endcan

    @if (count($replies = $thread->replies()))
        @foreach ($replies as $reply)
            <hr>
            @md($reply->body())
            <p>By {{ $reply->author()->name() }} - {{ $reply->createdAt()->diffForHumans() }}</p>

            @can('update', $reply)
                <p>
                    <a href="{{ route('replies.edit', $thread->id()) }}">Edit</a> |
                    <a href="{{ route('replies.delete', $thread->id()) }}">Delete</a>
                </p>
            @endcan

            @can('update', $thread)
                @if ($thread->isSolutionReply($reply))
                    <p>
                        This is the solution.
                        <a href="{{ route('threads.solution.unmark', $thread->slug()) }}">Unmark As Solution</a>
                    </p>
                @else
                    <p><a href="{{ route('threads.solution.mark', [$thread->slug(), $reply->id()]) }}">Mark As Solution</a></p>
                @endif
            @endcan
        @endforeach
    @endif

    @if (Auth::check())
        <hr>
        <h3>Reply to this thread</h3>

        {!! Form::open(['route' => 'replies.store']) !!}
            @formGroup('body')
                {!! Form::textarea('body', null, ['class' => 'form-control', 'required']) !!}
                @error('body')
            @endFormGroup

            {!! Form::hidden('replyable_id', $thread->id()) !!}
            {!! Form::hidden('replyable_type', 'threads') !!}
            {!! Form::submit('Reply', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif
@stop
