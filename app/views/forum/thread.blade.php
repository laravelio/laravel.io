@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')

<div class="row forum">
    <div class="small-12 columns comments">
        @foreach($comments as $comment)
            <div class="comment" id="comment-{{ $comment->id }}">
                <div class="user">
                    {{ $comment->author->thumbnail  }}
                </div>
                <div class="content">
                    @if($comment->id == $thread->id)
                        <h1>{{ $comment->title }}</h1>
                        <div class="tags">Tags:  {{ $comment->tags->getTagList() }}</div>
                        {{ $comment->body }}
                        <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            <li><i class="icon-user"></i><a href="{{ $comment->author->profileUrl }}"> {{ $comment->author->name }}</a></li>
                        </ul>
                    @else
                        {{ $comment->body }}
                          <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            <li><i class="icon-user"></i> <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
                            <li><i class="icon-link"></i> <a href="{{ $comment->commentUrl }}">Share</a></li>
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach

    {{ $comments->links() }}

    <div class="row">
        <div class="small-12 columns form">

            {{ Form::open() }}

                <fieldset>
                    <legend>Reply</legend>

                    <div class="row">
                        <div>
                            <div id="markdown_editor"></div>
                            {{ Form::textarea('body', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
                            {{ $errors->first('body', '<small class="error">:message</small>') }}
                            {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
                        </div>
                    </div>
                </fieldset>

            {{ Form::close() }}
        </div>
</div>
@stop

@include('layouts._markdown_editor')
@include('layouts._code_prettify')
