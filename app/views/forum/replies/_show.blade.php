<div class="comment" id="reply-{{ $reply->id }}">
        {{ $reply->body }}

        <div class="user">
            {{ $reply->author->thumbnail }}
            <div class="info">
                <h6><a href="{{ $reply->author->profileUrl }}">{{ $reply->author->name }}</a></h6>
                <ul class="meta">
                    <li><a href="{{ $reply->viewReplyUrl }}">{{ $reply->created_ago }}</a></li>
                </ul>
            </div>
        </div>
        @if(Auth::user() && $reply->author_id == Auth::user()->id)
            <div class="admin-bar">
                <li><a class="button" href="{{ action('ForumRepliesController@getEditReply', [$reply->id]) }}">Edit</a></li>
                <li><a class="button" href="{{ action('ForumRepliesController@getDelete', [$reply->id]) }}">Delete</a></li>
            </div>
        @endif
</div>