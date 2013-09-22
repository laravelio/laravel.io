<nav class="top-bar">
    <ul class="title-area">
        <!-- Title Area -->
        <li class="name">
            <h1><a href="{{ action('Controllers\HomeController@getIndex') }}"><img class="logo" src="/images/laravel-io-logo-small.png"></a></h1>
        </li>
        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
        <li class="toggle-topbar menu-icon">
            <a href="#"><span><!-- Menu --></span></a>
        </li>
    </ul><!-- Left Nav Section -->

    <section class="top-bar-section">
        <ul class="left main-nav">
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

        <ul class="right login">
            @if(Auth::check())
                <li><a href="{{ action('Controllers\DashboardController@getIndex') }}">{{ Auth::user()->name }}'s Dashboard</a></li>
            @else
                <li><a href="{{ action('Controllers\AuthController@getLogin') }}">Login with GitHub</a></li>
            @endif
        </ul>
    </section>
</nav>