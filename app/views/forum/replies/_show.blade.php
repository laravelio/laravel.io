<div class="comment" id="reply-{{ $reply->id }}">
<<<<<<< HEAD
        <span class="markdown">
            {{ $reply->body }}
        </span>
=======
    <span class="markdown">
        {{ $reply->body }}
    </span>
>>>>>>> 32bd5178d4747434a21409e9376f8c3deb586214

    <span style="display:none;" class="_author_name">{{ $reply->author->name }}</span>
    <span style="display:none;" class="_quote_body">{{ $reply->resource->body }}</span>

    <div class="user">
        {{ $reply->author->thumbnail }}
        <div class="info">
            <h6><a href="{{ $reply->author->profileUrl }}">{{ $reply->author->name }}</a></h6>
            <ul class="meta">
                <li><a href="{{ $reply->viewReplyUrl }}">{{ $reply->created_ago }}</a></li>
            </ul>
        </div>
    </div>
    @if(Auth::check())
        <div class="admin-bar">
            @if($reply->isOwnedBy(Auth::user()))
                <li><a href="{{ action('ForumRepliesController@getEditReply', [$reply->id]) }}">Edit</a></li>
                <li><a href="{{ action('ForumRepliesController@getDelete', [$reply->id]) }}">Delete</a></li>
            @endif
            <li><a href="#" class="_quote_forum_post">Quote</a></li>
        </div>
<<<<<<< HEAD
        @if(Auth::user() && $reply->author_id == Auth::user()->id)
            <div class="admin-bar">
                <li><a href="{{ action('ForumRepliesController@getEditReply', [$reply->id]) }}">Edit</a></li>
                <li><a href="{{ action('ForumRepliesController@getDelete', [$reply->id]) }}">Delete</a></li>
            </div>
        @endif
=======
    @endif
>>>>>>> 32bd5178d4747434a21409e9376f8c3deb586214
</div>