@title('Create your thread')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>
    <hr>

    <div class="alert alert-info">
        <p>
            Please try to search for your question first using
            <a href="{{ route('forum') }}" class="alert-link">the search box</a> and make sure you've read our
            <a href="{{ route('rules') }}" class="alert-link">Forum Rules</a> before creating a thread.
        </p>
    </div>

    @include('forum.threads._form', ['route' => 'threads.store'])
@endsection
