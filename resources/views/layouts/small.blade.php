@extends('layouts.base')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                @include('layouts._alerts')

                <div class="panel panel-default">
                    <div class="panel-heading">{{ $title }}</div>
                    <div class="panel-body">
                        @yield('small-content')
                    </div>
                </div>

                @yield('small-content-after')
            </div>
        </div>
    </div>
@endsection
