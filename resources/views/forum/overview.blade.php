@php($subTitle = isset($activeTag) ? $activeTag->name() : null)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default', ['isTailwindUi' => true])

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">{{ $title }}</h1>

            <x-buttons.primary-button href="{{ route('threads.create') }}" tag="a">
                Create Thread
            </x-buttons.primary-button>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-4 sm:py-10">
        <div class="flex flex-col flex-col-reverse container mx-auto lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="hidden lg:block lg:col-span-2">
                <nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
                    @include('forum._tags')
                </nav>
            </div>

            <main class="lg:col-span-7 mt-6 lg:mt-0">
                <div class="px-4 lg:px-0">
                    <div class="sm:hidden" x-data="{}">
                        <label for="sort-by-tabs" class="sr-only">Select a tab</label>

                        <select 
                            id="sort-by-tabs" 
                            class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-lio-500 focus:ring-lio-500" 
                            @change="window.location = $event.target.value"
                        >
                            <option value="{{ url(request()->url() . '?filter=recent') }}" @if($filter === 'recent') selected="selected" @endif>Recent</option>
                            <option value="{{ url(request()->url() . '?filter=resolved') }}" @if($filter === 'resolved') selected="selected" @endif>Resolved</option>
                            <option value="{{ url(request()->url() . '?filter=active') }}" @if($filter === 'active') selected="selected" @endif>Active</option>
                        </select>
                    </div>

                    <div class="hidden sm:block">
                        <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">
                            <a 
                                href="{{ url(request()->url() . '?filter=recent') }}" 
                                aria-current="{{ $filter === 'recent' ? 'page' : 'false' }}" 
                                class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10"
                            >
                                <span>Recent</span>
                                <span 
                                    aria-hidden="true" 
                                    class="{{ $filter === 'recent' ? 'bg-lio-500' : 'bg-transparent'}} absolute inset-x-0 bottom-0 h-0.5"
                                ></span>
                            </a>

                            <a 
                                href="{{ url(request()->url() . '?filter=resolved') }}" 
                                aria-current="{{ $filter === 'resolved' ? 'page' : 'false' }}"
                                class="text-gray-500 hover:text-gray-700 group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10"
                            >
                                <span>Resolved</span>
                                <span 
                                    aria-hidden="true" 
                                    class="{{ $filter === 'resolved' ? 'bg-lio-500' : 'bg-transparent'}} absolute inset-x-0 bottom-0 h-0.5"
                                ></span>
                            </a>

                            <a 
                                href="{{ url(request()->url() . '?filter=active') }}"
                                aria-current="{{ $filter === 'active' ? 'page' : 'false' }}"
                                class="text-gray-500 hover:text-gray-700 rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10"
                            >
                                <span>Active</span>
                                <span 
                                    aria-hidden="true" 
                                    class="{{ $filter === 'active' ? 'bg-lio-500' : 'bg-transparent'}} absolute inset-x-0 bottom-0 h-0.5"
                                ></span>
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="mt-4">
                    <h1 class="sr-only">Recent questions</h1>

                    <ul class="space-y-4">
                        @foreach ($threads as $thread)
                            @include('forum._thread')
                        @endforeach
                    </ul>
                </div>
            </main>

            <aside class="lg:col-span-3">
                <div class="sticky top-4 space-y-4">
                    @include('layouts._ads._forum_sidebar')

                    <div class="mt-8 lg:mt-0 hidden lg:block">
                        @include('forum._community_heroes')
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route("feeds.forum") }}" class="inline-flex lg:flex items-center inline-block text-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-lio-600 hover:bg-lio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lio-500">
                            <x-icon-rss class="-ml-1 mr-3 h-5 w-5"/>
                            RSS Feed
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
