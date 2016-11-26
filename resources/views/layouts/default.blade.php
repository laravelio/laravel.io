@extends('layouts.base')

@section('body')
    <div class="container">
        @include('layouts._alerts')

        @yield('content')
    </div>
@endsection
