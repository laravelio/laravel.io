@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('forum._sidebar')
@stop

@section('content')
    <div class="header">
        <h1>Create Thread</h1>
    </div>

    <section class="padding">
        <p>Woha, slow down! You can only create a thread every 10 minutes. Please try again in a few minutes.</p>
        <p><a href="{{ action('ForumThreadsController@getIndex') }}">Back to forums.</a></p>
    </section>
@stop
