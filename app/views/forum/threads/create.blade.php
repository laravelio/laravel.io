@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
        <div class="header">
            <h1>Create Thread</h1>
        </div>
        {{ Form::open(['data-persist' => 'garlic', 'data-expires' => '600']) }}
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
                {{ Form::label('laravel_version', 'Laravel Version', ['class' => 'field-title']) }}
                <ul class="version tags">
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
                @include('forum._tag_chooser')
            </div>

            <div class="form-row">
                {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
            </div>
        </section>
        {{ Form::close() }}
@stop

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
    <script src="{{ asset('javascripts/vendor/garlic.js') }}"></script>
@stop