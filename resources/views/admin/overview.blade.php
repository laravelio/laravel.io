@title('Users')

@extends('layouts.default', ['isTailwindUi' => true])

@section('content')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">{{ $title }}</h1>
            
            <form action="{{ route('admin') }}" method="GET">
                <x-input type="text" name="search" id="search" placeholder="Search for users..." value="{{ $search ?? null }}" />
            </form>
        </div>
    </div>

    <main class="container mx-auto pb-10 lg:py-12 sm:px-4">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-2">
                @include('admin.partials._navigation')
            </aside>
        
            <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-10">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <x-tables.table-head>Name</x-tables.table-head>
                                            <x-tables.table-head>Role</x-tables.table-head>
                                            <x-tables.table-head>Joined On</x-tables.table-head>
                                            <x-tables.table-head>
                                                <span class="sr-only">Edit</span>
                                            </x-tables.table-head>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($users as $user)
                                            <tr>
                                                <x-tables.table-data>
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <x-avatar :user="$user" class="h-10 w-10 rounded-full" />
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $user->name() }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $user->emailAddress() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </x-tables.table-data>
                                                <x-tables.table-data>
                                                    @if ($user->isBanned())
                                                        Banned
                                                    @elseif ($user->isAdmin())
                                                        Admin
                                                    @elseif ($user->isModerator())
                                                        Moderator
                                                    @else
                                                        User
                                                    @endif
                                                </x-tables.table-data>
                                                <x-tables.table-data>
                                                    {{ $user->createdAt()->format('j M Y H:i:s') }}
                                                </x-tables.table-data>
                                                <x-tables.table-data style="text-align:center;">
                                                    <a href="{{ route('profile', $user->username()) }}" class="text-lio-600 hover:text-lio-800">
                                                        Settings
                                                    </a>
                                                </x-tables.table-data>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $users->render() }}
            </div>
        </div>
    </main>
@endsection
