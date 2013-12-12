@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="row forum">
        <div class="small-12 columns form">
            {{ Form::open() }}
                <fieldset>
                    <legend>Create Thread</legend>

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
                            <small class="gist">Paste a <a target="_blank" href="https://gist.github.com">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="">
                            {{ Form::label('laravel_version', 'Laravel Version') }}

                            @foreach($versions as $value => $version)
                                {{ Form::radio('laravel_version', $value) }} {{ $version }}
                            @endforeach

                            {{ $errors->first('laravel_version', '<small class="error">:message</small>') }}
                        </div>
                    </div>

                    @include('forum._tag_chooser')

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
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop