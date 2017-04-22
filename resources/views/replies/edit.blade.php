@title('Edit your reply')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    {!! Form::open(['route' => ['replies.update', $reply->id()], 'method' => 'PUT']) !!}
        @formGroup('body')
            {!! Form::textarea('body', $reply->body(), ['class' => 'form-control wysiwyg', 'required']) !!}
            @error('body')
        @endFormGroup

        {!! Form::submit('Update', ['class' => 'btn btn-primary btn-block']) !!}
        <a href="{{ route_to_reply_able($reply->replyAble()) }}" class="btn btn-default btn-block">Cancel</a>
    {!! Form::close() !!}
@endsection
