@title($user->name())

@extends('layouts.default', ['title' => $user->name()])

@section('content')
    <h1>{{ $title }}</h1>

    @if ($user->githubUsername())
        <a href="https://github.com/{{ $user->githubUsername() }}">Github</a>
    @endif
@endsection
