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
            <a href="#" data-toggle="modal" data-target="#deleteThread">Delete</a>
        </p>

        @include('_partials._delete_modal', [
            'id' => 'deleteThread',
            'route' => ['threads.delete', $thread->slug()],
            'title' => 'Delete Thread',
            'body' => '<p>Are you sure you want to delete this thread and its replies? This cannot be undone.</p>',
        ])
    @endcan

    @foreach ($thread->replies() as $reply)
        <hr>
        @md($reply->body())
        <p>By {{ $reply->author()->name() }} - {{ $reply->createdAt()->diffForHumans() }}</p>

        @can('update', $reply)
            <p>
                <a href="{{ route('replies.edit', $reply->id()) }}">Edit</a> |
                <a href="#" data-toggle="modal" data-target="#deleteReply{{ $reply->id() }}">Delete</a>
            </p>

            @include('_partials._delete_modal', [
                'id' => "deleteReply{$reply->id()}",
                'route' => ['replies.delete', $reply->id()],
                'title' => 'Delete Reply',
                'body' => '<p>Are you sure you want to delete this reply? This cannot be undone.</p>',
            ])
        @endcan

        @can('update', $thread)
            @if ($thread->isSolutionReply($reply))
                <p>
                    This is the solution.
                    <a href="#" data-toggle="modal" data-target="#unmarkSolution">Unmark As Solution</a>
                </p>

                @include('_partials._update_modal', [
                    'id' => 'unmarkSolution',
                    'route' => ['threads.solution.unmark', $thread->slug()],
                    'title' => 'Unmark As Solution',
                    'body' => '<p>Confirm to unmark this reply as the solution for <strong>"'.$thread->subject().'"</strong>.</p>',
                ])
            @else
                <p><a href="#" data-toggle="modal" data-target="#markSolution{{ $reply->id() }}">Mark As Solution</a></p>

                @include('_partials._update_modal', [
                    'id' => "markSolution{$reply->id()}",
                    'route' => ['threads.solution.mark', $thread->slug(), $reply->id()],
                    'title' => 'Mark As Solution',
                    'body' => '<p>Confirm to mark this reply as the solution for <strong>"'.$thread->subject().'"</strong>.</p>',
                ])
            @endif
        @endcan
    @endforeach

    @if (Auth::check())
        <hr>
        <h3>Reply to this thread</h3>

        {!! Form::open(['route' => 'replies.store']) !!}
            @formGroup('body')
                {!! Form::textarea('body', null, ['class' => 'form-control wysiwyg', 'required']) !!}
                @error('body')
            @endFormGroup

            {!! Form::hidden('replyable_id', $thread->id()) !!}
            {!! Form::hidden('replyable_type', 'threads') !!}
            {!! Form::submit('Reply', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif
@endsection
