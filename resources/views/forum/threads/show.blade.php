<h1>{{ $thread->subject() }}</h1>

@if (count($replies = $thread->replies()))
    @foreach ($replies as $reply)
        <p>{{ $reply->body() }}</p>
    @endforeach
@endif

{!! Form::open(['route' => 'replies.store']) !!}
    {!! Form::textarea('body') !!}
    {!! Form::hidden('replyable_id', $thread->id()) !!}
    {!! Form::hidden('replyable_type', 'threads') !!}
    {!! Form::submit('Reply') !!}
{!! Form::close() !!}
