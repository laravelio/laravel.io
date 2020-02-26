@title('Dashboard')

@extends('layouts.default')

@section('content')
    <div class="border-b">
        <div class="container mx-auto px-4 flex flex-col py-8">
            <div class="flex flex-wrap">
                @include('users._metrics', ['user' => Auth::user()])
            </div>

            <div class="w-full px-0" x-data="{ tab: 'notifications' }">
                <nav class="mb-4 border-b border-gray-500 overflow-x-scroll">
                    <ul class="dashboard-nav text-gray-700">
                        <li class="mr-8" :class="{ 'active': tab === 'notifications' }">
                            <button @click="tab = 'notifications'">
                                Notifications
                                @livewire('notification-count', 100, 'label')
                            </button>
                        </li>
                        <li class="mr-8" :class="{ 'active': tab === 'threads' }">
                            <button @click="tab = 'threads'">
                                Latest Threads
                            </button>
                        </li>
                        <li :class="{ 'active': tab === 'replies' }">
                            <button @click="tab = 'replies'">
                                Latest Replies
                            </button>
                        </li>
                    </ul>
                </nav>

                <div>
                    <div x-show="tab === 'notifications'">
                        @livewire('notifications')
                    </div>

                    <div x-show="tab === 'threads'">
                        @include('users._latest_threads', ['user' => Auth::user()])
                    </div>

                    <div x-show="tab === 'replies'">
                        @include('users._latest_replies', ['user' => Auth::user()])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
