@extends('layouts.base')

@section('body')
    <div
        class="flex min-h-full flex-col justify-center bg-gray-100 py-12 sm:px-6 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $title }}
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white px-4 py-8 shadow sm:rounded-lg sm:px-10">
                @include('layouts._alerts')

                @yield('small-content')
            </div>
        </div>
    </div>
@endsection
