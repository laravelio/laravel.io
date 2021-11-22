@title("{$user->username()} ({$user->name()})")
@canonical(route('profile', $user->username()))

@extends('layouts.default')

@section('content')
    <section class="bg-white">
        <div
            class="bg-gray-900 bg-contain h-60 w-full"
            style="background-image: url('{{ asset('images/profile-background.svg') }}')"
        ></div>

        <div class="container mx-auto">
            <div class="flex justify-center lg:justify-start">
                <x-avatar :user="$user" class="-mt-24 w-48 h-48 rounded-full border-8 border-white" unlinked />
            </div>

            <div class="flex flex-col mt-5 p-4 lg:flex-row lg:gap-x-12">
                <div class="w-full mb-10 lg:w-1/3 lg:mb-0">
                    <div>
                        <div class="flex items-center gap-x-4">
                            <h1 class="text-4xl font-bold">{{ $user->name() }}</h1>

                            @if ($user->isAdmin() || $user->isModerator())
                                <span class="border border-lio-500 text-lio-500 rounded px-3 py-1">
                                    {{ $user->isAdmin() ? 'Admin' : 'Moderator' }}
                                </span>
                            @endif
                        </div>

                        <span class="text-gray-600">
                            Joined {{ $user->createdAt()->format('j M Y') }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <span class="text-gray-900">
                            {{ $user->bio() }}
                        </span>
                    </div>

                    <div class="mt-4 mb-6 flex items-center gap-x-3">
                        @if ($user->githubUsername())
                            <a href="https://github.com/{{ $user->githubUsername() }}">
                                <x-icon-github class="w-6 h-6" />
                            </a>
                        @endif

                        @if ($user->hasTwitterAccount())
                            <a href="https://twitter.com/{{ $user->twitter() }}" class="text-twitter">
                                <x-icon-twitter class="w-6 h-6" />
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-col gap-y-4">
                        @if ($user->isLoggedInUser())
                            <x-buttons.secondary-button href="{{ route('settings.profile') }}" class="w-full">
                                <span class="flex items-center gap-x-2">
                                    <x-heroicon-o-pencil class="w-5 h-5" />
                                    Edit profile
                                </span>
                            </x-buttons.secondary-button>
                        @endif

                        @can(App\Policies\UserPolicy::BAN, $user)
                            @if ($user->isBanned())
                                <x-buttons.secondary-button class="w-full" @click.prevent="activeModal = 'unbanUser'">
                                    <span class="flex items-center gap-x-2">
                                        <x-heroicon-o-check class="w-5 h-5" />
                                        Unban User
                                    </span>
                                </x-buttons.secondary-button>
                            @else
                                <x-buttons.danger-button class="w-full" @click.prevent="activeModal = 'banUser'">
                                    <span class="flex items-center gap-x-2">
                                        <x-icon-hammer class="w-5 h-5" />
                                        Ban User
                                    </span>
                                </x-buttons.danger-button>
                            @endif
                        @endcan

                        @if (Auth::check() && Auth::user()->isAdmin())
                            @can(App\Policies\UserPolicy::DELETE, $user)
                                <x-buttons.danger-button class="w-full" @click.prevent="activeModal = 'deleteUser'">
                                    <span class="flex items-center gap-x-2">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                        Delete User
                                    </span>
                                </x-buttons.danger-button>
                            @endcan
                        @endif
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    <h2 class="text-3xl font-semibold">
                        Statistics
                    </h2>

                    <div class="mt-4 grid grid-cols-1 lg:grid-cols-2">
                        <div class="w-full flex justify-between px-5 py-2.5 bg-gray-100">
                            <span>Threads</span>
                            <span class="text-lio-500">
                                {{ number_format($user->countThreads()) }}
                            </span>
                        </div>

                        <div class="w-full flex justify-between px-5 py-2.5 bg-white lg:bg-gray-100">
                            <span>Replies</span>
                            <span class="text-lio-500">
                                {{ number_format($user->countReplies()) }}
                            </span>
                        </div>

                        <div class="w-full flex justify-between px-5 py-2.5 bg-gray-100 lg:bg-white">
                            <span>Solutions</span>
                            <span class="text-lio-500">
                                {{ number_format($user->countSolutions()) }}
                            </span>
                        </div>

                        <div class="w-full flex justify-between px-5 py-2.5">
                            <span>Articles</span>
                            <span class="text-lio-500">
                                {{ number_format($user->countArticles()) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($articles->count() > 0)
                <div class="mt-10 px-4 lg:mt-28">
                    <h2 class="text-3xl font-semibold">
                        Articles
                    </h2>

                    <div class="mt-8 flex flex-col gap-y-8 lg:flex-row lg:gap-x-8 lg:mb-16">
                        @foreach ($articles as $article)
                            <div class="w-full lg:w-1/3">
                                <x-articles.user-summary :article="$article" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-16 lg:mt-32" x-data="{ tab: 'threads' }">
            <div class="container mx-auto">
                <nav class="flex items-center justify-between lg:justify-start">
                    <button @click="tab = 'threads'" :class="{ 'text-lio-500 border-lio-500 border-b-2': tab === 'threads' }"  class="px-4 whitespace-nowrap py-5 font-medium text-lg text-gray-900 hover:text-lio-500 hover:border-lio-500 focus:outline-none focus:text-lio-500 focus:border-lio-500 lg:w-1/3">
                        Threads posted
                    </button>
                    <button @click="tab = 'replies'" :class="{ 'text-lio-500 border-lio-500 border-b-2': tab === 'replies' }"  class="px-4 whitespace-nowrap py-5 font-medium text-lg text-gray-900 hover:text-lio-500 hover:border-lio-500 focus:outline-none focus:text-lio-500 focus:border-lio-500 lg:w-1/3">
                        Replies posted
                    </button>
                </nav>
            </div>

            <div class="bg-gray-100 py-14 px-4">
                <div class="container mx-auto">
                    <div x-show="tab === 'threads'">
                        @include('users._latest_threads')
                    </div>

                    <div x-show="tab === 'replies'" x-cloak>
                        @include('users._latest_replies')
                    </div>
                </div>
            </div>
        </div>
    </section>

    @can(App\Policies\UserPolicy::BAN, $user)
        @if ($user->isBanned())
            <x-modal
                identifier="unbanUser"
                :action="route('admin.users.unban', $user->username())"
                title="Unban {{ $user->username() }}"
                type="update"
            >
                <p>Unbanning this user will allow them to login again and post content.</p>
            </x-modal>
        @else
            <x-modal
                identifier="banUser"
                :action="route('admin.users.ban', $user->username())"
                title="Ban {{ $user->username() }}"
                type="update"
            >
                <p>Banning this user will prevent them from logging in, posting threads and replying to threads.</p>
            </x-modal>
        @endif
    @endcan

    @can(App\Policies\UserPolicy::DELETE, $user)
        <x-modal
            identifier="deleteUser"
            :action="route('admin.users.delete', $user->username())"
            title="Delete {{ $user->username() }}"
        >
            <p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>
        </x-modal>
    @endcan
@endsection
