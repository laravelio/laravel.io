@extends('layouts.base')

@section('body')
    <div>
        @include('layouts._alerts')

        @yield('content')
    </div>
@endsection
