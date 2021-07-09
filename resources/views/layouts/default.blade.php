@extends('layouts.base')

@section('body')
    <div class="bg-white">
        @yield('subnav')
        
        @include('layouts._alerts')

        @yield('content')
    </div>
@endsection
