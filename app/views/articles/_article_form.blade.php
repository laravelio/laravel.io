<fieldset>
    <div class="row">
        <div class="">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title') }}
            {{ $errors->first('title', '<small class="error">:message</small>') }}
        </div>
    </div>

    <div class="row">
        <div class="">
            {{ Form::label('content', 'Content') }}
            <div id="markdown_editor"></div>
            {{ Form::textarea('content', null, ['id' => '_markdown_textarea', 'style' => 'display: none;']) }}
            {{ $errors->first('content', '<small class="error">:message</small>') }}
        </div>
    </div>

    <div class="row">
        <div class="">
            {{ Form::label('status', 'Status') }}
            {{ Form::select('status', [0 => 'Draft', 1 => 'Published']) }}
            {{ $errors->first('status', '<small class="error">:message</small>') }}
        </div>
    </div>
</fieldset>

@if($tags->count() > 0)
    <h3>tags</h3>
    <ul>
        @foreach($tags as $tag)
            <li>{{ Form::checkbox("tags[{$tag->id}]", $tag->id, isset($article) ? $article->hasTag($tag->id) : null) }} <span title="{{ $tag->description }}">{{ $tag->name }}</span></li>
        @endforeach
    </ul>
@endif

<div class="row">
    <div class="large-12 columns">
        {{ Form::button('Save', ['type' => 'submit']) }}
    </div>
</div>

@include('layouts._markdown_editor')