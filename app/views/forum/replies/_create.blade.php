<div class="reply-form">
    {{ Form::open() }}
        <div class="form-row">
            <label class="field-title">Reply</label>
            {{ Form::textarea("body", null, ['class' => '_tab_indent']) }}
            {{ $errors->first('body', '<small class="error">:message</small>') }}
            <small>Paste a <a href="https://gist.github.com" target="_NEW">Gist</a> URL to embed source. <em>example: https://gist.github.com/username/1234</em></small>
        </div>

        <div class="form-row">
            {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
        </div>
    {{ Form::close() }}
</div>