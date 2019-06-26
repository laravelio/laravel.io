<nav>
    <div class="container mx-auto">
        <div class="h-16 flex justify-between items-center text-gray-600 border-b-2 mx-4">
            <a class="my-4" href="{{ route('home') }}">
                <img src="/images/laravelio.png" alt="Laravel.io Logo" class="w-40"/>
            </a>
            <ul class="flex nav">
                <li class="{{ active(['forum', 'threads*', 'thread']) }}"><a href="{{ route('forum') }}">Forum</a></li>
                <li><a href="https://paste.laravel.io">Pastebin</a></li>
                <li class="relative">
                    <a href="#" class="dropdown">Chat</a>
                    <ul class="subnav">
                        <li><a href="https://discord.gg/KxwQuKb">Discord</a></li>
                        <li><a href="https://larachat.co/">Larachat</a></li>
                        <li><a href="https://webchat.freenode.net/?nick=laravelnewbie&channels=%23laravel&prompt=1">IRC</a></li>
                    </ul>
                </li>
                <li><a href="https://laravelevents.com">Events</a></li>
                <li class="relative">
                    <a href="#" class="dropdown">Community</a>
                    <ul class="subnav">
                        <li><a href="https://github.com/laravelio"><i class="fa fa-github"></i> Github</a></li>
                        <li><a href="https://twitter.com/laravelio"><i class="fa fa-twitter"></i> Twitter</a></li>
                        <li><a href="https://medium.com/laravelio"><i class="fa fa-medium"></i> Medium</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="https://laravel.com">Laravel</a></li>
                        <li><a href="https://laracasts.com">Laracasts</a></li>
                        <li><a href="https://laravel-news.com">Laravel News</a></li>
                        <li><a href="http://www.laravelpodcast.com">Podcast</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="flex nav">
                @if (Auth::guest())
                    <li class="{{ active('login') }}"><a href="{{ route('login') }}">Login</a></li>
                    <li class="{{ active('register') }}"><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img class="img-circle" src="{{ Auth::user()->gravatarUrl(60) }}" width="30"> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <span>
                                    <strong>{{ Auth::user()->name() }}</strong><br>
                                    {{ '@'.Auth::user()->username() }}
                                </span>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li class="{{ active('profile') }}"><a href="{{ route('profile', Auth::user()->username()) }}"><i class="fa fa-user-circle-o dropdown-icon" aria-hidden="true"></i>Profile</a></li>
                            <li class="{{ active('dashboard') }}"><a href="{{ route('dashboard') }}"><i class="fa fa-home dropdown-icon" aria-hidden="true"></i>Dashboard</a></li>
                            <li class="{{ active('settings.*') }}"><a href="{{ route('settings.profile') }}"> <i class="fa fa-cog dropdown-icon" aria-hidden="true"></i>Settings</a></li>

                            @can(App\Policies\UserPolicy::ADMIN, App\User::class)
                                <li role="separator" class="divider"></li>
                                <li class="{{ active('admin*') }}"><a href="{{ route('admin') }}"><i class="fa fa-shield dropdown-icon" aria-hidden="true"></i>Admin</a></li>
                            @endcan

                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out dropdown-icon" aria-hidden="true"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="main-navbar-collapse">
            
        </div>
    </div>
</nav>
