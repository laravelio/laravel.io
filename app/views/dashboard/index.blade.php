@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('dashboard._sidebar')
@stop

@section('content')
<section class="user-content">


    <h1>{{ Auth::user()->name }}'s Threads</h1>
    <div class="comments">
        @foreach($user->forumThreads as $comment)
            <div class="comment">
                <div class="content">
                        <h2>{{ $comment->title }}</h2>
                        <p>{{ $comment->body }}</p>
                          <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            <li><a href="{{ $comment->forumThreadUrl }}"><i class="icon-eye"></i> View Thread</a></li>
                        </ul>
                </div>
            </div>
        @endforeach
    </div>

    <h1>{{ Auth::user()->name }}'s Replies</h1>
    <div class="comments">
        @foreach($user->forumReplies as $comment)
            <div class="comment">
                <div class="content">
                        <h2>RE: {{ $comment->parent->title }}</h2>
                        <p>{{ $comment->body }}</p>
                          <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            <li><a href="{{ $comment->commentUrl }}#{{ $comment->id }}"><i class="icon-eye"></i> View Comment</a></li>
                        </ul>
                </div>
            </div>
        @endforeach
    </div>
</section>
@stop