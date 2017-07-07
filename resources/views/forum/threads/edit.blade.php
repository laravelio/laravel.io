@title('Edit your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    <div class="alert alert-info">
        <p>
            Please make sure you've read our
            <a href="{{ route('rules') }}" class="alert-link">Forum Rules</a> before updating this thread.
        </p>
    </div>

    @include('forum.threads._form', [
        'route' => ['threads.update', $thread->slug()],
        'method' => 'PUT',
    ])
@endsection
