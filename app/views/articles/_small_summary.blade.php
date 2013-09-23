<div class="post">
    <h3><a href="{{ $article->showUrl }}">{{ $article->title }}</a></h3>
    <ul class="meta">
        <li><i class="icon-time"></i> {{ $article->published_ago }}</li>
        <li><i class="icon-user"></i> {{ $article->author->name }}</li>
        <li><i class="icon-comments"></i> {{ $article->comment_count_label }}</li>
    </ul>
</div>