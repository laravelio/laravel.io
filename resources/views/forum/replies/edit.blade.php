@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="header">
        <h1>Edit Your Reply</h1>
    </div>

    <div class="reply-form">
        {!! Form::model($reply->getWrappedObject()) !!}
            <div class="form-row">
                <label class="field-title">Reply</label>
                {!! Form::textarea("body", null, ['class' => '_tab_indent']) !!}
                {!! $errors->first('body', '<small class="error">:message</small>') !!}
                <small><a href="http://laravel.io/forum/01-31-2014-how-to-mark-up-forum-posts" target="_blank">Learn how to mark up your post here.</a></small>
            </div>

            <div class="form-row">
                {!! Form::button('Reply', ['type' => 'submit', 'class' => 'button']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@stop

