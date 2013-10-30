@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('users._sidebar')
@stop

@section('content')
<section class="user-content">


@if(count($threads))
<div class="half">
    <h1>{{ $user->name }}'s Latest Threads</h1>
    <div class="comments">
        @foreach($threads as $thread)
            <div class="comment">
                <div class="content">
                        <h2>{{ $thread->title }}</h2>
                        {{ $thread->bodySummary }}
                          <ul class="meta">
                            <li><i class="icon-time"></i> {{ $thread->created_ago }}</li>
                            <li><a href="{{ $thread->forumThreadUrl }}"><i class="icon-eye"></i> View Thread</a></li>
                        </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

@if(count($comments))
<div class="half">
    <h1>{{ $user->name }}'s Latest Replies</h1>
    <div class="comments">
        @foreach($comments as $comment)
            <div class="comment">
                <div class="content">
                        <h2>RE: {{ $comment->parent->title }}</h2>
                        {{ $comment->bodySummary }}
                          <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            <li><a href="{{ $comment->commentUrl }}"><i class="icon-eye"></i> View Comment</a></li>
                        </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif


</section>
@stop