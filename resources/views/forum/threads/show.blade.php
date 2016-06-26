@php($title = $thread->subject())

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    @md($thread->body())

    @can('update', $thread)
        <p>
            <a href="{{ route('threads.edit', $thread->slug()) }}">Edit</a> |
            <a href="{{ route('threads.delete', $thread->slug()) }}">Delete</a>
        </p>
    @endcan

    @if (count($replies = $thread->replies()))
        @foreach ($replies as $reply)
            <hr>
            <p>@md($reply->body())</p>
            <p>By {{ $reply->author()->name() }} - {{ $reply->createdAt()->diffForHumans() }}</p>

            @can('update', $reply)
                <p>
                    <a href="{{ route('replies.edit', $thread->id()) }}">Edit</a> |
                    <a href="{{ route('replies.delete', $thread->id()) }}">Delete</a>
                </p>
            @endcan
        @endforeach
    @endif

    @if (Auth::check())
        <hr>

        <h3>Reply to this thread</h3>

        {!! Form::open(['route' => 'replies.store']) !!}
            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                {!! Form::textarea('body', null, ['class' => 'form-control', 'required']) !!}
                {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
            </div>
            {!! Form::hidden('replyable_id', $thread->id()) !!}
            {!! Form::hidden('replyable_type', 'threads') !!}
            {!! Form::submit('Reply', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif
@stop
