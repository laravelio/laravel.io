@extends('layouts.base')

@section('body')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">{{ $title }}</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 pt-4 flex flex-wrap">
        <div class="w-full md:w-3/4 md:pr-3">
            @include('layouts._alerts')

            @yield('content')
        </div>
        
        <div class="w-full md:w-1/4 md:pl-3">
            <h3 class="text-xs font-bold tracking-wider uppercase text-gray-500 mb-4">Settings</h3>
            <ul class="tags">
                <li class="{{ active('settings.profile') }}">
                    <a href="{{ route('settings.profile') }}">Profile</a>
                </li>
                <li class="{{ active('settings.password') }}">
                    <a href="{{ route('settings.password') }}">Password</a>
                </li>   
            </ul>
        </div>
    </div>
@endsection
