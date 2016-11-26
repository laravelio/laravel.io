@title('Tags')

@extends('layouts.default')

@section('content')
    <h1>{{ $title }}</h1>

    @foreach ($tags as $tag)
        <h2><a href="{{ route('tag', $tag->slug()) }}">{{ $tag->name() }}</a></h2>
        <p>{{ $tag->description() }}</p>
    @endforeach
@endsection
