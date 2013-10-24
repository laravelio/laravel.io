<h1>Your Articles</h1>

@if($articles->count() > 0)
    <ul>
        @foreach($articles as $article)
            <li>
                <a href="{{ $article->editUrl }}">{{ $article->title }}</a>
                {{ $article->summary }}
            </li>
        @endforeach
    </ul>
@else
    You haven't yet written any articles. <a href="{{ action('Controllers\ArticlesController@getCompose') }}">Remedy This</a>
@endif