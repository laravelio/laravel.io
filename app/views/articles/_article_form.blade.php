            <div class="form-row">
                {{ Form::label('title', 'Title', ['class' => 'field-title']) }}
                {{ Form::text('title', null, ['placeholder' => 'Title']) }}
                {{ $errors->first('title', '<small class="error">:message</small>') }}
            </div>

            <div class="form-row">
                {{ Form::label('content', 'Thread', ['class' => 'field-title']) }}
                {{ Form::textarea("content", null) }}
                {{ $errors->first('content', '<small class="error">:message</small>') }}
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

            <div class="form-row">
                {{ Form::label('status', 'Status', ['class' => 'field-title']) }}
                {{ Form::select('status', [0 => 'Draft', 1 => 'Published']) }}
                {{ $errors->first('status', '<small class="error">:message</small>') }}
            </div>

            <div class="form-row tags">
                @include('forum._tag_chooser')
            </div>

            <div class="form-row">
                {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
            </div>


