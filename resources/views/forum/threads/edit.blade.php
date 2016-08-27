@title('Edit your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    {!! Form::open(['route' => ['threads.update', $thread->slug()], 'method' => 'PUT']) !!}
        @formGroup('topic')
            {!! Form::label('topic') !!}
            {!! Form::select('topic', $topics->pluck('name', 'id'), $thread->topic()->id(), ['class' => 'form-control', 'required']) !!}
            @error('topic')
        @endFormGroup

        @formGroup('subject')
            {!! Form::label('subject') !!}
            {!! Form::text('subject', $thread->subject(), ['class' => 'form-control', 'required']) !!}
            @error('subject')
        @endFormGroup

        @formGroup('body')
            {!! Form::label('body') !!}
            {!! Form::textarea('body', $thread->body(), ['class' => 'form-control', 'required']) !!}
            @error('body')
        @endFormGroup

        @formGroup('tags')
            {!! Form::label('tags') !!}
            {!! Form::select('tags[]', $tags->pluck('name', 'id'), $thread->tags()->pluck('id')->toArray(), ['class' => 'form-control selectize', 'multiple']) !!}
            @error('tags')
        @endFormGroup

        {!! Form::submit('Update', ['class' => 'btn btn-primary btn-block']) !!}
        <a href="{{ route('thread', $thread->slug()) }}" class="btn btn-default btn-block">Cancel</a>
    {!! Form::close() !!}
@stop
