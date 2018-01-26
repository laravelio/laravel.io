@extends('layouts.base', ['bodyClass' => 'home'])

@section('body')
    <div class="container">
        @include('layouts._alerts')
    </div>

    <div class="jumbotron text-center">
        <div class="logo"><img src="{{ asset('images/logo.svg') }}" title="{{ config('app.name') }}"></div>
        <h2>Developers</h2>
        <h4>community in the Maldives</h4>

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
