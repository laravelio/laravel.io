<div class="row">
    <div class="small-12 columns">
        <h2>Compose Article</h2>

        {{ Form::open() }}

            <fieldset>
                <div class="row">
                    <div class="small-1 columns">
                        {{ Form::label('title', 'Title') }}
                        {{ Form::text('title') }}
                        {{ $errors->first('title', '<small class="error">:message</small>') }}
                    </div>
                </div>

                <div class="row">
                    <div class="small-1 columns">
                        {{ Form::label('content', 'Content') }}
                        {{ Form::textarea('content') }}
                        {{ $errors->first('content', '<small class="error">:message</small>') }}
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