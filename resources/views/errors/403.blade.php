@php($title = 'Forbidden')

@extends('layouts.base')

@section('body')
    <div class="jumbotron text-center">
        <h1>{{ $title }}</h1>
        <p>You're not allow to this page.</p>
    </div>
@stop
