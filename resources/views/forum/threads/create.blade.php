@extends('layouts.default')

@section('default-content')
    <h1>Create your thread</h1>

    {!! Form::open(['route' => 'threads.store']) !!}
        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
            {!! Form::label('subject') !!}
            {!! Form::text('subject', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('subject', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body') !!}
            {!! Form::textarea('body', null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
        </div>
        {!! Form::submit('Create Thread', ['class' => 'btn btn-primary btn-block']) !!}
        <a href="{{ route('forum') }}" class="btn btn-default btn-block">Cancel</a>
    {!! Form::close() !!}
@stop
