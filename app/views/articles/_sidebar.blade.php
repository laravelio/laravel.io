<div class="categories">
    <h4>Categories</h4>
    <ul>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}">All Articles</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=installation,configuration">Installation / Configuration</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=authentication,security">Authentication / Security</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=requests,input">Requests / Input / Responses</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=session,cache">Session / Cache</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=database,eloquent">Database / Eloquent</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=architecture,ioc">Architecture / IoC</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=views,blade,forms">Views / Blade / Forms</a></li>
        <li><a href="{{ action('Controllers\ArticlesController@getIndex') }}?tags=mail,queues">Mail / Queues</a></li>
    </ul>
</div>

<div class="new-post">
    <h4>Write an Article</h4>
    <p>We rely on community members to provide the resources that you see here. You can be a hero. Contribute your knowledge.</p>
    <a class="button full" href="{{ action('Controllers\ArticlesController@getCompose') }}">Write an Article</a>
</div>