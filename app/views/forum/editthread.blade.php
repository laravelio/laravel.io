@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="row forum">
        <div class="small-12 columns form">
            {{ Form::model($thread->resource) }}
                <fieldset>
                    <legend>Edit Thread</legend>

                    <div class="row">
                        <div class="">
                            {{ Form::label('title', 'Title') }}
                            {{ Form::text('title', null, ['placeholder' => 'Title']) }}
                            {{ $errors->first('title', '<small class="error">:message</small>') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="">
                            {{ Form::label('body', 'Thread') }}
                            {{ Form::textarea("body", null) }}
                            {{ $errors->first('body', '<small class="error">:message</small>') }}
                            <small>Paste a <a href="https://gist.github.com" target="_NEW">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>
                        </div>
                    </div>

                    @include('forum._tag_chooser', ['comment' => $thread])

                    <div class="row">
                        {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
                    </div>
                </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop