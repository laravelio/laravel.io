@extends('layouts.default')

@section('default-content')
    <h1>Edit your reply</h1>

    {!! Form::open(['route' => ['replies.update', $reply->id()], 'method' => 'PUT']) !!}
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body') !!}
            {!! Form::textarea('body', $reply->body(), ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
        </div>
        {!! Form::submit('Update', ['class' => 'btn btn-primary btn-block']) !!}
        <a href="{{ route_to_reply_able($reply->replyAble()) }}" class="btn btn-default btn-block">Cancel</a>
    {!! Form::close() !!}
@stop
