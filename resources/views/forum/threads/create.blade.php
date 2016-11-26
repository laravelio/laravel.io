@title('Create your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    {!! Form::open(['route' => 'threads.store']) !!}
        @formGroup('topic')
            {!! Form::label('topic') !!}
            {!! Form::select('topic', $topics->pluck('name', 'id'), null, ['class' => 'form-control', 'required']) !!}
            @error('topic')
        @endFormGroup

        @formGroup('subject')
            {!! Form::label('subject') !!}
            {!! Form::text('subject', null, ['class' => 'form-control', 'required']) !!}
            @error('subject')
        @endFormGroup

        @formGroup('body')
            {!! Form::label('body') !!}
            {!! Form::textarea('body', null, ['class' => 'form-control', 'required']) !!}
            @error('body')
        @endFormGroup

        @formGroup('tags')
            {!! Form::label('tags') !!}
            {!! Form::select('tags[]', $tags->pluck('name', 'id'), null, ['class' => 'form-control selectize', 'multiple']) !!}
            @error('tags')
        @endFormGroup

        {!! Form::submit('Create Thread', ['class' => 'btn btn-primary btn-block']) !!}
        <a href="{{ route('forum') }}" class="btn btn-default btn-block">Cancel</a>
    {!! Form::close() !!}
@endsection
