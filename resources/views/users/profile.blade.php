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
                    <div class="block mb-4">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex dashboard-nav">
                                <a href="#" @click="tab = 'threads'" :class="{ 'active': tab === 'threads' }"  class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                                    Latest Threads
                                </a>
                                <a href="#" @click="tab = 'replies'" :class="{ 'active': tab === 'replies' }"  class="whitespace-nowrap ml-8 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                                    Latest Replies
                                </a>
                            </nav>
                        </div>
                    </div>

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
