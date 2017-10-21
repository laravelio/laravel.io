{!! Form::open(['route' => $route, 'method' => $method ?? 'POST']) !!}
    @formGroup('subject')
        {!! Form::label('subject') !!}
        {!! Form::text('subject', isset($thread) ? $thread->subject() : null, ['class' => 'form-control', 'required', 'maxlength' => '60']) !!}
        <span class="help-block">Maximum 60 characters.</span>
        @error('subject')
    @endFormGroup

    @formGroup('body')
        {!! Form::label('body') !!}
        {!! Form::textarea('body', isset($thread) ? $thread->body() : null, ['class' => 'form-control wysiwyg', 'required']) !!}
        @error('body')
    @endFormGroup

    @formGroup('tags')
        {!! Form::label('tags') !!}
        {!! Form::select('tags[]', $tags->pluck('name', 'id'), isset($thread) ? $thread->tags()->pluck('id')->toArray() : [], ['class' => 'form-control selectize', 'multiple']) !!}
        <span class="help-block">You can choose up to 3 tags.</span>
        @error('tags')
    @endFormGroup

    {!! Form::submit(isset($thread) ? 'Update Thread' : 'Create Thread', ['class' => 'btn btn-primary btn-block']) !!}
    <a href="{{ isset($thread) ? route('thread', $thread->slug()) : route('forum') }}" class="btn btn-default btn-block">Cancel</a>
{!! Form::close() !!}
