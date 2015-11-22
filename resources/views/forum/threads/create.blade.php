@extends('layouts.default')

@section('content')
    <h1>Create your thread</h1>

    {!! Form::open(['route' => 'threads.store']) !!}
        {!! Form::text('subject') !!}<br>
        {{ $errors->first('subject') }}<br>
        {!! Form::textarea('body') !!}<br>
        {{ $errors->first('body') }}<br>
        {!! Form::submit('Create Thread') !!}
    {!! Form::close() !!}
@stop
