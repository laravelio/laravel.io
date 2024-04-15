<nav class="{{ isset($hasShadow) ? 'mb-1 shadow' : '' }}">
    <div class="container mx-auto text-gray-800 lg:block lg:py-8" x-data="navConfig()" @click.outside="nav = false">
        <div class="block bg-white 2xl:-mx-10">
            <div class="lg:flex lg:px-4">
                <div class="block lg:flex lg:shrink-0 lg:items-center">
                    <div class="flex items-center justify-between p-4 lg:p-0">
                        <a href="{{ route('home') }}" class="mr-4">
                            <img
                                loading="lazy"
                                class="h-6 w-auto lg:h-8"
                                src="{{ asset('images/laravelio-logo.svg') }}"
                                width="330"
                                height="78"
                                alt="{{ config('app.name') }}"
                            />
                        </a>

                        <div class="flex gap-x-3 lg:hidden">
                            <a href="https://github.com/laravelio" class="inline-block">
                                <x-icon-github class="inline h-6 w-6" />
                            </a>

                            <a href="https://twitter.com/laravelio" class="inline-block">
                                <x-si-x class="inline h-6 w-6 text-twitter" />
                            </a>

                            <button @click="showSearch($event)">
                                <x-heroicon-o-magnifying-glass class="h-6 w-6" />
                            </button>

                            <button @click="nav = !nav">
                                <x-heroicon-o-bars-3-center-left x-show="!nav" class="h-6 w-6" />
                            </button>

                            <button @click="nav = !nav" x-cloak>
                                <x-heroicon-o-x-mark x-show="nav" class="h-6 w-6" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-2 border-b lg:mt-0 lg:block lg:border-0" x-cloak :class="{ 'block': nav, 'hidden': !nav }">
                        <ul class="mb-2 flex flex-col gap-y-2 px-4 lg:mb-0 lg:flex-row lg:gap-6">
                            <li class="@if(is_active(['forum', 'threads*', 'thread'])) bg-gray-100 @endif rounded lg:mb-0 lg:hover:bg-gray-100">
                                <a href="{{ route('forum') }}" class="inline-block w-full px-2 py-1"> Forum </a>
                            </li>

                            <li class="@if(is_active(['articles', 'articles*'])) bg-gray-100 @endif rounded lg:mb-0 lg:hover:bg-gray-100">
                                <a href="{{ route('articles') }}" class="inline-block w-full px-2 py-1"> Articles </a>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100">
                                <a href="https://paste.laravel.io" class="inline-block w-full px-2 py-1"> Pastebin </a>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100">
                                <div @click.outside="chat = false" class="relative">
                                    <div>
                                        <button @click="chat = !chat" class="flex items-center px-2 py-1 lg:mb-0">
                                            Chat
                                            <x-heroicon-s-chevron-down x-show="!chat" class="ml-1 h-4 w-4" />
                                            <x-heroicon-s-chevron-left x-cloak x-show="chat" class="ml-1 h-4 w-4" />
                                        </button>
                                    </div>
                                    <div x-show="chat" x-cloak>
                                        <ul class="ml-4 lg:absolute lg:z-50 lg:ml-0 lg:mt-2 lg:flex lg:w-36 lg:flex-col lg:rounded-md lg:bg-white lg:shadow-lg">
                                            <li class="my-4 lg:my-0 lg:hover:bg-gray-100">
                                                <a href="https://discord.gg/KxwQuKb" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <x-si-discord class="inline h-4 w-4 text-discord" />
                                                    Discord
                                                </a>
                                            </li>

                                            <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                                <a href="https://larachat.co" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <x-si-slack class="inline h-4 w-4 text-red-400" />
                                                    Larachat
                                                </a>
                                            </li>

                                            <li class="hover:bg-gray-100">
                                                <a
                                                    href="https://web.libera.chat/?nick=laravelnewbie&channels=#laravel"
                                                    class="inline-block w-full lg:px-4 lg:py-3"
                                                >
                                                    <x-heroicon-s-chat-bubble-oval-left-ellipsis class="inline h-4 w-4 text-green-500" />
                                                    IRC
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100">
                                <div @click.outside="community = false" class="relative">
                                    <button @click="community = !community" class="flex items-center px-2 py-1 lg:mb-0">
                                        Community
                                        <x-heroicon-s-chevron-down x-show="!community" class="ml-1 h-4 w-4" />
                                        <x-heroicon-s-chevron-left x-cloak x-show="community" class="ml-1 h-4 w-4" />
                                    </button>

                                    <div x-show="community" x-cloak>
                                        <ul class="ml-4 lg:absolute lg:z-50 lg:ml-0 lg:mt-2 lg:flex lg:w-48 lg:flex-col lg:rounded-md lg:bg-white lg:shadow-lg">
                                            <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                                <a href="https://laravel.com" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <img
                                                        loading="lazy"
                                                        src="{{ asset('images/laravel.png') }}"
                                                        alt="Laravel"
                                                        class="inline h-4 w-4"
                                                    />
                                                    Laravel
                                                </a>
                                            </li>

                                            <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                                <a href="https://laracasts.com" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <img
                                                        loading="lazy"
                                                        src="{{ asset('images/laracasts.png') }}"
                                                        alt="Laracasts"
                                                        class="inline h-4 w-4"
                                                    />
                                                    Laracasts
                                                </a>
                                            </li>

                                            <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                                <a href="https://laravel-news.com" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <img
                                                        loading="lazy"
                                                        src="{{ asset('images/laravel-news.png') }}"
                                                        alt="Laravel News"
                                                        class="inline h-4 w-4"
                                                    />
                                                    Laravel News
                                                </a>
                                            </li>

                                            <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                                <a href="https://www.laravelpodcast.com" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <img
                                                        loading="lazy"
                                                        src="{{ asset('images/podcast.png') }}"
                                                        alt="Laravel Podcast"
                                                        class="inline h-4 w-4"
                                                    />
                                                    Podcast
                                                </a>
                                            </li>

                                            <li class="hover:bg-gray-100">
                                                <a href="https://ecosystem.laravel.io" class="inline-block w-full lg:px-4 lg:py-3">
                                                    <img
                                                        loading="lazy"
                                                        src="{{ asset('images/laravelio-icon.svg') }}"
                                                        alt="Laravel Podcast"
                                                        class="inline h-4 w-4"
                                                    />
                                                    Ecosystem
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="block w-full gap-x-4 lg:flex lg:items-center lg:justify-end">
                    <div class="flex items-center gap-x-4">
                        <a href="https://github.com/laravelio" class="hidden lg:inline-block">
                            <x-icon-github class="inline h-5 w-5" />
                        </a>

                        <a href="https://twitter.com/laravelio" class="hidden lg:inline-block">
                            <x-si-x class="inline h-5 w-5 text-twitter" />
                        </a>

                        <button
                            @keydown.window.prevent.ctrl.k="showSearch($event)"
                            @keydown.window.prevent.cmd.k="showSearch($event)"
                            @click="showSearch($event)"
                            @keyup.window.slash="showSearch($event)"
                            class="hover:text-lio-500"
                        >
                            <x-heroicon-o-magnifying-glass class="hidden h-5 w-5 lg:block" />
                        </button>

                        @include('_partials._search')
                    </div>

                    <ul class="block gap-x-8 lg:flex lg:items-center" x-cloak :class="{ 'block': nav, 'hidden': !nav }">
                        @if (Auth::guest())
                            <li class="w-full rounded text-center lg:hover:bg-gray-100">
                                <a href="{{ route('register') }}" class="inline-block w-full p-2.5"> Register </a>
                            </li>

                            <li>
                                <div class="hidden lg:block">
                                    <x-buttons.secondary-cta class="flex items-center" href="{{ route('login') }}">
                                        <span class="flex items-center">
                                            <x-heroicon-o-user class="mr-1 h-5 w-5" />
                                            Login
                                        </span>
                                    </x-buttons.secondary-cta>
                                </div>

                                <a href="{{ route('login') }}" class="block w-full bg-lio-500 p-2.5 text-center text-white lg:hidden"> Login </a>
                            </li>
                        @else
                            <li class="relative p-4 lg:p-0">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('notifications') }}" class="hidden shrink-0 rounded-full lg:block">
                                        <span class="relative block">
                                            <x-heroicon-o-bell class="h-5 w-5 hover:fill-current hover:text-lio-500" />

                                            <livewire:notification-indicator />
                                        </span>
                                    </a>

                                    <x-avatar :user="Auth::user()" class="ml-5 h-8 w-8" />

                                    <div class="ml-2" @click.outside="settings = false">
                                        <button @click="settings = !settings" class="flex items-center">
                                            {{ Auth::user()->username() }}
                                            <x-heroicon-s-chevron-down x-show="!settings" class="ml-1 h-4 w-4" />
                                            <x-heroicon-s-chevron-left x-show="settings" class="ml-1 h-4 w-4" />
                                        </button>
                                    </div>
                                </div>

                                <div x-show="settings" x-cloak class="mt-4 lg:mt-0">
                                    <ul class="flex flex-col items-center lg:absolute lg:z-50 lg:ml-0 lg:mt-2 lg:w-40 lg:items-stretch lg:rounded-md lg:bg-white lg:shadow-lg">
                                        <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                            <a href="{{ route('profile') }}" class="flex w-full items-center lg:px-3 lg:py-2">
                                                <x-heroicon-o-user class="mr-2 h-4 w-4" />
                                                Your Profile
                                            </a>
                                        </li>

                                        <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                            <a href="{{ route('user.articles') }}" class="flex w-full items-center lg:px-3 lg:py-2">
                                                <x-heroicon-o-document-text class="mr-2 h-4 w-4" />
                                                Your Articles
                                            </a>
                                        </li>

                                        <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                            <a href="{{ route('settings.profile') }}" class="flex w-full items-center lg:px-3 lg:py-2">
                                                <x-heroicon-o-cog-6-tooth class="mr-2 h-4 w-4" />
                                                Settings
                                            </a>
                                        </li>

                                        @can(App\Policies\UserPolicy::ADMIN, App\Models\User::class)
                                            <li class="mb-4 lg:mb-0 lg:border-b lg:border-t lg:hover:bg-gray-100">
                                                <a href="{{ route('admin') }}" class="flex w-full items-center lg:px-3 lg:py-2">
                                                    <x-heroicon-o-shield-check class="mr-2 h-4 w-4" />
                                                    Admin
                                                </a>
                                            </li>
                                        @endcan

                                        <li class="mb-4 lg:mb-0 lg:hover:bg-gray-100">
                                            <x-buk-logout class="flex w-full items-center text-left lg:px-3 lg:py-2">
                                                <x-heroicon-o-arrow-left-on-rectangle class="mr-2 h-4 w-4" />
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
