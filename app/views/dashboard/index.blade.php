@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('dashboard._sidebar')
@stop

@section('content')
<section class="user-content">


    <h1>{{ Auth::user()->name }}'s Forum Activity</h1>
    <div class="comments">
        @foreach($user->forumPosts as $comment)
            <div class="comment">
                <div class="content">
                        <p>{{ $comment->body }}</p>
                          <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            @if($comment->isMainComment())
                                <li><a href="{{ $comment->forumThreadUrl }}"><i class="icon-eye"></i> View Thread</a></li>
                            @else
                                <li><a href="{{ $comment->commentUrl }}"><i class="icon-eye"></i> View Comment</a></li>
                            @endif
                        </ul>
                </div>
            </div>
        @endforeach
    </div>
</section>
@stop