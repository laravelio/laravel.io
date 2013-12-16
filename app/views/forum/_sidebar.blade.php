<div class="search">
    {{ Form::text('search', null, ['placeholder' => 'search the laravel.io forum'] )}}
</div>

    <ul>
        <li><a href="{{ action('ForumController@getIndex') }}">All Threads</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=installation,configuration">Installation / Configuration</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=authentication,security">Authentication / Security</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=requests,input">Requests / Input / Responses</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=session,cache">Session / Cache</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=database,eloquent">Database / Eloquent</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=packages,ioc">Packages / IoC </a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=views,blade,forms">Views / Blade / Forms</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=mail,queues">Mail / Queues</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=meetups">Local Community Meetups</a><span>4</span></li>
        <li><a href="{{ action('ForumController@getIndex') }}?tags=laravelio">Laravel.io Site and Community</a><span>4</span></li>
    </ul>
