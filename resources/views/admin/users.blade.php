@title('Users')

@extends('layouts.default')

@section('content')
    <div class="container mx-auto px-4 pt-6">
        @include('admin.partials._navigation', [
            'query' => route('admin.users'),
            'search' => $adminSearch,
            'placeholder' => 'Search for users...',
        ])
    </div>

    <main class="container mx-auto pb-10 lg:py-6 sm:px-4">
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
                                    <x-tables.table-head class="text-center">Profile</x-tables.table-head>
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
                                                        <a href="{{ route('profile', $user->username()) }}">
                                                            {{ $user->name() }}
                                                        </a>
                                                    </div>

                                                    <div class="text-sm text-gray-500">
                                                        <a href="{{ route('profile', $user->username()) }}">
                                                            {{ $user->username() }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-tables.table-data>

                                        <x-tables.table-data>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                @if ($user->isBanned())
                                                    banned
                                                @elseif ($user->isAdmin())
                                                    admin
                                                @elseif ($user->isModerator())
                                                    moderator
                                                @else
                                                    user
                                                @endif
                                            </span>
                                        </x-tables.table-data>

                                        <x-tables.table-data>
                                            {{ $user->createdAt()->format('j M Y H:i:s') }}
                                        </x-tables.table-data>

                                        <x-tables.table-data class="text-center w-10">
                                            <a
                                                href="{{ route('profile', $user->username()) }}"
                                                class="text-lio-600 hover:text-lio-800"
                                            >
                                                <x-heroicon-o-user-circle class="w-5 h-5 inline" />
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

        <div class="p-4">
            {{ $users->render() }}
        </div>
    </main>
@endsection
