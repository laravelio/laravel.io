@php($subTitle = isset($activeTopic) ? $activeTopic->name() : null)
@php($subTitle = isset($activeTag) ? $activeTag->name() : $subTitle)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    <hr>

    <div class="row">
        <div class="col-md-3">
            <a class="btn btn-success btn-block" href="{{ route('threads.create') }}">Create Thread</a>

            @include('forum._topics')
            @include('forum._tags')
        </div>
        <div class="col-md-9">
            @include('forum._threads')
        </div>
    </div>
@endsection
