@title('Forbidden')

@extends('layouts.base')

@section('body')
    <div class="my-20 text-center text-gray-800">
        <h1 class="text-5xl">{{ $title }}</h1>
        <p class="text-lg">You're not allowed to this page.</p>
    </div>
@endsection
