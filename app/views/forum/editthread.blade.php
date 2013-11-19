{{ Form::model($thread->resource) }}

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
                <div id="markdown_editor"></div>
                {{ Form::textarea('body', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
                {{ $errors->first('body', '<small class="error">:message</small>') }}
            </div>
        </div>

        <div class="row">
            @if($tags->count() > 0)
                <h3>Describe your post with up to 3 tags</h3>
                {{ $errors->first('tags', '<small class="error">:message</small>') }}
                <ul class="tags">
                    @foreach($tags as $tag)
                        <li>
                            <label>
                            {{ Form::checkbox("tags[{$tag->id}]", $tag->id, isset($thread) ? $thread->hasTag($tag->id) : null) }} <span title="{{ $tag->description }}">{{ $tag->name }}</span>
                            </label> - {{ $tag->description }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="row">
            {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
        </div>

    </fieldset>

{{ Form::close() }}

@include('layouts._markdown_editor')

@section('scripts')
    @parent
    <script src="{{ asset('javascripts/forums.js') }}"></script>
@stop