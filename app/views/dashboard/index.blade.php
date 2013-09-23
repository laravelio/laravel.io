<h1>{{ $user->name }}</h1>

<h2>Articles</h2>

<a href="{{ action('Controllers\ArticlesController@getDashboard') }}">See all articles</a>