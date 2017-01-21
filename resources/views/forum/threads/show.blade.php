@extends('layouts._two_columns_left_sidebar', ['pageTitle' => ($thread->isSolved() ? '[SOLVED] ' : '') . $thread->subject])

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="forum">
        <div class="header">
            <h2>Forum</h2>
            <div class="tags">
                {!! $thread->tags->getTagList() !!}
            </div>
            {!! $replies->render() !!}
        </div>

        @if (Input::get('page') < 2)
            @include('forum.threads._thread')
        @endif

        <div class="comments">
            @foreach ($replies as $reply)
                @include('forum.replies._show')
            @endforeach
        </div>

        {!! $replies->render() !!}
    </div>

    @if (Auth::check())
        @include('forum.replies._create')
    @else
        <div class="login-cta">
            <p>Want to reply to this thread?</p>
            <a class="button" href="{{ route('login') }}">Login with github.</a>
        </div>
    @endif
@stop

@include('layouts._markdown_editor')
@include('layouts._code_prettify')

@section('scripts')
    @parent

    <link rel="stylesheet" href="https://yandex.st/highlightjs/7.5/styles/obsidian.min.css">
    <script src="https://yandex.st/highlightjs/7.5/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
@stop
