<div id="categories">
    <h4>Categories</h4>
    <ul>
        <li><a href="#">All Articles</a></li>
        <li><a href="#">Installation / Configuration</a></li>
        <li><a href="#">Authentication / Security</a></li>
        <li><a href="#">Requests / Input</a></li>
        <li><a href="#">Session / Cache</a></li>
        <li><a href="#">Database / Eloquent</a></li>
        <li><a href="#">Architecture / IoC</a></li>
        <li><a href="#">Views / Templates / Forms</a></li>
        <li><a href="#">Mail / Queues</a></li>
    </ul>
</div>

<div id="new">
    <h4>Write an Article</h4>
    <p>We rely on community members to provide the resources that you see here. You can be a hero. Contribute your knowledge.</p>
    <a class="button full" href="{{ action('Controllers\ArticlesController@getCompose') }}">Write an Article</a>
</div>