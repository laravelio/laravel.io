<div class="comment" id="comment-{{ $comment->id }}">
        {{ $comment->body }}

        <div class="user">
            {{ $comment->author->thumbnail }}
            <div class="info">
                <h6><a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></h6>
                <ul class="meta">
                    <li>{{ $comment->created_ago }}</li>
                </ul>
            </div>
        </div>
        @if($currentUser && $comment->author_id == $currentUser->id)
            <div class="admin-bar">
                <li><a class="button" href="{{ action('ArticlesController@getEditComment', [$article->slug->slug, $comment->id]) }}">Edit</a></li>
                <li><a class="button" href="{{ action('ArticlesController@getDeleteComment', [$article->slug->slug, $comment->id]) }}">Delete</a></li>
            </div>
        @endif
</div>
