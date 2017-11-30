@title($thread->subject())

@extends('layouts.default')

@section('content')
    <div class="row forum">
        <div class="col-md-3">
            @include('users._user_info', ['user' => $thread->author(), 'avatarSize' => 100])

            <hr>

            @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                <a class="btn btn-default btn-block" href="{{ route('threads.edit', $thread->slug()) }}">
                    Edit
                </a>
            @endcan

            @can(App\Policies\ThreadPolicy::UNSUBSCRIBE, $thread)
                <a class="btn btn-primary btn-block" href="{{ route('threads.unsubscribe', $thread->slug()) }}">
                    Unsubscribe
                </a>
            @elsecan(App\Policies\ThreadPolicy::SUBSCRIBE, $thread)
                <a class="btn btn-primary btn-block" href="{{ route('threads.subscribe', $thread->slug()) }}">
                    Subscribe
                </a>
            @endcan

            @can(App\Policies\ThreadPolicy::DELETE, $thread)
                <a class="btn btn-danger btn-block" href="#" data-toggle="modal" data-target="#deleteThread">
                    Delete
                </a>

                @include('_partials._delete_modal', [
                    'id' => 'deleteThread',
                    'route' => ['threads.delete', $thread->slug()],
                    'title' => 'Delete Thread',
                    'body' => '<p>Are you sure you want to delete this thread and its replies? This cannot be undone.</p>',
                ])
            @endcan

            <a class="btn btn-link btn-block" href="{{ route('forum') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>

            @include('layouts._ads._forum_sidebar')
        </div>
        <div class="col-md-9">
            <h1>{{ $title }}</h1>
            <hr>

            <div class="panel panel-default">
                <div class="panel-heading thread-info">
                    @include('forum.threads.info.avatar', ['user' => $thread->author()])

                    <div class="thread-info-author">
                        <a href="{{ route('profile', $thread->author()->username()) }}" class="thread-info-link">{{ $thread->author()->name() }}</a>
                        posted {{ $thread->createdAt()->diffForHumans() }}
                    </div>

                    @include('forum.threads.info.tags')
                </div>

                <div class="panel-body forum-content">
                    @md($thread->body())
                </div>
            </div>

            @include('layouts._ads._carbon')

            @foreach ($thread->replies() as $reply)
                <div class="panel {{ $thread->isSolutionReply($reply) ? 'panel-success' : 'panel-default' }}">
                    <div class="panel-heading thread-info">
                        @include('forum.threads.info.avatar', ['user' => $reply->author()])

                        <div class="thread-info-author">
                            <a href="{{ route('profile', $reply->author()->username()) }}" class="thread-info-link">
                                {{ $reply->author()->name() }}
                            </a> replied
                            {{ $reply->createdAt()->diffForHumans() }}

                            @if ($thread->isSolutionReply($reply))
                                <span class="label label-primary thread-info-badge">
                                    Solution
                                </span>
                            @endif
                        </div>

                        @can(App\Policies\ReplyPolicy::UPDATE, $reply)
                            <div class="thread-info-tags">
                                <a class="btn btn-default btn-xs" href="{{ route('replies.edit', $reply->id()) }}">
                                    Edit
                                </a>
                                <a class="btn btn-danger btn-xs" href="#" data-toggle="modal" data-target="#deleteReply{{ $reply->id() }}">
                                    Delete
                                </a>
                            </div>
                        @endcan
                    </div>

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
                </div>

                @include('_partials._delete_modal', [
                    'id' => "deleteReply{$reply->id()}",
                    'route' => ['replies.delete', $reply->id()],
                    'title' => 'Delete Reply',
                    'body' => '<p>Are you sure you want to delete this reply? This cannot be undone.</p>',
                ])
            @endforeach

            @can(App\Policies\ReplyPolicy::CREATE, App\Models\Reply::class)
                <hr>

                <div class="alert alert-info">
                    <p>
                        Please make sure you've read our
                        <a href="{{ route('rules') }}" class="alert-link">Forum Rules</a> before replying to this thread.
                    </p>
                </div>

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

            @if (Auth::guest())
                <hr>
                <p class="text-center">
                    <a href="{{ route('login') }}">Sign in</a> to participate in this thread!
                </p>
            @endif
        </div>
    </div>
@endsection
