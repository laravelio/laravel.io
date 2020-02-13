@title($user->name())

@extends('layouts.default')

@section('content')
    <div class="border-b">
        <div class="container mx-auto px-4 flex flex-col md:flex-row py-8">
            <div class="w-full md:w-1/5 mb-8">
                <div class="flex">
                    @include('users._user_info')
                </div>
            </div>

            <div class="w-full md:w-4/5 px-0 md:pl-8">
                <div class="flex flex-wrap">
                    @include('users._metrics')
                </div>

                <div x-data="{ tab: 'threads' }">
                    <nav class="mb-4 border-b border-gray-500 overflow-x-scroll">
                        <ul class="dashboard-nav text-gray-700">
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
                        <div x-show="tab === 'threads'">
                            @include('users._latest_threads')
                        </div>

                        <div x-show="tab === 'replies'">
                            @include('users._latest_replies')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
