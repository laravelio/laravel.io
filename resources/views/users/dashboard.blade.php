@title('Dashboard')

@extends('layouts.default')

@section('content')
    <div class="border-b mb-4">
        <div class="container mx-auto px-4 flex flex-col py-8">
            <div class="flex flex-wrap">
                @include('users._metrics', ['user' => Auth::user()])
            </div>

            <div x-data="{ tab: 'notifications' }">
                <div class="block mb-4">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex dashboard-nav">
                            <a href="#" @click="tab = 'notifications'" :class="{ 'active': tab === 'notifications' }" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                                Notifications

                                <livewire:notification-count/>
                            </a>
                            <a href="#" @click="tab = 'threads'" :class="{ 'active': tab === 'threads' }" class="whitespace-nowrap ml-8 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                                Latest Threads
                            </a>
                            <a href="#" @click="tab = 'replies'" :class="{ 'active': tab === 'replies' }" class="whitespace-nowrap ml-8 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                                Latest Replies
                            </a>
                        </nav>
                    </div>
                </div>

                <div>
                    <div x-show="tab === 'notifications'">
                        <livewire:notifications/>
                    </div>

                    <div x-show="tab === 'threads'" x-cloak>
                        @include('users._latest_threads', ['user' => Auth::user()])
                    </div>

                    <div x-show="tab === 'replies'" x-cloak>
                        @include('users._latest_replies', ['user' => Auth::user()])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
