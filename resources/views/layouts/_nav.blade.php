<nav class="{{ isset($hasShadow) ? 'shadow mb-1' : '' }}">
    <div class="container mx-auto text-gray-800 lg:block lg:py-8" x-data="{ nav: false, search: false, community: false, chat: false, settings: false }" @click.outside="nav = false">
        <div class="block bg-white 2xl:-mx-10">
            <div class="lg:px-4 lg:flex">
                <div class="block lg:flex lg:items-center lg:flex-shrink-0">
                    <div class="flex justify-between items-center p-4 lg:p-0">
                        <a href="{{ route('home') }}" class="mr-4">
                            <img class="h-6 w-auto lg:h-8" src="{{ asset('images/laravelio-logo.svg') }}" alt="" />
                        </a>

                        <div class="flex lg:hidden">
                            <button @click="search = !search" :class="{ 'text-lio-500': search }">
                                <x-heroicon-o-search class="w-6 h-6 mr-4" />
                            </button>

                            <button @click="nav = !nav">
                                <x-heroicon-o-menu-alt-1 x-show="!nav" class="w-6 h-6" />
                            </button>

                            <button @click="nav = !nav" x-cloak>
                                <x-heroicon-o-x x-show="nav" class="w-6 h-6" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-2 border-b lg:block lg:mt-0 lg:border-0" x-cloak :class="{ 'block': nav, 'hidden': !nav }">
                        <ul class="flex flex-col px-4 mb-2 gap-y-2 lg:flex-row lg:mb-0 lg:gap-6">
                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100 @if(is_active(['forum', 'threads*', 'thread'])) bg-gray-100 @endif">
                                <a href="{{ route('forum') }}" class="inline-block w-full px-2 py-1">
                                    Forum
                                </a>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100 @if(is_active(['articles', 'articles*'])) bg-gray-100 @endif">
                                <a href="{{ route('articles') }}" class="inline-block w-full px-2 py-1">
                                    Articles
                                </a>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100">
                                <a href="https://paste.laravel.io" class="inline-block w-full px-2 py-1">
                                    Pastebin
                                </a>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100">
                                <div @click.outside="chat = false" class="relative">
                                    <div>
                                        <button @click="chat = !chat" class="flex items-center lg:mb-0 py-1 px-2">
                                            Chat
                                            <x-heroicon-s-chevron-down x-show="!chat" class="w-4 h-4 ml-1"/>
                                            <x-heroicon-s-chevron-left x-cloak x-show="chat" class="w-4 h-4 ml-1"/>
                                        </button>
                                    </div>
                                    <div x-show="chat" x-cloak>
                                        <ul class="ml-4 lg:absolute lg:flex lg:flex-col lg:ml-0 lg:mt-2 lg:w-36 lg:rounded-md lg:shadow-lg lg:z-50 lg:bg-white">
                                            <li class="my-4 lg:hover:bg-gray-100 lg:my-0">
                                                <a href="https://discord.gg/KxwQuKb" class="inline-block w-full lg:px-4 lg:py-3">Discord</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://larachat.co" class="inline-block w-full lg:px-4 lg:py-3">Larachat</a>
                                            </li>

                                            <li class="hover:bg-gray-100">
                                                <a href="https://web.libera.chat/?nick=laravelnewbie&channels=#laravel" class="inline-block w-full lg:px-4 lg:py-3">IRC</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100">
                                <div @click.outside="community = false" class="relative" x-data="{ community: false }">
                                    <button @click="community = !community" class="flex items-center lg:mb-0 py-1 px-2">
                                        Community
                                        <x-heroicon-s-chevron-down x-show="!community" class="w-4 h-4 ml-1"/>
                                        <x-heroicon-s-chevron-left x-cloak x-show="community" class="w-4 h-4 ml-1"/>
                                    </button>

                                    <div x-show="community" x-cloak>
                                        <ul class="ml-4 lg:absolute lg:flex lg:flex-col lg:ml-0 lg:mt-2 lg:w-36 lg:rounded-md lg:shadow-lg lg:z-50 lg:bg-white">
                                            <li class="my-4 lg:hover:bg-gray-100 lg:my-0">
                                                <a href="https://github.com/laravelio" class="inline-block w-full lg:px-4 lg:py-3">Github</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://twitter.com/laravelio" class="inline-block w-full lg:px-4 lg:py-3">Twitter</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://laravel.com" class="inline-block w-full lg:px-4 lg:py-3">Laravel</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://laracasts.com" class="inline-block w-full lg:px-4 lg:py-3">Laracasts</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://laravel-news.com" class="inline-block w-full lg:px-4 lg:py-3">Laravel News</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://laravelevents.com" class="inline-block w-full lg:px-4 lg:py-3">Laravel Events</a>
                                            </li>

                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                                <a href="https://www.laravelpodcast.com" class="inline-block w-full lg:px-4 lg:py-3">Podcast</a>
                                            </li>

                                            <li class="hover:bg-gray-100">
                                                <a href="https://ecosystem.laravel.io" class="inline-block w-full lg:px-4 lg:py-3">Ecosystem</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="w-full block gap-x-4 lg:flex lg:items-center lg:justify-end">
                    <div class="lg:block" x-cloak :class="{ 'block': search, 'hidden': !search }" @click.outside="search = false">
                        @include('_partials._search')
                    </div>

                    <ul class="block lg:flex lg:items-center gap-x-8" x-cloak :class="{ 'block': nav, 'hidden': !nav }">
                        @if (Auth::guest())
                            <li class="w-full rounded text-center lg:hover:bg-gray-100">
                                <a href="{{ route('register') }}" class="inline-block w-full  p-2.5">
                                    Register
                                </a>
                            </li>

                            <li>
                                <div class="hidden lg:block">
                                    <x-buttons.secondary-cta class="flex items-center" href="{{ route('login') }}">
                                        <span class="flex items-center">
                                            <x-heroicon-o-user class="w-5 h-5 mr-1" />
                                            Login
                                        </span>
                                    </x-buttons.secondary-cta>
                                </div>

                                <a href="{{ route('login') }}" class="block w-full text-center bg-lio-500 text-white p-2.5 lg:hidden">
                                    Login
                                </a>
                            </li>
                        @else
                            <li class="relative p-4 lg:p-0" x-data="{ settings: false }">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('notifications') }}" class="hidden flex-shrink-0 rounded-full lg:block">
                                        <span class="block relative">
                                            <x-heroicon-o-bell  class="h-5 w-5 hover:fill-current hover:text-lio-500"/>

                                            <livewire:notification-indicator/>
                                        </span>
                                    </a>

                                    <x-avatar :user="Auth::user()" class="h-8 w-8" />

                                    <div @click.outside="settings = false">
                                        <button @click="settings = !settings" class="flex items-center">
                                            {{ Auth::user()->username() }}
                                            <x-heroicon-s-chevron-down x-show="!settings" class="w-4 h-4 ml-1"/>
                                            <x-heroicon-s-chevron-left x-show="settings" class="w-4 h-4 ml-1"/>
                                        </button>
                                    </div>
                                </div>

                                <div x-show="settings" x-cloak class="mt-4 lg:mt-0">
                                    <ul class="flex flex-col items-center lg:absolute lg:items-stretch lg:ml-0 lg:mt-2 lg:w-36 lg:rounded-md lg:shadow-lg lg:z-50 lg:bg-white">
                                         <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                             <a href="{{ route('profile') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                Your Profile
                                            </a>
                                        </li>

                                        <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                            <a href="{{ route('user.articles') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                Your Articles
                                            </a>
                                        </li>

                                        <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                            <a href="{{ route('settings.profile') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                Settings
                                            </a>
                                        </li>

                                        @can(App\Policies\UserPolicy::ADMIN, App\Models\User::class)
                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0 lg:border-t lg:border-b">
                                                <a href="{{ route('admin') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                    Admin
                                                </a>
                                            </li>
                                        @endcan

                                        <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                            <x-buk-logout class="inline-block w-full text-left lg:px-4 lg:py-3">
                                                Sign out
                                            </x-buk-logout>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @yield('subnav')
</nav>
