@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('users._sidebar')
@stop

@section('content')
<section class="user-content">
@if($threads->count() > 0)
    <div class="header">
        <h1>Latest Threads by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @foreach($threads as $thread)
            <div class="thread-summary">
                {{ $thread->author->thumbnail }}
                <div class="info">
                    <h3><a href="{{ $thread->url }}">{{{ $thread->subject }}}</a></h3>
                    <ul class="meta">
                        <li>posted {{ $thread->created_ago }}</li>
                        <li>by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    @if ($threads->getTotal() > 5)
    <p class="section-navigation"><a class="button" href="{{ action('UsersController@getThreads', $user->name) }}">View all threads</a></p>
    @endif
@endif

@if($replies->count())
    <div class="header double">
        <h1>Latest Replies by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @foreach($replies as $reply)
            <div class="thread-summary">
                {{ $reply->author->thumbnail }}
                <div class="info">
                    <h3><a href="{{ $reply->url }}">In reply to: {{ $reply->thread->subject }}</a></h3>
                    <ul class="meta">
                        <li>posted {{ $reply->created_ago }}</li>
                        <li>by <a href="{{ $reply->author->profileUrl }}">{{ $reply->author->name }}</a></li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    @if ($replies->getTotal() > 5)
    <p class="section-navigation"><a class="button" href="{{ action('UsersController@getReplies', $user->name) }}">View all replies</a></p>
    @endif
@endif


</section>
@stop
