@title('Community Articles')
@canonical($canonical)

@extends('layouts.default', ['isTailwindUi' => true])

@section('content')
    <div class="bg-white pt-5 lg:pt-2">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <x-articles.featured :articles="$pinnedArticles" />
        </div>
    </div>

    <div class="bg-lio-100">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-20 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 md:text-3xl">
                <span class="block">Got some knowledge to share?</span>
                <span class="block">
                    Share your article with <a href="https://twitter.com/laravelio" class="text-lio-500 hover:text-lio-600 hover:underline">our 45.000 Twitter followers</a>.
                </span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <x-buttons.primary-button href="{{ route('articles.create') }}" class="px-5 py-3 text-base font-medium">
                        Share Your Article
                    </x-buttons.primary-button>
                </div>
            </div>
        </div>
    </div>


    <div class="pt-5 pb-10 shadow-inner lg:pt-16 lg:pb-0">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <div class="lg:w-3/4">
                <livewire:show-articles>
            </div>

            <div class="lg:w-1/4">
                <div class="hidden lg:block">
                    @include('layouts._ads._forum_sidebar')
                </div>

                <div class="bg-white shadow rounded-md mt-6">
                    <h3 class="text-xl font-semibold px-5 pt-5">
                        Top authors
                    </h3>

                    <ul>
                        @foreach ($topAuthors as $author)
                            <li class="{{ ! $loop->last ? 'border-b ' : '' }}pb-3 pt-5">
                                <div class="flex justify-between items-center px-5">
                                    <div class="flex items-center gap-x-5">
                                        <x-avatar :user="$author" class="w-10 h-10" />

                                        <span class="flex flex-col">
                                            <a href="{{ route('profile', $author->username()) }}" class="hover:underline">
                                                <span class="text-gray-900 font-medium">
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

                                            <x-icon-trophy class="w-6 h-6" />
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6">
                    <x-moderators :moderators="$moderators" />
                </div>
            </div>
        </div>
    </div>
@endsection
