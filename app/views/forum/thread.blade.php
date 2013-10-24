@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
<div class="row forum">
    <div class="small-12 columns comments">
        @foreach($comments as $comment)
            <div class="comment">
                @if($comment->id == $thread->id)
                    <h2>{{ $comment->title }}</h2>

                    <p>{{ $comment->body }}</p>
                        <ul class="meta">
                            <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                            <li><i class="icon-user"></i><a href="{{ $comment->author->profileUrl }}"> {{ $comment->author->name }}</a></li>
                        </ul>
                        <ul class="tags">
                        @foreach($comment->tags as $tag)
                            <li><a href="">{{ $tag->name }} |</a></li>
                        @endforeach
                    </ul>
                @else
                    <p>{{ $comment->body }}</p>
                    <ul class="meta">
                        <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                        <li><i class="icon-user"></i> <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
                    </ul>
                @endif

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