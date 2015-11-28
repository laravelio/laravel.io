@extends('layouts.default')

@section('default-content')
    <h1>Edit your thread</h1>

    {!! Form::open(['route' => ['threads.update', $thread->slug()], 'method' => 'PUT']) !!}
        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
            {!! Form::label('subject') !!}
            {!! Form::text('subject', $thread->subject(), ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('subject', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body') !!}
            {!! Form::textarea('body', $thread->body(), ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
        </div>
        {!! Form::submit('Update', ['class' => 'btn btn-primary btn-block']) !!}
        <a href="{{ route('thread', $thread->slug()) }}" class="btn btn-default btn-block">Cancel</a>
    {!! Form::close() !!}
@stop
