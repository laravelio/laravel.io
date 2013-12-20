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
        @each('forum._thread_summary', $threads, 'thread')
    </div>
@endif



@if($comments->count())
    <div class="header double">
        <h1>Replies by {{ $user->name }}</h1>
    </div>
    <div class="threads">
        @each('forum._thread_summary', $comments, 'thread')
    </div>
@endif


</section>
@stop