<article class="article-summary">
    <h2><a class="more" href="{{ $article->showUrl }}">{{ $article->title }}</a></h2>
    <p>{{ $article->excerpt }}</p>
    <a href="{{ $article->showUrl }}">Read More</a>

    <div class="user">
        {{ $article->author->thumbnail }}
        <div class="info">
            <h6><a href="{{ $article->author->profileUrl }}">{{ $article->author->name }}</a></h6>
            <ul class="meta">
                <li>{{ $article->published_ago }}</li>
            </ul>
        </div>
    </div>
</article>