@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop


@section('content')
<div class="forum">
    <div class="header">
        <h1>{{ $thread->title }}</h1>
    </div>
    <div class="thread">
        {{ $thread->body }}
    </div>
    <div class="comments">
        @foreach($comments as $comment)
            @include('forum._comment')
        @endforeach
    </div>
</div>


    <div class="row forum">
        <div class="small-12 columns comments">




            @if(Auth::check())
                <div class="row">
                    <div class="small-12 columns form">
                        {{ Form::open() }}
                            <fieldset>
                                <legend>Reply</legend>
                                <div class="row">
                                    <div>
                                        {{ Form::textarea("body", null, ['class' => '_tab_indent']) }}
                                        {{ $errors->first('body', '<small class="error">:message</small>') }}

                                        {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
                                        <small>Paste a <a href="https://gist.github.com" target="_NEW">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>
                                    </div>
                                </div>
                            </fieldset>
                        {{ Form::close() }}
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="small-12 columns form">
                        <p class="right">Want to reply to this thread? <a class="button" href="{{ action('AuthController@getLogin') }}">Login with github.</a></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
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