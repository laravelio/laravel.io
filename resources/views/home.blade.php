@extends('layouts.base', ['bodyClass' => 'home'])

@section('body')
    <div class="jumbotron text-center">
        <h1>Laravel.io</h1>
        <h2>The Laravel Community Portal</h2>
        <p>
            <a class="btn btn-info" href="#" role="button">Write an Article</a>
            <a class="btn btn-info" href="{{ route('threads.create') }}" role="button">Start a Discussion</a>
        </p>
    </div>
@stop
