@php($subTitle = isset($activeTag) ? $activeTag->name() : null)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default', ['isTailwindUi' => true])

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">{{ $title }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-4 sm:py-10">
        <div class="container mx-auto sm:px-4 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="hidden lg:block lg:col-span-3 xl:col-span-2">
                <nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
                    @include('forum._tags')
                </nav>
            </div>
            <main class="lg:col-span-9 xl:col-span-6">
                <div class="px-4 sm:px-0">
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
            <aside class="hidden xl:block xl:col-span-4">
                <div class="sticky top-4 space-y-4">
                    @include('forum._community_heroes')
                </div>
            </aside>
        </div>
    </div>
@endsection
