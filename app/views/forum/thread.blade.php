@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

<style>
/* Better styles for embedding GitHub Gists */
.gist{font-size:13px;line-height:18px;margin-bottom:20px;width:100%}
.gist pre{font-family:Menlo,Monaco,'Bitstream Vera Sans Mono','Courier New',monospace !important}
.gist-meta{font-family:Helvetica,Arial,sans-serif;font-size:13px !important}
.gist-meta a{color:#26a !important;text-decoration:none}
.gist-meta a:hover{color:#0e4071 !important}
</style>
@section('content')

<div class="row forum">
    <div class="small-12 columns comments">
        @foreach($comments as $comment)
            @include('forum._comment')
        @endforeach

    {{ $comments->links() }}

    @if(Auth::check())
        <div class="row">
            <div class="small-12 columns form">

                {{ Form::open() }}

                    <fieldset>
                        <legend>Reply</legend>

                        <div class="row">
                            <div>
                                {{ Form::textarea("body", null) }}
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
@stop

@include('layouts._markdown_editor')
@include('layouts._code_prettify')

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop