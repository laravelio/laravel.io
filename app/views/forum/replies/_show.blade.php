<div class="comment {{ $thread->isReplyTheSolution($reply) ? 'solution-border' : '' }} _post" id="reply-{{ $reply->id }}" data-author-name='{{ json_encode($reply->author->name, JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS) }}' data-quote-body='{{ json_encode($reply->resource->body, JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS) }}'>

    <div class="user">
        {{ $reply->author->thumbnail }}
        <div class="info">
            <h6><a href="{{ $reply->author->profileUrl }}">{{ $reply->author->name }}</a></h6>
            <ul class="meta">
                <li><a href="{{ $reply->url }}">{{ $reply->created_ago }}</a></li>
            </ul>
        </div>

        @if($thread->isReplyTheSolution($reply))
            <div class="solution accepted"><i class="fa fa-check-square"></i> Solution</div>
        @endif

        @if($thread->isQuestion() && $thread->isManageableBy($currentUser))
            @if( ! $thread->isSolved())
                <a class="solution" href="{{ $thread->markAsSolutionUrl($reply->id) }}"><i class="fa fa-check-square"></i>Mark as Solution</a>
            @endif
        @endif

    </div>

    <span class="markdown">
        {{ $reply->body }}
    </span>

    @if(Auth::check())
        <div class="admin-bar">
            <ul>
            @if($reply->isManageableBy($currentUser))
                <li><a href="{{ action('ForumRepliesController@getUpdate', [$reply->id]) }}">Edit</a></li>
                <li><a href="{{ action('ForumRepliesController@getDelete', [$reply->id]) }}">Delete</a></li>
            @endif
                <li class="space"></li>
                <li><a href="#" class="quote _quote_forum_post">Quote</a></li>
            </ul>
        </div>
    @endif
</div>
