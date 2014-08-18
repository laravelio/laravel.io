<header class="top-navigation">
    <div class="top-navigation-logo">
        <a href="{{ action('HomeController@getIndex') }}">
            <img class="logo" src="/images/laravel-io-logo.png">
        </a>
    </div>
    <nav>
        <ul>
            <li>
                <a class="{{ Request::is('forum*') ? 'active' : null }}" href="{{ action('ForumThreadsController@getIndex') }}">Forum</a>
            </li>
            <li>
                <a href="https://larajobs.com/?partner=28">Jobs</a>
            </li>
            <li>
                <a class="{{ Request::is('chat*') ? 'active' : null }}" href="{{ action('ChatController@getIndex') }}">Live Chat</a>
            </li>
            <li>
                <a href="{{ action('PastesController@getCreate') }}">Pastebin</a>
            </li>
            <li>
                <a href="http://www.buzzsprout.com/11908">Podcast</a>
            </li>
            <li>
                <a target="_blank" href="http://forumsarchive.laravel.io/">Old Forum Archive</a>
            </li>
        </ul>
    </nav>
    <ul class="user-navigation">
        @if(Auth::check())
            <li><a href="{{ url($currentUser->profileUrl) }}">{{ $currentUser->name }}</a></li>
            <li><a class="button" href="{{ action('AuthController@getLogout') }}">Logout</a></li>
        @else
            <li><a class="button" href="{{ action('AuthController@getLogin') }}">Login with GitHub</a></li>
        @endif
    </ul>
</header>
