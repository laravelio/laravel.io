@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
<div class="forum">
    <div class="header">
        <h1>Forum</h1>
        <div class="tags">
            {{ $thread->tags->getTagList() }}
        </div>
    </div>
    <div class="thread">
        <h2>{{ $thread->title }}</h2>
        {{ $thread->body }}
        <div class="user">
            {{ $thread->author->thumbnail }}
            <div class="info">
                <h6><a href="{{ $thread->forumThreadUrl }}">{{ $thread->author->name }}</a></h6>
                <ul class="meta">
                    <li>{{ $thread->created_ago }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="comments">
        @foreach($comments as $comment)
            @include('forum._comment')
        @endforeach
    </div>
    {{ $comments->links() }}
</div>

@if(Auth::check())
    <div class="reply-form">
        <h5>Reply</h5>
        {{ Form::open() }}
        {{ Form::textarea("body", null, ['class' => '_tab_indent']) }}
        {{ $errors->first('body', '<small class="error">:message</small>') }}
        <small>Paste a <a href="https://gist.github.com" target="_NEW">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>

        {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
    </div>
@else
    <div class="login-cta">
        <p>Want to reply to this thread? <a class="button" href="{{ action('AuthController@getLogin') }}">Login with github.</a></p>
    </div>
@endif

@stop

@include('layouts._markdown_editor')
@include('layouts._code_prettify')

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
    <link rel="stylesheet" href="http://yandex.st/highlightjs/7.5/styles/monokai.min.css">
    <script src="http://yandex.st/highlightjs/7.5/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
@stop