<div class="reply-form">
    {{ Form::open() }}
        <div class="form-row">
            <label class="field-title">Reply</label>
            {{ Form::textarea("body", null, ['class' => '_tab_indent _reply_form']) }}
            {{ $errors->first('body', '<small class="error">:message</small>') }}
            <small><a href="http://laravel.io/forum/01-31-2014-how-to-mark-up-forum-posts" target="_BLANK">Learn how to mark up your post here.</a></small>
        </div>

        <div class="form-row">
            {{ Form::button('Reply', ['type' => 'submit', 'class' => 'button']) }}
        </div>
    {{ Form::close() }}
</div>