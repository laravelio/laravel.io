@title('Something went wrong')

@extends('layouts.base')

@section('body')
    <div class="my-20 text-center text-gray-800">
        <h1 class="text-5xl">{{ $title }}</h1>
        <p class="text-lg">
            We've been notified and will try to fix the problem as soon as possible.<br>
            Please <a href="https://github.com/laravelio/laravel.io/issues/new" class="text-lio-700">open a Github issue</a> if the problem persists.
        </p>
    </div>
@endsection
