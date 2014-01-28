@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="forum">
        <div class="header">
            <h1>{{ $thread->subject }}</h1>
            <div class="tags">
                {{ $thread->tags->getTagList() }}
            </div>
        </div>

        @if(Input::get('page') < 2)
            @include('forum.threads._thread')
        @else
        @endif

        <div class="comments">
            @foreach($replies as $reply)
                @include('forum.replies._show')
            @endforeach
        </div>
        {{ $replies->links() }}
    </div>

    @if(Auth::check())
        @include('forum.replies._create')
    @else
        <div class="login-cta">
            <p>Want to reply to this thread?</p> <a class="button" href="{{ action('AuthController@getLogin') }}">Login with github.</a>
        </div>
    @endif
@stop

@include('layouts._markdown_editor')
@include('layouts._code_prettify')

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
    <link rel="stylesheet" href="http://yandex.st/highlightjs/7.5/styles/obsidian.min.css">
    <script src="http://yandex.st/highlightjs/7.5/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
@stop