@extends('layouts.base', ['bodyClass' => 'home'])

@section('body')
    <div class="container">
        @include('layouts._alerts')
    </div>

    <div class="jumbotron text-center">
        <div class="logo"><img src="{{ asset('images/laravelio.png') }}" title="Laravel.io"></div>
        <h2>The Laravel Community Portal</h2>

        <div style="margin-top:40px">
            @if (Auth::guest())
                <a class="btn btn-primary" href="{{ route('register') }}">
                    Join the Community
                </a>
                <a class="btn btn-default" href="{{ route('forum') }}">
                    Visit the Forum
                </a>
            @else
                <a class="btn btn-default" href="{{ route('threads.create') }}">
                    Start a Thread
                </a>
            @endif
        </div>
    </div>
@endsection
