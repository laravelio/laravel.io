@extends('layouts.base', ['bodyClass' => 'home'])

@section('body')
    <div class="container">
        @include('layouts._alerts')
    </div>

    <div class="section section-one">
        <div class="container mx-auto flex flex-col items-center py-20 px-4">
            <img src="{{ asset('images/laravelio.png') }}" title="Laravel.io" alt="Laravel.io logo" class="w-full md:w-2/5 mb-8">
            <h2 class="text-2xl text-gray-700 mb-8 text-center md:text-left">The Laravel Community Portal</h2>
            <div class="flex flex-wrap justify-center md:justify-start">
                @if (Auth::guest())
                    <a class="button button-big md:mr-4 mb-4" href="{{ route('register') }}">
                        Join the Community
                    </a>
                    <a class="button button-big button-muted mb-4" href="{{ route('forum') }}">
                        Visit the Forum
                    </a>
                @else
                    <a class="button" href="{{ route('threads.create') }}">
                        Start a Thread
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="section section-two">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl text-gray-800 mb-12 text-center">Laravel.io in numbers</h2>
            <div class="flex flex-wrap w-full md:w-2/3 mx-auto justify-center">
                <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                    <div class="flex flex-col items-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-user-group"><path class="primary" d="M12 13a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v3a1 1 0 0 1-1 1h-8a1 1 0 0 1-1-1 1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-3a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3zM7 9a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm10 0a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/><path class="secondary" d="M12 13a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm-3 1h6a3 3 0 0 1 3 3v3a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-3a3 3 0 0 1 3-3z"/></svg>
                        <div class="text-gray-800 uppercase mt-4">
                            <span class="text-2xl block">{{ $totalUsers }}</span>
                            <span class="text-gray-600">users</span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                    <div class="flex flex-col items-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-document-notes"><path class="primary" d="M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm2 11a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2H8zm0 4a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2H8z"/><polygon class="secondary" points="14 2 20 8 14 8"/></svg>
                        <div class="text-gray-800 uppercase mt-4">
                            <span class="text-2xl block">{{ $totalThreads }}</span>
                            <span class="text-gray-600">threads</span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 h-48 flex justify-center">
                    <div class="flex flex-col items-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-history"><path class="primary" d="M6.55 6.14l1.16 1.15A1 1 0 0 1 7 9H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1.7-.7l1.44 1.42A10 10 0 1 1 2 12a1 1 0 0 1 2 0 8 8 0 1 0 2.55-5.86z"/><path class="secondary" d="M15.7 14.3a1 1 0 0 1-1.4 1.4l-3-3a1 1 0 0 1-.3-.7V7a1 1 0 0 1 2 0v4.59l2.7 2.7z"/></svg>
                        <div class="text-gray-800 uppercase mt-4">
                            <span class="text-2xl block">{{ $resolutionTime }} days</span>
                            <span class="text-gray-600">average resolution</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-three">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl text-center">Need help?</h2>
            <div class="text-xl text-center mb-8 text-gray-700">
                Search for the solution
            </div>
            <div class="w-full md:w-1/2 mx-auto relative mb-8">
                {{ Form::open(['route' => 'forum', 'method' => 'GET']) }}
                    <input type="search" class="rounded-full border-2 w-full p-3 text-xl bg-gray-100" placeholder="Search for threads..." name="search">
                    <button type="submit" class="absolute top-0 right-0 w-10 h-10 my-2 mx-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-search w-full"><circle cx="10" cy="10" r="7" class="primary"/><path class="secondary" d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>
                    </button>
                {{ Form::close() }}
            </div>
            <div class="flex flex-col items-center">
                <div class="text-lg text-center mb-8 text-gray-700">
                    Can't find what you're looking for?
                    <a href="#" class="text-green-darker">
                        Create a new thread
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-four">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl text-center text-gray-800">You can help others</h2>
            <div class="text-xl text-center mb-8 text-gray-800">
                Take a look at the latest unresolved threads
            </div>
            <div class="flex flex-wrap mb-8">
                @foreach($latestThreads as $latestThread)
                    <div class="flex w-full md:w-1/3">
                        <div class="flex flex-col flex-grow justify-between bg-white p-4 border rounded m-2">
                            <a href="{{ route('thread', $latestThread->slug()) }}">
                                <h3 class="text-2xl text-gray-800 mb-8">
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
                <a href="{{ route('forum') }}" class="button button-big">
                    See all threads
                </a>
            </div>
        </div>
    </div>

    <div class="section section-five">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-4xl pb-8 mb-8 text-center">More from the community</h2>
            <div class="flex flex-wrap text-center justify-center items-center md:mb-20 w-full lg:w-1/2 mx-auto">
                <div class="w-1/2 md:w-1/3 mb-4">
                    <a href="https://github.com/laravelio">
                        <img src="{{ asset('images/octocat.png') }}" alt="Github logo" title="Github" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Github</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/3 mb-4">
                    <a href="https://twitter.com/laravelio">
                        <img src="{{ asset('images/twitter.png') }}" alt="Twitter logo" title="Twitter" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Twitter</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/3 mb-4">
                    <a href="https://medium.com/laravelio">
                        <img src="{{ asset('images/medium.png') }}" alt="Medium logo" title="Medium" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Medium</span>
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap text-center items-center w-full lg:w-2/3 mx-auto">
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://laravel.com">
                        <img src="{{ asset('images/laravel.png') }}" alt="Laravel logo" title="Laravel" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Laravel</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://laracasts.com">
                        <img src="{{ asset('images/laracasts.png') }}" alt="Laracasts logo" title="Laracasts" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Laracasts</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://laravel-news.com">
                        <img src="{{ asset('images/laravel-news.png') }}" alt="Laravel News logo" title="Laravel News" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Laravel News</span>
                    </a>
                </div>
                <div class="w-1/2 md:w-1/4 mb-4">
                    <a href="https://www.laravelpodcast.com">
                        <img src="{{ asset('images/podcast.jpg') }}" alt="Laravel Podcast logo" title="Laravel Podcast" class="w-24 mx-auto mb-4">
                        <span class="text-xl">Laravel Podcast</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
