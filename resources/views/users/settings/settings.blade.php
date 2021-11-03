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

        <main class="max-w-4xl mx-auto pt-10 pb-12 px-4 lg:pb-16">
            <div class="lg:grid lg:gap-x-5">
                <div class="sm:px-6 lg:px-0 lg:col-span-9">
                    @include('users.settings.profile')
                    @include('users.settings.password')
                    @include('users.settings.remove')
                </div>
            </div>
        </main>
    </div>
@endsection
