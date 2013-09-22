<section id="sidebar">
    <div id="categories">
        <h4>Categories</h4>
        <ul>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
            <li><a href="#">Security/Auth</a></li>
        </ul>
    </div>
    <div id="new">
        <h4>Add New</h4>
        <p>You think you got what it takes to be the very best?</p>
        <a class="button full" href="{{ action('Controllers\ArticlesController@getCompose') }}">Write an Article</a>
    </div>
</section>

<section id="articles">
<h2>Articles</h2>

    <article>
        <h2>The Laravel Foundations Project</h2>
            <ul class="meta">
                <li><i class="icon-time"></i> 2 Days ago</li>
                <li><i class="icon-user"></i> Shawn McCool</li>
                <li><i class="icon-comments"></i> 3 Comments</li>
            </ul>
        <p>The goal of this project is to enlist a number of experience Laravel developers who can help write articles about the common questions that come up in the Laravel support community settings (such as IRC and the forums).</p>
        <a class="more" href="article.html"><span>Read more</span></a>
    </article>
</section>