<article>
    <h1><a class="more" href="{{ $article->showUrl }}">{{ $article->title }}</a></h1>
        <ul class="meta">
            <li><i class="icon-time"></i> {{ $article->published_ago }}</li>
            <li><i class="icon-user"></i> {{ $article->author->name }}</li>
            <li><i class="icon-comments"></i> {{ $article->comment_count_label }}</li>
        </ul>
    <p>{{ $article->summary }}</p>
    <a class="more" href="{{ $article->showUrl }}"><span>Read more</span></a>
</article>