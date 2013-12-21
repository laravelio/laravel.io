@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('articles._sidebar')
@stop

@section('content')
<div class="header">
    <h1>Article</h1>
</div>

        <article>
            <h2>{{ $article->title }}</h2>

            {{ $article->content }}
                    <div class="user">
                        {{ $article->author->thumbnail }}
                        <div class="info">
                            <h6><a href="{{ $article->forumThreadUrl }}">{{ $article->author->name }}</a></h6>
                            <ul class="meta">
                                <li>{{ $article->published_ago }}</li>
                            </ul>
                        </div>
                    </div>
                    @if(Auth::user() && $article->author_id == Auth::user()->id)
                        <div class="admin-bar">
                            <li><a class="button" href="{{ action('ArticlesController@getEdit', [$article->id]) }}">Edit</a></li>
                        </div>
                    @endif

        </article>

        <div class="comments">
            <h6 class="title">replies</h6>

            @foreach($comments as $comment)
                @include('articles._comment')
            @endforeach
        </div>

        {{ $comments->links() }}

        @if(Auth::check())
            <div class="reply-form">
                {{ Form::open() }}
                    <div class="form-row">
                        <label class="field-title">Reply</label>
                        {{ Form::textarea("body", null, ['class' => '_tab_indent']) }}
                        {{ $errors->first('body', '<small class="error">:message</small>') }}
                        <small>Paste a <a href="https://gist.github.com" target="_NEW">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>
                    </div>

                    <div class="form-row">
                        {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
                    </div>
            </div>
        @else
            <div class="login-cta">
                <p>Want to reply to this thread?</p> <a class="button" href="{{ action('AuthController@getLogin') }}">Login with github.</a>
            </div>
        @endif
@stop

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
    <link rel="stylesheet" href="http://yandex.st/highlightjs/7.5/styles/obsidian.min.css">
    <script src="http://yandex.st/highlightjs/7.5/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
@stop