<header class="top-navigation">
    <nav>
        <ul class="top-navigation-signin-mobile">
            @if(Auth::check())
                <li><a href="{{ action('Controllers\DashboardController@getIndex') }}">{{ Auth::user()->name }}'s Dashboard</a></li>
            @else
                <li><a href="{{ action('Controllers\AuthController@getLogin') }}">Login with GitHub</a></li>
            @endif  
        </ul>
        <div class="top-navigation-logo">
            <a href="{{ action('Controllers\HomeController@getIndex') }}">
                <img class="logo" src="/images/laravel-io-logo-small.png">
            </a>
        </div>
        <ul class="top-navigation-items">
            <li>
                <a href="{{ action('Controllers\ArticlesController@getIndex') }}">Articles</a>
            </li>
            <li>
                <a href="{{ action('Controllers\ForumController@getIndex') }}">Forum</a>
            </li>
            <li>
                <a href="{{ action('Controllers\ChatController@getIndex') }}">Chat</a>
            </li>    
        </ul>
        <ul class="top-navigation-signin-desktop">
            @if(Auth::check())
                <li><a href="{{ action('Controllers\DashboardController@getIndex') }}">{{ Auth::user()->name }}'s <span class="dashboard-word">Dashboard</span></a></li>
            @else
                <li><a href="{{ action('Controllers\AuthController@getLogin') }}">Login with GitHub</a></li>
            @endif  
        </ul>            
    </nav>
</header>
