@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('users._sidebar')
@stop

@section('content')
<section class="user-content">

@if($threads->count() > 0)
    <div class="header">
        <h1>Threads by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @foreach($threads as $thread)
            <div class="thread-summary">
                {{ $thread->author->thumbnail }}
                <div class="info">
                    <h3><a href="{{ $thread->forumThreadUrl }}">{{ $thread->title }}</a></h3>
                    <ul class="meta">
                        <li>posted {{ $thread->created_ago }}</li>
                        <li>by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endif



@if($comments->count())
    <div class="header double">
        <h1>Replies by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @foreach($comments as $comment)
            <div class="thread-summary">
                {{ $comment->author->thumbnail }}
                <div class="info">
                    <h3><a href="{{ $comment->commentUrl }}">In reply to: {{ $comment->parent->title }}</a></h3>
                    <ul class="meta">
                        <li>posted {{ $comment->created_ago }}</li>
                        <li>by <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endif


</section>
@stop