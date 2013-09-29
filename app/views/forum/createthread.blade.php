
<div class="row">
    <div class="small-12 columns">
        <h2>Category {{ $category->title }}</h2>

        {{ Form::open() }}

            <fieldset>
                <legend>Create Thread</legend>

                <div class="row">
                    <div class="">
                        {{ Form::label('title', 'Title') }}
                        {{ Form::text('title') }}
                        {{ $errors->first('title', '<small class="error">:message</small>') }}
                    </div>
                </div>

                <div class="row">
                    <div class="">
                        {{ Form::label('body', 'Thread') }}
                        <div id="markdown_editor"></div>
                        {{ Form::textarea('body', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
                        {{ $errors->first('body', '<small class="error">:message</small>') }}
                    </div>
                </div>
            </fieldset>

            <div class="row">
                <div class="large-12 columns">
                    {{ Form::button('Save', ['type' => 'submit']) }}
                </div>
            </div>

        {{ Form::close() }}

    </div>
</div>

@include('layouts._markdown_editor')