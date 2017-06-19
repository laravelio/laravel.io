@title($thread->subject())

@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('users._user_info', ['user' => $thread->author(), 'avatarSize' => 100])

            <hr>

            @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                <a class="btn btn-default btn-block" href="{{ route('threads.edit', $thread->slug()) }}">Edit</a>
            @endcan

            @can(App\Policies\ThreadPolicy::DELETE, $thread)
                <a class="btn btn-danger btn-block" href="#" data-toggle="modal" data-target="#deleteThread">Delete</a>

                @include('_partials._delete_modal', [
                    'id' => 'deleteThread',
                    'route' => ['threads.delete', $thread->slug()],
                    'title' => 'Delete Thread',
                    'body' => '<p>Are you sure you want to delete this thread and its replies? This cannot be undone.</p>',
                ])
            @endcan

            <a class="btn btn-link btn-block" href="{{ route('forum') }}"><i class="fa fa-arrow-left"></i> Back</a></a>
        </div>
        <div class="col-md-9">
            <h1>{{ $title }}</h1>
            <hr>

            <div class="panel panel-default">
                <div class="panel-body forum-content">
                    @md($thread->body())
                </div>

                @include('forum.threads._footer')
            </div>

            @foreach ($thread->replies() as $reply)
                <div class="panel {{ $thread->isSolutionReply($reply) ? 'panel-success' : 'panel-default' }}">
                    @if ($thread->isSolutionReply($reply))
                        <div class="panel-heading">
                            Solution Reply
                        </div>
                    @endif

                    <div class="panel-body forum-content">
                        @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                            <div class="pull-right" style="font-size: 20px">
                                @if ($thread->isSolutionReply($reply))
                                    <a href="#" data-toggle="modal" data-target="#unmarkSolution">
                                        <i class="fa fa-times-circle-o text-danger"></i>
                                    </a>

                                    @include('_partials._update_modal', [
                                        'id' => 'unmarkSolution',
                                        'route' => ['threads.solution.unmark', $thread->slug()],
                                        'title' => 'Unmark As Solution',
                                        'body' => '<p>Confirm to unmark this reply as the solution for <strong>"'.e($thread->subject()).'"</strong>.</p>',
                                    ])
                                @else
                                    <a class="text-success" href="#" data-toggle="modal" data-target="#markSolution{{ $reply->id() }}">
                                        <i class="fa fa-check-circle-o"></i>
                                    </a>

                                    @include('_partials._update_modal', [
                                        'id' => "markSolution{$reply->id()}",
                                        'route' => ['threads.solution.mark', $thread->slug(), $reply->id()],
                                        'title' => 'Mark As Solution',
                                        'body' => '<p>Confirm to mark this reply as the solution for <strong>"'.e($thread->subject()).'"</strong>.</p>',
                                    ])
                                @endif
                            </div>
                        @endcan

                        @md($reply->body())
                    </div>
                    <div class="panel-footer">
                        Replied {{ $reply->createdAt()->diffForHumans() }} ago by
                        <a href="{{ route('profile', $reply->author()->username()) }}">{{ $reply->author()->name() }}</a>

                        <div class="pull-right">
                            @can(App\Policies\ReplyPolicy::UPDATE, $reply)
                                <a class="btn btn-default btn-xs" href="{{ route('replies.edit', $reply->id()) }}">Edit</a>
                                <a class="btn btn-danger btn-xs" href="#" data-toggle="modal" data-target="#deleteReply{{ $reply->id() }}">Delete</a>

                                @include('_partials._delete_modal', [
                                    'id' => "deleteReply{$reply->id()}",
                                    'route' => ['replies.delete', $reply->id()],
                                    'title' => 'Delete Reply',
                                    'body' => '<p>Are you sure you want to delete this reply? This cannot be undone.</p>',
                                ])
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach

            @can(App\Policies\ReplyPolicy::CREATE, App\Models\Reply::class)
                <hr>
                {!! Form::open(['route' => 'replies.store']) !!}
                    @formGroup('body')
                        {!! Form::textarea('body', null, ['class' => 'form-control wysiwyg', 'required']) !!}
                        @error('body')
                    @endFormGroup

                    {!! Form::hidden('replyable_id', $thread->id()) !!}
                    {!! Form::hidden('replyable_type', 'threads') !!}
                    {!! Form::submit('Reply', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
            @endcan

            <hr>
            
            @if(Auth::guest())
                <p class="text-center"><a href="{{ route('login') }}">Sign in</a> to participate in this thread!</p>
            @endif

        </div>
    </div>
@endsection
