@extends('layouts.base')

@section('body')
    <div>
        @yield('subnav')
        
        @include('layouts._alerts')

        @yield('content')
    </div>
@endsection
