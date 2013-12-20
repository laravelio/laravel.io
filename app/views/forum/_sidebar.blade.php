<div class="search">
    {{ Form::open(['action' => 'ForumController@getSearch', 'method' => 'GET']) }}
    {{ Form::text('query', isset($query) ? $query : '', ['placeholder' => 'search the laravel.io forum'] )}}
    {{ Form::close() }}
</div>

<ul>
    <li><a href="{{ action('ForumController@getIndex') }}">All Threads<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=installation,configuration">Installation / Configuration<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=authentication,security">Authentication / Security<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=requests,input">Requests / Input / Responses<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=session,cache">Session / Cache<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=database,eloquent">Database / Eloquent<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=packages,ioc">Packages / IoC <span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=views,blade,forms">Views / Blade / Forms<span>14</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=mail,queues">Mail / Queues<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=meetups">Local Community Meetups<span>4</span></a></li>
    <li><a href="{{ action('ForumController@getIndex') }}?tags=laravelio">Laravel.io Site and Community<span>4</span></a></li>
</ul>