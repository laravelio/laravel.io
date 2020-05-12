<nav x-data="{ open: false }" class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex px-2 lg:px-0">
                <div class="flex-shrink-0 flex items-center">
                    <a class="my-4" href="{{ route('home') }}">
                        <img class="block lg:hidden h-8 w-auto" src="{{ asset('images/laravelio-icon.svg') }}" alt="" />
                        <img class="hidden lg:block h-8 w-auto" src="{{ asset('images/laravelio-logo.svg') }}" alt="" />
                    </a>
                </div>
                <div class="hidden lg:ml-6 lg:flex">
                    <a href="{{ route('forum') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out {{ active(['forum', 'threads*', 'thread']) }}">
                        Forum
                    </a>
                    <a href="{{ route('articles') }}" class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out {{ active(['articles', 'articles*']) }}">
                        Articles
                    </a>
                    <a href="https://paste.laravel.io" class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Pastebin
                    </a>
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <div class="ml-8 h-full flex items-center px-1 pt-1 border-b-2 border-transparent">
                            <button @click="open = !open" class="flex text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Chat

                                <svg viewBox="0 0 20 20" class="w-5 h-5 text-gray-500" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50" x-cloak>
                            <div class="py-1 rounded-md bg-white shadow-xs">
                                <a href="https://discord.gg/KxwQuKb" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Discord</a>
                                <a href="https://larachat.co" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Larachat</a>
                                <a href="https://webchat.freenode.net/?nick=laravelnewbie&channels=%23laravel&prompt=1" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">IRC</a>
                            </div>
                        </div>
                    </div>
                    <a href="https://laravelevents.com" class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Events
                    </a>
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <div class="ml-8 h-full flex items-center px-1 pt-1 border-b-2 border-transparent">
                            <button @click="open = !open" class="flex text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Community

                                <svg viewBox="0 0 20 20" class="w-5 h-5 text-gray-500" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50" x-cloak>
                            <div class="py-1 rounded-md bg-white shadow-xs">
                                <a href="https://github.com/laravelio" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Github</a>
                                <a href="https://larachat.co" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Twitter</a>
                                <div class="border-t border-gray-100"></div>
                                <a href="https://laravel.com" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Laravel</a>
                                <a href="https://laracasts.com" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Laracasts</a>
                                <a href="https://laravel-news.com" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Laravel News</a>
                                <a href="https://www.laravelpodcast.com" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Podcast</a>
                                <a href="https://ecosystem.laravel.io" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Ecosystem</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
                @include('_partials._search')
            </div>
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:ml-4 lg:flex lg:items-center">
                @if (Auth::guest())
                    <a href="{{ route('login') }}" class="{{ active('login') }} inline-flex lg:h-full items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="{{ active('register') }} ml-8 inline-flex lg:h-full items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                        Register
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="flex-shrink-0 border-2 border-transparent text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition duration-150 ease-in-out">
                        <span class="block relative">
                            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>

                            <livewire:notification-indicator/>
                        </span>
                    </a>

                    <div @click.away="open = false" class="ml-4 relative flex-shrink-0" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->gravatarUrl(256) }}" alt="{{ Auth::user()->name() }}" />
                            </button>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50" x-cloak>
                            <div class="py-1 rounded-md bg-white shadow-xs">
                                <a href="{{ route('profile', Auth::user()->username()) }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Your Profile
                                </a>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Dashboard
                                </a>
                                <a href="{{ route('user.articles') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Articles
                                </a>
                                <a href="{{ route('settings.profile') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Settings
                                </a>

                                @can(App\Policies\UserPolicy::ADMIN, App\User::class)
                                    <div class="border-t border-gray-100"></div>
                                    <a href="{{ route('admin') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Admin
                                    </a>
                                @endcan

                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Sign out
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3">
            <a href="{{ route('forum') }}" class="{{ active(['forum', 'threads*', 'thread']) }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium bg-indigo-50 focus:outline-none transition duration-150 ease-in-out">
                Forum
            </a>
            <a href="{{ route('articles') }}" class="{{ active(['articles', 'articles*']) }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium bg-indigo-50 focus:outline-none transition duration-150 ease-in-out">
                Articles
            </a>
            <a href="https://paste.laravel.io" class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Pastebin</a>

            <div class="mt-1">
                <div class="pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 transition duration-150 ease-in-out">
                    Chat
                </div>

                <div>
                    <a href="https://discord.gg/KxwQuKb" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Discord</a>
                    <a href="https://larachat.co" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Larachat</a>
                    <a href="https://webchat.freenode.net/?nick=laravelnewbie&channels=%23laravel&prompt=1" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">IRC</a>
                </div>
            </div>

            <a href="https://laravelevents.com" class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Events</a>

            <div class="mt-1">
                <div class="pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 transition duration-150 ease-in-out">
                    Community
                </div>

                <div>
                    <a href="https://github.com/laravelio" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Github</a>
                    <a href="https://larachat.co" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Twitter</a>
                    <a href="https://laravel.com" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Laravel</a>
                    <a href="https://laracasts.com" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Laracasts</a>
                    <a href="https://laravel-news.com" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Laravel News</a>
                    <a href="https://www.laravelpodcast.com" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Podcast</a>
                    <a href="https://ecosystem.laravel.io" class="pl-6 block pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Ecosystem</a>
                </div>
            </div>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            @if (Auth::guest())
                <div class="mt-3">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Register
                    </a>
                </div>
            @else
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->gravatarUrl(256) }}" alt="{{ Auth::user()->name() }}" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-6 text-gray-800">{{ Auth::user()->name() }}</div>
                        <div class="text-sm font-medium leading-5 text-gray-500">{{ '@'.Auth::user()->username() }}</div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('profile', Auth::user()->username()) }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Your Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Dashboard
                    </a>
                    <a href="{{ route('user.articles') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Articles
                    </a>
                    <a href="{{ route('settings.profile') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Settings
                    </a>

                    @can(App\Policies\UserPolicy::ADMIN, App\User::class)
                        <a href="{{ route('admin') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                            Admin
                        </a>
                    @endcan

                    <a href="{{ route('logout') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        Sign out
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>
