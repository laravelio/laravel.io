@title('Create your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    <hr>

    @include('forum.threads._form', ['route' => 'threads.store'])
@endsection
