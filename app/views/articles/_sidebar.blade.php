<div class="search">
    {{ Form::open(['action' => 'ArticlesController@getSearch', 'method' => 'GET']) }}
    {{ Form::text('query', isset($query) ? $query : '', ['placeholder' => 'search the laravel.io articles'] )}}
    {{ Form::close() }}
</div>
    <ul>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}">All Articles</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=news">News</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=installation,configuration">Installation / Configuration</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=authentication,security">Authentication / Security</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=requests,input">Requests / Input / Responses</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=session,cache">Session / Cache</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=database,eloquent">Database / Eloquent</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=architecture,ioc">Architecture / IoC</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=views,blade,forms">Views / Blade / Forms</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=mail,queues">Mail / Queues</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=meetups">Meetups / Local Communities</a></li>
        <li><a href="{{ action('Controllers\Articles\IndexArticleController@getIndex') }}?tags=laravelio">Laravel.io Site and Community</a></li>
    </ul>


<div class="write-article">
    <h4>Write an Article</h4>
    <p>We rely on community members to provide the resources that you see here. You can be a hero. Contribute your knowledge.</p>
    <a class="button full" href="{{ action('Controllers\Articles\CreateArticleController@getCreate') }}">Write an Article</a>
</div>
