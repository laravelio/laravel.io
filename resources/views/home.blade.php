@extends('layouts.default')

@section('content')
    <h1>Laravel.io</h1>
    <h2>The Laravel Community Portal</h2>

    @if (Auth::guest())
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('signup') }}">Signup</a>
    @else
        Hi, <a href="{{ route('dashboard') }}">{{ Auth::user()->name }}</a> |
        <a href="{{ route('logout') }}">Logout</a>
    @endif
@stop
