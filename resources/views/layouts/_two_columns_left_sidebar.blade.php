@extends('layouts.default')

@section('table')
    <section class="sidebar">
        @yield('sidebar')
    </section>

    <section class="content">
        @yield('content')
    </section>
@stop
