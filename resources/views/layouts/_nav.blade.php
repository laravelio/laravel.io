<nav class="text-gray-600 bg-white border-b" x-data="{ mobileActive: false }" @click.away="mobileActive = false">
    <div class="container mx-auto px-4">
        <div class="nav-wrapper">
            <div class="nav-container">
                <a class="my-4" href="{{ route('home') }}">
                    <img src="{{ asset('images/laravelio.png') }}" alt="Laravel.io Logo" class="w-40"/>
                </a>

                <button 
                    type="button" 
                    id="sidebar-open" 
                    class="flex items-center lg:hidden text-gray-500 focus:outline-none cursor-pointer"
                    @click="mobileActive = true"
                    x-show="!mobileActive"
                >
                    <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                    </svg>
                </button>

                <button 
                    type="button" 
                    id="sidebar-close" 
                    class="flex items-center lg:hidden text-gray-500 focus:outline-none cursor-pointer"
                    @click="mobileActive = false"
                    x-show="mobileActive"
                    x-cloak
                >
                    <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                    </svg>
                </button>
            </div>

            <ul class="nav" :class="{ active: mobileActive }">
                <li class="{{ active(['forum', 'threads*', 'thread']) }}"><a href="{{ route('forum') }}">Forum</a></li>
                <li><a href="https://paste.laravel.io">Pastebin</a></li>
                <li class="relative" x-data="{ open: false }">
                    <a href="#" role="button" aria-haspopup="true" aria-expanded="false" @click="open = true">Chat</a>
                    <ul 
                        class="subnav"
                        x-show="open"
                        @click.away="open = false"
                        x-cloak
                    >
                        <li><a href="https://discord.gg/KxwQuKb">Discord</a></li>
                        <li><a href="https://larachat.co/">Larachat</a></li>
                        <li><a href="https://webchat.freenode.net/?nick=laravelnewbie&channels=%23laravel&prompt=1">IRC</a></li>
                    </ul>
                </li>
                <li><a href="https://laravelevents.com">Events</a></li>
                <li class="relative" x-data="{ open: false }">
                    <a href="#" role="button" aria-haspopup="true" aria-expanded="false" @click="open = true">Community</a>
                    <ul 
                        class="subnav"
                        x-show="open"
                        @click.away="open = false"
                        x-cloak
                    >
                        <li><a href="https://github.com/laravelio"><i class="fa fa-github"></i> Github</a></li>
                        <li><a href="https://twitter.com/laravelio"><i class="fa fa-twitter"></i> Twitter</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="https://laravel.com">Laravel</a></li>
                        <li><a href="https://laracasts.com">Laracasts</a></li>
                        <li><a href="https://laravel-news.com">Laravel News</a></li>
                        <li><a href="https://www.laravelpodcast.com">Podcast</a></li>
                        <li><a href="https://ecosystem.laravel.io">Ecosystem</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav" :class="{ active: mobileActive }">
                @if (Auth::guest())
                    <li class="{{ active('login') }}"><a href="{{ route('login') }}">Login</a></li>
                    <li class="{{ active('register') }}"><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="relative" x-data="{ open: false }">
                        <a href="#" role="button" aria-haspopup="true" aria-expanded="false" @click="open = true">
                            <img class="rounded-full" src="{{ Auth::user()->gravatarUrl(60) }}" style="width:30px;"> <span class="caret"></span>
                        </a>
                        <ul 
                            class="subnav subnav-right"
                            x-show="open"
                            @click.away="open = false"
                            x-cloak
                        >
                            <li>
                                <span>
                                    <strong>{{ Auth::user()->name() }}</strong><br>
                                    {{ '@'.Auth::user()->username() }}
                                </span>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li class="{{ active('profile') }}"><a href="{{ route('profile', Auth::user()->username()) }}"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Profile</a></li>
                            <li class="{{ active('dashboard') }}"><a href="{{ route('dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                            <li class="{{ active('settings.*') }}"><a href="{{ route('settings.profile') }}"> <i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>

                            @can(App\Policies\UserPolicy::ADMIN, App\User::class)
                                <li role="separator" class="divider"></li>
                                <li class="{{ active('admin*') }}"><a href="{{ route('admin') }}"><i class="fa fa-shield" aria-hidden="true"></i> Admin</a></li>
                            @endcan

                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
