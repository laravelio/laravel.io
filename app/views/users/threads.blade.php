@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('users._sidebar')
@stop

@section('content')
<section class="user-content">
@if($threads->count() > 0)
    <div class="header">
        <h1>Threads by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @foreach($threads as $thread)
            <div class="thread-summary">
                {{ $thread->author->thumbnail }}
                <div class="info">
                    <h3><a href="{{ $thread->url }}">{{{ $thread->subject }}}</a></h3>
                    <ul class="meta">
                        <li>posted {{ $thread->created_ago }}</li>
                        <li>by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination">
        {{ $threads->links() }}
    </div>
@endif
</section>
@stop
