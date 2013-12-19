<div class="search">
    {{ Form::text('search', null, ['placeholder' => 'search the laravel.io forum'] )}}
</div>
    <ul>
        <li><a href="{{ action('ArticlesController@getIndex') }}">All Articles</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=news">News</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=installation,configuration">Installation / Configuration</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=authentication,security">Authentication / Security</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=requests,input">Requests / Input / Responses</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=session,cache">Session / Cache</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=database,eloquent">Database / Eloquent</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=architecture,ioc">Architecture / IoC</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=views,blade,forms">Views / Blade / Forms</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=mail,queues">Mail / Queues</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=meetups">Meetups / Local Communities</a></li>
        <li><a href="{{ action('ArticlesController@getIndex') }}?tags=laravelio">Laravel.io Site and Community</a></li>
    </ul>


<div class="write-article">
    <h4>Write an Article</h4>
    <p>We rely on community members to provide the resources that you see here. You can be a hero. Contribute your knowledge.</p>
    <a class="button full" href="{{ action('ArticlesController@getCompose') }}">Write an Article</a>
</div>
