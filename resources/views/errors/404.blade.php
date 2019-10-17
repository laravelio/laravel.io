@title('Page not found')

@extends('layouts.base')

@section('body')
    <div class="my-20 text-center text-gray-800">
        <h1 class="text-5xl">{{ $title }}</h1>
        <p class="text-lg">The page you requested cannot be found.</p>
    </div>
@endsection
