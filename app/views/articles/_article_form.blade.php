<div class="row">
    <div class="">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', null, ['placeholder' => 'Title']) }}
        {{ $errors->first('title', '<small class="error">:message</small>') }}
    </div>
</div>

<div class="row">
    <div class="">
        {{ Form::label('content', 'Content') }}
        {{ Form::textarea("content", null) }}
        {{ $errors->first('content', '<small class="error">:message</small>') }}
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

@include('articles._tag_chooser')

<div class="row">
    <div class="">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', [0 => 'Draft', 1 => 'Published']) }}
        {{ $errors->first('status', '<small class="error">:message</small>') }}
    </div>
</div>

<div class="row">
    {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
</div>

