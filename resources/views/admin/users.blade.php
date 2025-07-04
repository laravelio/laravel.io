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
                    <div class="shadow-sm overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                                                <div class="shrink-0 h-10 w-10">
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

                                        <x-tables.table-data class="text-center w-18">
                                            <a href="{{ route('profile', $user->username()) }}" class="text-lio-600 hover:text-lio-800">
                                                <x-heroicon-o-user-circle class="w-5 h-5 inline" />
                                            </a>

                                            @can(App\Policies\UserPolicy::DELETE, $user)
                                                <button @click="activeModal = 'deleteUser{{ $user->getKey() }}'" class="text-red-600 hover:text-red-800">
                                                    <x-heroicon-o-trash class="w-5 h-5 inline" />
                                                </button>

                                                <x-modal identifier="deleteUser{{ $user->getKey() }}" :action="route('admin.users.delete', $user->username())" title="Delete {{ $user->username() }}">
                                                    <p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>
                                                </x-modal>

                                                <button title="Delete {{ $user->name() }} threads." @click="activeModal = 'deleteUserThreads{{ $user->getKey() }}'" class="text-red-600 hover:text-red-800">
                                                    <x-heroicon-o-archive-box-x-mark class="w-5 h-5 inline" />
                                                </button>

                                                <x-modal identifier="deleteUserThreads{{ $user->getKey() }}" :action="route('admin.users.threads.delete', $user->username())" title="Delete {{ $user->username() }} threads">
                                                    <p>All the threads from this user will be deleted. This cannot be undone.</p>
                                                </x-modal>
                                            @endcan

                                            {{-- Toggle Verified Author --}}
                                            @can(App\Policies\UserPolicy::ADMIN, $user)
                                                @if ($user->isVerifiedAuthor())
                                                    <button title="Unverify {{ $user->name() }} as author"
                                                        @click="activeModal = 'unverifyAuthor{{ $user->getKey() }}'"
                                                        class="text-yellow-600 hover:text-yellow-800">
                                                        <x-heroicon-o-x-circle class="w-5 h-5 inline" />
                                                    </button>
                                                    <x-modal type="update" identifier="unverifyAuthor{{ $user->getKey() }}"
                                                        :action="route(
                                                            'admin.users.unverify-author',
                                                            $user->username(),
                                                        )" title="Unverify {{ $user->username() }} as Author">
                                                        <p>This will remove the verified author status from this user.</p>
                                                    </x-modal>
                                                @else
                                                    <button title="Verify {{ $user->name() }} as author"
                                                        @click="activeModal = 'verifyAuthor{{ $user->getKey() }}'"
                                                        class="text-green-600 hover:text-green-800">
                                                        <x-heroicon-o-check-circle class="w-5 h-5 inline" />
                                                    </button>
                                                    <x-modal type="update" identifier="verifyAuthor{{ $user->getKey() }}"
                                                        :action="route(
                                                            'admin.users.verify-author',
                                                            $user->username(),
                                                        )" title="Verify {{ $user->username() }} as Author">
                                                        <p>This will mark this user as a verified author.</p>
                                                    </x-modal>
                                                @endif
                                            @endcan
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
