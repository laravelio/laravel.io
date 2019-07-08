@extends('layouts.base', ['disableAds' => $disableAds ?? true])

@section('body')
    <div class="flex items-center justify-center my-8 md:my-20">
        <div class="w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-4xl text-gray-700 text-center mb-2 font-bold">{{ $title }}</h1>
            <div class="p-8 md:border-2 md:rounded md:bg-gray-100">
                @include('layouts._alerts')

                <div class="flex">
                    @yield('small-content')
                </div>

                @yield('small-content-after')
            </div>
        </div>
    </div>
@endsection
