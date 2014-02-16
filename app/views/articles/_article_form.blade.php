<div class="form-row">
    {{ Form::label('title', 'Title', ['class' => 'field-subject']) }}
    {{ Form::text('title', null, ['placeholder' => 'Title']) }}
    {{ $errors->first('title', '<small class="error">:message</small>') }}
</div>

<div class="form-row">
    {{ Form::label('content', 'Content', ['class' => 'field-title']) }}
    {{ Form::textarea('content', null) }}
    {{ $errors->first('content', '<small class="error">:message</small>') }}
    <small><a href="http://laravel.io/forum/01-31-2014-how-to-mark-up-forum-posts" target="_BLANK">Learn how to mark up your articles here.</a></small>
</div>

<div class="form-row">
    {{ Form::label('status', 'Status', ['class' => 'field-title']) }}
    {{ Form::select('status', [0 => 'Draft', 1 => 'Published']) }}
    {{ $errors->first('status', '<small class="error">:message</small>') }}
</div>

<div class="form-row">
    {{ Form::label('laravel_version', 'Laravel Version', ['class' => 'field-title']) }}
    <ul class="version tags _version_tags">
        <li>
            <label class="tag">
                Laravel 4.x
                {{ Form::radio('laravel_version', 4, true) }}
            </label>
        </li>
        <li>
            <label class="tag">
                Laravel 3.x
                {{ Form::radio('laravel_version', 3) }}
            </label>
        </li>
        <li>
            <label class="tag">
                Doesn't Matter
                {{ Form::radio('laravel_version', 0) }}
            </label>
        </li>
    </ul>
    {{ $errors->first('laravel_version', '<small class="error">:message</small>') }}
</div>

<div class="form-row tags">
    @include('articles._tag_chooser')
</div>

<div class="form-row">
    {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
</div>


