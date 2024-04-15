@php($subTitle = isset($activeTag) ? $activeTag->name() : null)
@title('Forum'.(isset($subTitle) ? ' > '.$subTitle : ''))
@canonical($canonical)

@extends('layouts.default', ['hasShadow' => true])

@section('content')
    <div class="pb-10 pt-5 lg:pb-0 lg:pt-10">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <div class="lg:w-3/4">
                <div class="flex items-center justify-between lg:block">
                    <div class="flex items-center justify-between">
                        <h1 class="text-4xl font-bold text-gray-900">Forum</h1>

                        <x-buttons.primary-button href="{{ route('threads.create') }}" class="hidden lg:block">
                            Create Thread
                        </x-buttons.primary-button>
                    </div>

                    <div class="flex items-center justify-between lg:mt-6">
                        <h3 class="text-xl font-semibold text-gray-800">{{ number_format($threads->total()) }} Threads</h3>

                        <div class="hidden gap-x-2 lg:flex">
                            <x-threads.filter :filter="$filter" />

                            <div class="shrink-0">
                                <x-buttons.secondary-button class="flex items-center gap-x-2" @click="activeModal = 'tag-filter'">
                                    <x-heroicon-o-funnel class="h-5 w-5" />
                                    Tag filter
                                </x-buttons.secondary-button>
                            </div>
                        </div>
                    </div>

                    @isset($activeTag)
                        <div class="mt-4 hidden items-center gap-x-4 border-t pt-5 lg:flex">
                            Filter applied
                            <x-tag>
                                <span class="flex items-center gap-x-1">
                                    {{ $activeTag->name() }}
                                    <a href="{{ route('forum') }}">
                                        <x-heroicon-o-x-mark class="h-5 w-5" />
                                    </a>
                                </span>
                            </x-tag>
                        </div>
                    @endisset
                </div>

                <div class="pt-2 lg:hidden">
                    @include('layouts._ads._forum_sidebar')

                    <div class="mt-6 flex justify-center">
                        <x-buttons.dark-cta>
                            <x-heroicon-s-rss class="mr-2 h-6 w-6" />
                            RSS Feed
                        </x-buttons.dark-cta>
                    </div>

                    <div class="mt-10 flex gap-x-4">
                        <div class="w-1/2">
                            <x-buttons.secondary-cta class="w-full" @click="activeModal = 'tag-filter'">
                                <span class="flex items-center gap-x-2">
                                    <x-heroicon-o-funnel class="h-5 w-5" />
                                    Tag filter
                                </span>
                            </x-buttons.secondary-cta>
                        </div>

                        <div class="w-1/2">
                            <x-buttons.primary-cta href="{{ route('threads.create') }}" class="w-full">Create Thread</x-buttons.primary-cta>
                        </div>
                    </div>

                    <div class="mt-4 flex">
                        <x-threads.filter :filter="$filter" />
                    </div>

                    @isset($activeTag)
                        <div class="mt-4 flex items-center gap-x-4">
                            Filter applied
                            <x-tag>
                                <span class="flex items-center gap-x-1">
                                    {{ $activeTag->name() }}
                                    <a href="{{ route('forum') }}">
                                        <x-heroicon-o-x-mark class="h-5 w-5" />
                                    </a>
                                </span>
                            </x-tag>
                        </div>
                    @endisset
                </div>

                <section class="mb-5 mt-8 lg:mb-32">
                    <div class="flex flex-col gap-y-4">
                        {{-- <x-ads.top-text /> --}}

                        @foreach ($threads as $thread)
                            <x-threads.overview-summary :thread="$thread" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $threads->appends(Request::only('filter'))->onEachSide(1)->links('pagination::tailwind') }}
                    </div>
                </section>
            </div>

            <div class="lg:w-1/4">
                <div class="hidden lg:block">
                    @include('layouts._ads._forum_sidebar')
                </div>

                <div class="mt-6 rounded-md bg-white shadow">
                    <h3 class="px-5 pt-5 text-xl font-semibold">Thanks to our community</h3>

                    <ul>
                        @foreach ($topMembers as $member)
                            <li class="{{ ! $loop->last ? 'border-b ' : '' }}pb-3 pt-5">
                                <div class="flex items-center justify-between px-5">
                                    <div class="flex items-center gap-x-5">
                                        <x-avatar :user="$member" class="h-10 w-10" />

                                        <span class="flex min-w-0 flex-1 flex-col">
                                            <a href="{{ route('profile', $member->username()) }}" class="truncate hover:underline">
                                                <span class="font-medium text-gray-900">
                                                    {{ $member->username() }}
                                                </span>
                                            </a>

                                            <span class="text-gray-700">
                                                {{ $member->solutions_count }} {{ Str::plural('Solution', $member->solutions_count) }}
                                            </span>
                                        </span>
                                    </div>

                                    <div>
                                        <span class="flex items-center gap-x-3 text-lio-500">
                                            <span class="text-xl font-medium">
                                                {{ $loop->iteration }}
                                            </span>

                                            <x-icon-trophy class="h-6 w-6" />
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <p class="px-5 pb-5 pt-3 text-center text-xs text-gray-700">Solutions given in the past year. Excluding solutions from thread authors.</p>
                </div>

                <div class="mt-6">
                    <x-moderators :moderators="$moderators" />
                </div>

                <div class="mt-6 hidden lg:block">
                    <x-buttons.dark-cta class="w-full" href="{{ url('/forum/feed') }}">
                        <x-heroicon-s-rss class="mr-2 h-6 w-6" />
                        RSS Feed
                    </x-buttons.dark-cta>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" x-show="activeModal === 'tag-filter'" x-cloak>
        <div class="h-full w-full p-8 lg:h-3/4 lg:w-96">
            <x-tag-filter :activeTag="$activeTag ?? null" :tags="$tags" :filter="$filter" />
        </div>
    </div>
@endsection
