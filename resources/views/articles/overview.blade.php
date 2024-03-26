@title('Community Articles')
@canonical($canonical)

@extends('layouts.default')

@section('content')
    <div class="bg-white pt-5 lg:pt-2">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <x-articles.featured :articles="$pinnedArticles" />
        </div>
    </div>

    <div class="bg-lio-100">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:flex lg:items-center lg:justify-between lg:px-8 lg:py-20">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 md:text-3xl">
                <span class="block">Got some knowledge to share?</span>
                <span class="block">
                    Share your article with
                    <a href="https://twitter.com/laravelio" class="text-lio-500 hover:text-lio-600 hover:underline">our 50,000+ Twitter followers</a>
                    .
                </span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <x-buttons.primary-button href="{{ route('articles.create') }}" class="px-5 py-3 text-base font-medium">
                        Share Your Article
                    </x-buttons.primary-button>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-10 pt-5 shadow-inner lg:pb-0 lg:pt-16" id="articles">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <div class="lg:w-3/4">
                <div class="flex items-center justify-between lg:block">
                    <div class="flex items-center justify-between">
                        <h1 class="text-4xl font-bold text-gray-900">Articles</h1>
                    </div>

                    <div class="flex items-center justify-between lg:mt-6">
                        <h3 class="text-xl font-semibold text-gray-800">{{ number_format($articles->total()) }} Articles</h3>

                        <div class="hidden gap-x-2 lg:flex">
                            <x-articles.filter :selectedFilter="$filter" :activeTag="$activeTag" />

                            <div class="shrink-0">
                                <x-buttons.secondary-button class="flex items-center gap-x-2" @click="activeModal = 'tag-filter'">
                                    <x-heroicon-o-funnel class="h-5 w-5" />
                                    Tag filter
                                </x-buttons.secondary-button>
                            </div>
                        </div>
                    </div>

                    @if ($activeTag)
                        <div class="mt-4 hidden items-center gap-x-4 border-t pt-5 lg:flex">
                            Filter applied
                            <x-tag>
                                <span class="flex items-center gap-x-1">
                                    {{ $activeTag->name() }}
                                    <a href="{{ route('articles', ['filter' => $filter]) }}" type="button">
                                        <x-heroicon-o-x-mark class="h-5 w-5" />
                                    </a>
                                </span>
                            </x-tag>
                        </div>
                    @endif
                </div>

                <div class="pt-2 lg:hidden">
                    @include('layouts._ads._forum_sidebar')

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
                            <x-buttons.primary-cta href="{{ route('articles.create') }}" class="w-full">Create Article</x-buttons.primary-cta>
                        </div>
                    </div>

                    <div class="mt-4 flex">
                        <x-articles.filter :selectedFilter="$filter" :activeTag="$activeTag" />
                    </div>

                    @if ($activeTag)
                        <div class="mt-4 flex items-center gap-x-4">
                            Filter applied
                            <x-tag>
                                <span class="flex items-center gap-x-1">
                                    {{ $activeTag->name() }}
                                    <button type="button">
                                        <x-heroicon-o-x-mark class="h-5 w-5" />
                                    </button>
                                </span>
                            </x-tag>
                        </div>
                    @endif
                </div>

                <section class="mb-5 mt-8 lg:mb-16">
                    <div class="flex flex-col gap-y-4">
                        @foreach ($articles as $article)
                            <x-articles.overview-summary :article="$article" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $articles->appends(Request::only('filter', 'tag'))->onEachSide(1)->links('pagination::tailwind') }}
                    </div>
                </section>

                <div class="modal" x-show="activeModal === 'tag-filter'" x-cloak>
                    <div class="h-full w-full p-8 lg:h-3/4 lg:w-96">
                        <x-tag-filter
                            :activeTag="$activeTag ?? null"
                            :tags="$tags"
                            :filter="$filter"
                            route="articles"
                            cancelRoute="articles"
                            jumpTo="articles"
                        />
                    </div>
                </div>
            </div>

            <div class="lg:w-1/4">
                <div class="hidden lg:block">
                    @include('layouts._ads._forum_sidebar')
                </div>

                <div class="mt-6 rounded-md bg-white shadow">
                    <h3 class="px-5 pt-5 text-xl font-semibold">Top authors</h3>

                    <ul>
                        @foreach ($topAuthors as $author)
                            <li class="{{ ! $loop->last ? 'border-b ' : '' }}pb-3 pt-5">
                                <div class="flex items-center justify-between px-5">
                                    <div class="flex items-center gap-x-5">
                                        <x-avatar :user="$author" class="h-10 w-10" />

                                        <span class="flex min-w-0 flex-1 flex-col">
                                            <a href="{{ route('profile', $author->username()) }}" class="truncate hover:underline">
                                                <span class="font-medium text-gray-900">
                                                    {{ $author->username() }}
                                                </span>
                                            </a>

                                            <span class="text-gray-700">
                                                {{ $author->articles_count }} {{ Str::plural('Article', $author->articles_count) }}
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
                </div>

                <div class="mt-6 hidden lg:block">
                    <x-buttons.dark-cta class="w-full" href="{{ url('/articles/feed') }}">
                        <x-heroicon-s-rss class="mr-2 h-6 w-6" />
                        RSS Feed
                    </x-buttons.dark-cta>
                </div>
            </div>
        </div>
    </div>
@endsection
