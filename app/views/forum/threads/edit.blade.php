@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
{{ Form::model($thread->resource) }}
    <div class="header">
        <h1>Edit Thread</h1>
    </div>

    <section class="padding">
        <div class="form-row">
            {{ Form::label('subject', 'Subject', ['class' => 'field-title']) }}
            {{ Form::text('subject', null, ['placeholder' => 'Subject']) }}
            {{ $errors->first('subject', '<small class="error">:message</small>') }}
        </div>

        <div class="form-row">
            {{ Form::label('body', 'Thread', ['class' => 'field-title']) }}
            {{ Form::textarea("body", null) }}
            {{ $errors->first('body', '<small class="error">:message</small>') }}
            <small><a href="http://laravel.io/forum/01-31-2014-how-to-mark-up-forum-posts" target="_BLANK">Learn how to mark up your post here.</a></small>
        </div>

        <div class="form-row">
            {{ Form::label('is_question', 'What type of thread is this?', ['class' => 'field-title']) }}
            <ul class="version tags _question_tags">
                <li>
                    <label class="tag">
                        Question
                        {{ Form::radio('is_question', $thread->isQuestion(), true) }}
                    </label>
                </li>
                <li>
                    <label class="tag">
                        Conversation
                        {{ Form::radio('is_question', !$thread->isQuestion(), false) }}
                    </label>
                </li>
            </ul>
            {{ $errors->first('is_question', '<small class="error">:message</small>') }}
        </div>

        <div class="form-row">
            {{ Form::label('laravel_version', 'Laravel Version', ['class' => 'field-title']) }}
            <ul class="version tags _version_tags">
                @foreach($versions as $value => $version)
                    <li>
                        <label class="tag">
                            {{ $version }}
                            {{ Form::radio('laravel_version', $value) }}
                        </label>
                    </li>
                @endforeach
            </ul>
            {{ $errors->first('laravel_version', '<small class="error">:message</small>') }}
        </div>

        <div class="form-row tags">
            @include('forum._tag_chooser', ['comment' => $thread])
        </div>

        <div class="form-row">
            {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
        </div>
    {{ Form::close() }}
@stop
