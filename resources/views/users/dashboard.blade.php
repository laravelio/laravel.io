@extends('layouts.default')

@section('default-content')
    <h1>Welcome {{ Auth::user()->name }}!</h1>
@stop
