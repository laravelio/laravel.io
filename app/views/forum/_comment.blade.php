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
        @if(Auth::user() && $comment->author_id == Auth::user()->id)
            <div class="admin-bar">
                <li><a class="button" href="{{ action('ForumReplyController@getEditReply', [$comment->id]) }}">Edit</a></li>
                <li><a class="button" href="{{ action('ForumReplyController@getDelete', [$comment->id]) }}">Delete</a></li>
            </div>
        @endif
</div>