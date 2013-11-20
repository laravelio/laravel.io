@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

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
                                {{ Form::textarea("body", null) }}YPPY%$
                                {{ $errors->first('body', '<small class="error">:message</small>') }}

                                {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
                            </div>
                        </div>
                    </fieldset>

                {{ Form::close() }}
            </div>
        </div>
    @else
        <a href="{{ action('AuthController@getLogin') }}">Login to reply.</a>
    @endif
@stop

@include('layouts._markdown_editor')
@include('layouts._code_prettify')

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop