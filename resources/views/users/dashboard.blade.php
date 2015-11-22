@extends('layouts.default')

@section('content')
    <p>Welcome {{ Auth::user()->name }}!</p>
@stop
