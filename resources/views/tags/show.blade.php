@title($tag->name())

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <p>{{ $tag->description() }}</p>

    <h2>Latest Tagged Threads</h2>

    @foreach ($tag->threads() as $thread)
        <h3>{{ $thread->subject() }}</h3>
    @endforeach
@stop
