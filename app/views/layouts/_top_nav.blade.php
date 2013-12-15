<header class="top-navigation">
    <nav>
        <ul class="top-navigation-signin-mobile">
            @if(Auth::check())
                {{-- <li><a href="{{ action('DashboardController@getIndex') }}">{{ Auth::user()->name }}'s Dashboard</a></li> --}}
                <li><a href="{{ action('AuthController@getLogout') }}">Logout</a></li>
            @else
                <li><a href="{{ action('AuthController@getLogin') }}">Login with GitHub</a></li>
            @endif
        </ul>
        <div class="top-navigation-logo">
            <a href="{{ action('HomeController@getIndex') }}">
                <img class="logo" src="/images/laravel-io-logo-small.png">
            </a>
        </div>
        <ul class="top-navigation-items">
            <li>
                <a href="{{ action('ArticlesController@getIndex') }}">Articles</a>
            </li>
            <li>
                <a href="{{ action('ForumController@getIndex') }}">Forum</a>
            </li>
<!--             <li>
                <a href="{{ action('ChatController@getIndex') }}">Chat</a>
            </li>
 -->        </ul>
        <ul class="top-navigation-signin-desktop">
            @if(Auth::check())
                {{-- <li><a href="{{ action('DashboardController@getIndex') }}">{{ Auth::user()->name }}<span class="dashboard-word">'s Dashboard</span></a></li> --}}
                <li><a href="{{ action('AuthController@getLogout') }}">Logout</a></li>
            @else
                <li><a href="{{ action('AuthController@getLogin') }}">Login with GitHub</a></li>
            @endif
        </ul>
    </nav>
</header>
