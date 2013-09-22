<h1>Create Article</h1>

{{ Form::open(['action' => 'Controllers\PostsController@postStore']) }}
<fieldset>
    {{ Form::label('title') }}
    {{ Form::text('title') }}

    {{ Form::label('slug') }}
    {{ Form::text('slug') }}

    {{ Form::label('content') }}
    {{ Form::textarea('content') }}
</fieldset>
{{ Form::close() }}