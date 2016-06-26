@php($title = 'Forum')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    @if (count($threads))
        @foreach ($threads as $thread)
            <h2><a href="{{ route('thread', $thread->slug()) }}">{{ $thread->subject() }}</a></h2>
            <p>
                {{ $thread->createdAt()->diffForHumans() }} |
                {{ count($thread->replies()) }} replies
            </p>
        @endforeach
    @endif

    <div class="text-center">
        {!! $threads->render() !!}
    </div>
@stop
