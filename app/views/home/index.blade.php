<secion class="hero-section">
    <div class="description">
        <h1>Articles</h1>
        <p class="lead">
            Find articles that cover a wide-array of Laravel and web-development related topics written by community members. <a href="{{ action('Controllers\ArticlesController@getCompose') }}">Write your own</a> to help improve the resource.
        </p>
    </div>
    <div class="posts">
        @foreach($articles as $article)
            @include('articles._small_summary')
        @endforeach
        <p>
            <a href="{{ action('Controllers\ArticlesController@getDashboard') }}">See all articles</a>
        </p>
    </div>
</section>

<secion class="hero-section dark">
    <div class="description">
        <h1>Forum Posts</h1>
        <p class="lead">
            Discuss development related topics, ask for, and provide help.
        </p>
    </div>
    <div class="posts">
        @foreach($threads as $thread)
            @include('forum._small_summary')
        @endforeach
    </div>
</section>

<secion class="hero-section darker">
    <div class="description">
        <h1>Help Cases</h1>
        <p class="lead">
            We have no idea what will go here.
        </p>
    </div>
    <div class="posts">

    </div>
</section>