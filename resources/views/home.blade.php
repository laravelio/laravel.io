@extends('layouts.base', ['bodyClass' => 'home', 'disableFooterAds' => true])

@section('body')
    @include('layouts._alerts')

    <div class="bg-white overflow-hidden">
        <div x-data="{ open: false }" class="pt-6 pb-12 sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
            <div class="mt-10 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 xl:mt-28">
                <div class="text-center">
                    <img src="{{ asset('images/laravelio.png') }}" title="Laravel.io" alt="Laravel.io" class="block md:max-w-2xl mx-auto mb-10">

                    <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:leading-none">
                        The Laravel Community Portal
                    </h2>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-2xl">
                        The Laravel portal for problem solving, knowledge sharing and community building. <strong>Join {{ $totalUsers }} other artisans.</strong>
                    </p>
                    <div class="mt-5 max-w-lg mx-auto sm:flex sm:justify-center md:mt-8">
                        @if (Auth::guest())
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-dark hover:bg-green-primary focus:outline-none focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Join the Community
                                </a>
                            </div>
                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                <a href="{{ route('forum') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-green-primary bg-white hover:text-green-dark focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Visit the Forum
                                </a>
                            </div>
                        @else
                            <div class="rounded-md shadow">
                                <a href="{{ route('threads.create') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-dark hover:bg-green-primary focus:outline-none focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Start a Thread
                                </a>
                            </div>
                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                <a href="{{ route('articles.create') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-dark hover:bg-green-primary focus:outline-none focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Share an Article
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-b">
        @include('layouts._ads._footer')
    </div>

    <div class="border-b bg-gray-100">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl text-gray-800 mb-12 text-center">Laravel.io in numbers</h2>
            <div class="flex flex-wrap w-full md:w-2/3 mx-auto justify-center">
                <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                    <div class="flex flex-col items-center text-center">
                        <x-heroicon-s-user-group class="text-green-primary w-32"/>

                        <div class="text-gray-800 uppercase mt-4">
                            <span class="text-2xl block">{{ $totalUsers }}</span>
                            <span class="text-gray-600">users</span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                    <div class="flex flex-col items-center text-center">
                        <x-heroicon-o-document-report class="text-green-primary w-32"/>
                        <div class="text-gray-800 uppercase mt-4">
                            <span class="text-2xl block">{{ $totalThreads }}</span>
                            <span class="text-gray-600">threads</span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 h-48 flex justify-center">
                    <div class="flex flex-col items-center text-center">
                        <x-heroicon-o-clock class="text-green-primary w-32"/>
                        <div class="text-gray-800 uppercase mt-4">
                            <span class="text-2xl block">{{ $resolutionTime }} days</span>
                            <span class="text-gray-600">average resolution</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-b bg-white text-gray-700">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl text-center">Need help?</h2>
            <div class="text-xl text-center mb-8 text-gray-700">
                Search for the solution
            </div>
            <div class="w-full md:w-1/2 mx-auto relative mb-8">
                <form action="{{ route('forum') }}" method="GET">
                    <input type="search" class="rounded-full border-2 w-full p-3 text-xl bg-gray-100" placeholder="Search for threads..." name="search">
                    <button type="submit" class="absolute top-0 right-0 w-10 h-10 my-2 mx-3">
                        <x-heroicon-o-search class="w-full"/>
                    </button>
                </form>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-lg text-center mb-8 text-gray-700">
                    Can't find what you're looking for?
                    <a href="{{ route('threads.create') }}" class="text-green-darker">
                        Create a new thread
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="border-b">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl text-center text-gray-800">You can help others</h2>
            <div class="text-xl text-center mb-8 text-gray-800">
                Take a look at the latest unresolved threads
            </div>
            <div class="flex flex-wrap mb-8">
                @foreach ($latestThreads as $latestThread)
                    <div class="flex w-full md:w-1/3">
                        <div class="flex flex-col flex-grow justify-between bg-white p-4 border rounded m-2">
                            <a href="{{ route('thread', $latestThread->slug()) }}">
                                <h3 class="text-2xl text-gray-800 mb-8 break-all">
                                    {{ $latestThread->subject() }}
                                </h3>
                            </a>
                            <div class="flex mb-4 md:mb-0">
                                @include('forum.threads.info.avatar', ['user' => $latestThread->author()])

                                <div class="mr-6 text-gray-700">
                                    <a href="{{ route('profile', $latestThread->author()->username()) }}" class="text-green-darker mr-2">{{ $latestThread->author()->name() }}</a> posted
                                    {{ $latestThread->createdAt()->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center">
                <a href="{{ route('forum') }}" class="button button-primary button-big">
                    See all threads
                </a>
            </div>
        </div>
    </div>

    <div class="border-b bg-gray-100 text-gray-700">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl pb-8 mb-8 text-center">More from the community</h2>
            <div class="flex flex-wrap text-center justify-center items-center md:mb-20 w-full lg:w-1/2 mx-auto">
                <div class="w-1/2 md:w-1/3 mb-4">
                    <a href="https://github.com/laravelio">
                        <img src="{{ asset('images/octocat.png') }}" alt="Github logo" title="Github" class="w-16 mx-auto mb-4">
                        <span class="text-xl">Github</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/3 mb-4">
                    <a href="https://twitter.com/laravelio">
                        <img src="{{ asset('images/twitter.png') }}" alt="Twitter logo" title="Twitter" class="w-16 mx-auto mb-4">
                        <span class="text-xl">Twitter</span>
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap text-center items-center w-full lg:w-2/3 mx-auto">
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://laravel.com">
                        <img src="{{ asset('images/laravel.png') }}" alt="Laravel logo" title="Laravel" class="w-16 mx-auto mb-4">
                        <span class="text-xl">Laravel</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://laracasts.com">
                        <img src="{{ asset('images/laracasts.png') }}" alt="Laracasts logo" title="Laracasts" class="w-16 mx-auto mb-4">
                        <span class="text-xl">Laracasts</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://laravel-news.com">
                        <img src="{{ asset('images/laravel-news.png') }}" alt="Laravel News logo" title="Laravel News" class="w-16 mx-auto mb-4">
                        <span class="text-xl">Laravel News</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://www.laravelpodcast.com">
                        <img src="{{ asset('images/podcast.jpg') }}" alt="Laravel Podcast logo" title="Laravel Podcast" class="w-16 mx-auto mb-4">
                        <span class="text-xl">Laravel Podcast</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
