<div class="comment" id="comment-{{ $comment->id }}">
    <div class="user">
        <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->thumbnail }}</a>
        <p><a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></p>
    </div>
    <div class="content">
        @if($comment->title)
            <h1>{{ $comment->title }}</h1>
        @endif

        {{ $comment->body }}

        <ul class="meta">
            <li><i class="icon-time"></i>&nbsp;{{ $comment->created_ago }}</li>
            <li><i class="icon-user"></i>&nbsp;<a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
            @if(Auth::check() && $comment->author_id == Auth::user()->id)
                <li><i class="icon-link"></i>&nbsp;<a href="{{ action('ArticlesController@getEditComment', [$article->slug->slug, $comment->id]) }}">Edit</a></li>
                <li><i class="icon-link"></i>&nbsp;<a href="{{ action('ArticlesController@getDeleteComment', [$article->slug->slug, $comment->id]) }}">Delete</a></li>
            @endif
        </ul>
    </div>
</div>