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

        <div class="modal fade" id="deleteThread" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{ Form::open(['route' => ['threads.delete', $thread->slug()], 'method' => 'DELETE']) }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Thread</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this thread? This cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        {{ Form::submit('Delete Thread', ['class' => 'btn btn-danger']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
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

            <div class="modal fade" id="deleteReply{{ $reply->id() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{ Form::open(['route' => ['replies.delete', $reply->id()], 'method' => 'DELETE']) }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Delete Reply</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this reply? This cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                {{ Form::submit('Delete Reply', ['class' => 'btn btn-danger']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        @endcan

        @can('update', $thread)
            @if ($thread->isSolutionReply($reply))
                <p>
                    This is the solution.
                    <a href="#" data-toggle="modal" data-target="#unmarkSolution">Unmark As Solution</a>
                </p>

                <div class="modal fade" id="unmarkSolution" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {{ Form::open(['route' => ['threads.solution.unmark', $thread->slug()], 'method' => 'PUT']) }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Unmark As Solution</h4>
                            </div>
                            <div class="modal-body">
                                <p>Confirm to unmark this reply as the solution for <strong>"{{ $thread->subject() }}"</strong>.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                {{ Form::submit('Unmark As Solution', ['class' => 'btn btn-primary']) }}
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            @else
                <p><a href="#" data-toggle="modal" data-target="#markSolution{{ $reply->id() }}">Mark As Solution</a></p>

                <div class="modal fade" id="markSolution{{ $reply->id() }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {{ Form::open(['route' => ['threads.solution.mark', $thread->slug(), $reply->id()], 'method' => 'PUT']) }}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Mark As Solution</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Confirm to mark this reply as the solution for <strong>"{{ $thread->subject() }}"</strong>.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    {{ Form::submit('Mark As Solution', ['class' => 'btn btn-primary']) }}
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
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
