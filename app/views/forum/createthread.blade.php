<div class="row">
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
                        <div id="markdown_editor"></div>
                        {{ Form::textarea('body', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
                        {{ $errors->first('body', '<small class="error">:message</small>') }}
                    </div>
                </div>

                <div class="row">
                        @if($tags->count() > 0)
                            <h3>tags</h3>
                            {{ $errors->first('tags', '<small class="error">:message</small>') }}
                            <ul class="tags">
                                @foreach($tags as $tag)
                                    <li>{{ Form::checkbox("tags[{$tag->id}]", $tag->id, isset($article) ? $article->hasTag($tag->id) : null) }} <span title="{{ $tag->description }}">{{ $tag->name }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                </div>



            </fieldset>
        <div class="small-12 columns">
            <div class="row">
                {{ Form::button('Save', ['type' => 'submit', 'class' => 'button']) }}
            </div>
        </div>
        {{ Form::close() }}

    </div>
</div>

@include('layouts._markdown_editor')