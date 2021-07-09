@extends('layouts.base')

@section('body')
    <div class="bg-gray-100">
        @yield('subnav')
        
        @include('layouts._alerts')

        @yield('content')
    </div>
@endsection
