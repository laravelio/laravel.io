<header class="top-navigation">
<div class="top-navigation-logo">
    <a href="{{ action('HomeController@getIndex') }}">
        <img class="logo" src="/images/laravel-io-logo-dark-v3.png">
    </a>
</div>
    <nav>
        <ul>
            <li>
                <a href="{{ action('ForumController@getIndex') }}">Forum</a>
            </li>
        </ul>
    </nav>
    <ul class="user-navigation">
        @if(Auth::check())
            {{-- <li><a href="{{ action('DashboardController@getIndex') }}">{{ Auth::user()->name }}<span class="dashboard-word">'s Dashboard</span></a></li> --}}
            <li><a href="{{ action('AuthController@getLogout') }}">Logout</a></li>
        @else
            <li><a class="button inverse" href="{{ action('AuthController@getLogin') }}">Login with GitHub</a></li>
        @endif
    </ul>
</header>
