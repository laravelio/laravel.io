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
            <a class="button" href="{{ action('ForumThreadsController@getCreateThread') }}">Create Thread</a>
        </div>
        <div class="thread">
            <h2>{{ $thread->laravel_version ? $thread->laravel_version . ' ' : '' }}{{ $thread->subject }}</h2>
            {{ $thread->body }}
            <div class="user">
                {{ $thread->author->thumbnail }}
                <div class="info">
                    <h6><a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></h6>
                    <ul class="meta">
                        <li>{{ $thread->created_ago }}</li>
                    </ul>
                </div>
            </div>

            @if(Auth::user() && $thread->id == $thread->id && $thread->author_id == Auth::user()->id)
                <div class="admin-bar">
                    <li><a class="button" href="{{ action('ForumThreadsController@getEditThread', [$thread->id]) }}">Edit</a></li>
                    <li><a class="button" href="{{ action('ForumThreadsController@getDelete', [$thread->id]) }}">Delete</a></li>
                </div>
            @endif
        </div>

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