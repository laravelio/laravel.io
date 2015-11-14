<h1>Edit your thread</h1>

{!! Form::open(['route' => ['threads.update', $thread->slug()], 'method' => 'PUT']) !!}
    {!! Form::text('subject', $thread->subject()) !!}<br>
    {{ $errors->first('subject') }}<br>
    {!! Form::textarea('body', $thread->body()) !!}<br>
    {{ $errors->first('body') }}<br>
    {!! Form::submit('Update') !!}
{!! Form::close() !!}
