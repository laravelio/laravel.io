@title('Users')

@extends('layouts.default')

@section('content')
    <div class="container mx-auto px-4 pt-6">
        <div class="border-b border-gray-200 pb-4">
            <div class="sm:flex sm:items-center sm:justify-between sm:items-baseline">
                <div class="sm:flex sm:items-center sm:justify-between sm:items-baseline">
                    <h1 class="flex items-center gap-x-4 text-4xl font-bold text-gray-900">
                        Notifications
                        <livewire:notification-count/>
                    </h1>
                </div>
            </div>
        </div>

        <div class="my-4">
            <livewire:notifications />
        </div>
    </div>
@endsection