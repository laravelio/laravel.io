@title('Edit your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    @include('forum.threads._form', [
        'route' => ['threads.update', $thread->slug()],
        'method' => 'PUT',
    ])
@endsection
