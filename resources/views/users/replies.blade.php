@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('users._sidebar')
@stop

@section('content')
<section class="user-content">
@if ($replies->count())
    <div class="header double">
        <h1>Replies by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @foreach($replies as $reply)
            <div class="thread-summary">
                {!! $reply->author->thumbnail !!}

                <div class="info">
                    <h3><a href="{{ $reply->url }}">In reply to: {{ $reply->thread->subject }}</a></h3>
                    <ul class="meta">
                        <li>posted {{ $reply->created_ago }}</li>
                        <li>by <a href="{{ $reply->author->profileUrl }}">{{ $reply->author->name }}</a></li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination">
        {!! $replies->render() !!}
    </div>
@endif


</section>
@stop
