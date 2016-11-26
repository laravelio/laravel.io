@title('Page not found')

@extends('layouts.base')

@section('body')
    <div class="jumbotron text-center">
        <h1>{{ $title }}</h1>
        <p>The page you requested cannot be found.</p>
    </div>
@endsection
