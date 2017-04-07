@extends('layouts.base', ['bodyClass' => 'home'])

@section('body')
    <div class="container">
        @include('layouts._alerts')
    </div>

    <div class="jumbotron text-center">
        <h1>Laravel.io</h1>
        <h2>The Laravel Community Portal</h2>
    </div>
@endsection
