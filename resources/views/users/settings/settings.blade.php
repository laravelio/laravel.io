@title('Settings')

@extends('layouts.base', ['isTailwindUi' => true])

@section('body')
    <div class="bg-gray-50">
        <div class="bg-white border-b">
            <div class="container mx-auto flex justify-between items-center px-4">
                <h1 class="text-xl py-4 text-gray-900">Settings</h1>
            </div>
        </div>

        @include('layouts._alerts')

        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                @include('users.partials._sidebar')

                <div class="sm:px-6 lg:px-0 lg:col-span-9">
                    @include('users.settings.profile')
                    @include('users.settings.password')
                    @include('users.settings.remove')
                </div>
            </div>
        </main>
    </div>
@endsection
