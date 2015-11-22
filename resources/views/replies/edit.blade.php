@extends('layouts.default')

@section('content')
    <h1>Edit your reply</h1>

    {!! Form::open(['route' => ['replies.update', $reply->id()], 'method' => 'PUT']) !!}
        {!! Form::textarea('body', $reply->body()) !!}<br>
        {{ $errors->first('body') }}<br>
        {!! Form::submit('Update') !!}
    {!! Form::close() !!}
@stop
