@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')

    {{ Form::open() }}
        <div class="header">
            <h1>Create Thread</h1>
        </div>

        <section class="padding">
            <div class="form-row">
                {{ Form::label('title', 'Title', ['class' => 'field-title']) }}
                {{ Form::text('title', null, ['placeholder' => 'Title']) }}
                {{ $errors->first('title', '<small class="error">:message</small>') }}
            </div>

            <div class="form-row">
                {{ Form::label('body', 'Thread', ['class' => 'field-title']) }}
                {{ Form::textarea("body", null) }}
                {{ $errors->first('body', '<small class="error">:message</small>') }}
                <small class="gist">Paste a <a target="_blank" href="https://gist.github.com">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>
            </div>

            <div class="form-row">
                {{ Form::label('laravel_version', 'Laravel Version', ['class' => 'field-title']) }}
                <ul class="version">
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
        {{ Form::close() }}
        </section>
@stop

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/tabby.js') }}"></script>
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop