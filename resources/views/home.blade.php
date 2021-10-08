@extends('layouts.base', ['bodyClass' => 'home', 'disableFooterAds' => true, 'isTailwindUi' => true])

@push('meta')
    <meta name="google-site-verification" content="LR29frqES-MZYtn3iZ6PtobclBfThr83rlNF4huiu0s" />
@endpush

@section('body')
    @include('layouts._alerts')

    <!-- Head section -->
    <section class="overflow-x-hidden mt-6 lg:mt-20">
        <div class="container mx-auto lg:px-16">
            <div class="flex flex-col items-center px-4 lg:flex-row lg:px-0">
                <div class="w-full mb-8 lg:w-1/2 lg:mb-0 lg:mr-16">
                    <h1 class="text-3xl font-bold text-gray-900 leading-tight mb-3 lg:text-6xl">
                        The Laravel Community Portal
                    </h1>

                    <div class="mb-5">
                        <p class="text-gray-800 text-lg leading-8 font-medium">
                            The Laravel portal for problem solving, knowledge sharing and community building.
                            Join <x-accent-text>{{ $totalUsers }}</x-accent-text> other artisans.
                        </p>
                    </div>

                    <div>
                        @if (Auth::guest())
                            <x-buttons.primary-cta href="{{ route('register') }}" class="w-full mb-3 lg:w-auto lg:mr-2">
                                Join the community
                            </x-buttons.primary-cta>

                            <x-buttons.secondary-cta href="{{ route('forum') }}" class="w-full lg:w-auto">
                                Visit the forum
                            </x-buttons.secondary-cta>
                        @else
                            <x-buttons.primary-cta href="{{ route('forum') }}" class="w-full mb-3 lg:w-auto lg:mr-2">
                                Start a Thread
                            </x-buttons.primary-cta>

                            <x-buttons.primary-cta href="{{ route('articles') }}" class="w-full mb-3 lg:w-auto lg:mr-2">
                                Share an Article
                            </x-buttons.primary-cta>
                        @endif
                    </div>
                </div>

                <div class="lg:w-1/2">
                    <x-community-members :members="$communityMembers" />
                </div>
            </div>
        </div>
    </section>
    <!-- /Head section -->

    <!-- Banner ad -->
    <section class="container mx-auto mt-10 lg:mt-40 lg:px-16">
        <div class="px-4 lg:px-10">
            @include('layouts._ads._footer')
        </div>
    </section>
    <!-- /Banner ad -->

    <!-- Search -->
    <section class="mt-10 lg:mt-16">
        <div class="bg-lio-500 text-white transform -skew-y-1">
            <div class="container mx-auto transform skew-y-1">
                <div class="flex flex-col items-center py-10 text-center lg:py-20">
                    <div class="w-full px-4 lg:w-1/2 lg:px-0">
                        <div class="mb-8">
                            <h2 class="text-3xl lg:text-4xl font-bold mb-3">
                                Looking for a solution?
                            </h2>
                            <p class="text-lg lg:text-xl opacity-80">
                                Search the forum for the answer to your question
                            </p>
                        </div>

                        <div class="mb-10">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-search class="w-4 h-4 text-gray-900" />
                                </div>

                                <form action="{{ route('forum') }}" method="GET">
                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Search here for threads"
                                        class="p-4 pl-10 text-gray-600 rounded w-full border-gray-100"
                                    />
                                </form>
                            </div>
                        </div>

                        <div class="text-lg">
                            <p>
                                Can't find what you're looking for?<br class="sm:hidden">
                                <a href="{{ route('threads.create') }}" class="border-b border-white pb-1">
                                    Create a new thread
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Search -->

    <!-- Help others -->
    <section class="mt-14 container mx-auto lg:mt-36 lg:px-16">
        <div class="px-4 lg:px-0">
            <div class="flex flex-col lg:flex-row items-center mb-4 lg:mb-12">
                <h2 class="w-full text-3xl font-bold text-gray-900 lg:w-1/2 lg:text-4xl">
                    Or you can help others
                </h2>
                <p class="w-full text-gray-800 text-lg lg:w-1/2">
                    By joining our platform, you can take a look at the latest unresolved threads
                </p>
            </div>

            <div class="flex gap-4 mb-4 -mx-4 p-4 overflow-x-scroll lg:mb-10 lg:gap-8">
                @foreach ($latestThreads as $thread)
                    <div class="flex-shrink-0 w-11/12 lg:w-1/3 lg:flex-shrink">
                        <x-threads.summary :thread="$thread" />
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center">
                <x-buttons.primary-cta href="{{ route('forum') }}" class="w-full lg:w-auto">
                    View all threads
                </x-buttons.primary-cta>
            </div>
        </div>
    </section>
    <!-- /Help others -->

    <!-- Laravel.io in numbers -->
    <section class="mt-12 container mx-auto px-4 lg:mt-40 lg:px-16">
        <h2 class="text-4xl leading-tight font-bold text-center text-gray-900 mb-6 lg:mb-12">
            Laravel.io in numbers
        </h2>

        <div class="flex flex-col lg:mb-10 lg:flex-row lg:gap-x-8">
            <div class="w-full">
                <x-number-block title="Users" :total="$totalUsers" :background="asset('images/users.png')" />
            </div>

            <div class="w-full">
                <x-number-block title="Threads" :total="$totalThreads" :background="asset('images/threads.png')" />
            </div>

            <div class="w-full">
                <x-number-block title="Replies" :total="$totalReplies" :background="asset('images/replies.png')" />
            </div>
        </div>
    </section>
    <!-- /Laravel.io in numbers -->

    <!-- Popular articles -->
    <section class="my-12 container mx-auto px-4 lg:my-40 lg:px-16">
        <div class="flex flex-col items-center mb-8 lg:flex-row lg:mb-16">
            <h2 class="w-full text-3xl font-bold text-gray-900 mb-2 lg:text-4xl lg:w-1/2 lg:mb-0">
                Popular articles
            </h2>
            <p class="w-full text-gray-800 text-lg lg:w-1/2">
                Have a look a the latest shared articles by our community members
            </p>
        </div>

        <x-articles.featured :articles="$latestArticles" />

        <div class="flex justify-center">
            <x-buttons.primary-cta href="{{ route('articles') }}" class="w-full lg:w-auto">
                View all articles
            </x-buttons.primary-cta>
        </div>
    </section>
    <!-- /Popular articles -->
@endsection
