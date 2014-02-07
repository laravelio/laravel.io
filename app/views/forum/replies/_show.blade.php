<div class="comment {{ $thread->isReplyTheSolution($reply) ? 'solution-border' : '' }}" id="reply-{{ $reply->id }}">

    <div class="user">
        {{ $reply->author->thumbnail }}
        <div class="info">
            <h6><a href="{{ $reply->author->profileUrl }}">{{ $reply->author->name }}</a></h6>
            <ul class="meta">
                <li><a href="{{ $reply->viewReplyUrl }}">{{ $reply->created_ago }}</a></li>
            </ul>
        </div>

        @if($thread->isReplyTheSolution($reply))
            <div class="solution accepted"><i class="fa fa-check-square"></i> Solution</div>
        @endif

        @if($thread->isQuestion() && $thread->isOwnedBy(Auth::user()))
            @if( ! $thread->isSolved())
                <a class="solution" href="{{ $thread->markAsSolutionUrl($reply->id) }}"><i class="fa fa-check-square"></i>Mark as Solution</a>
            @endif
        @endif

    </div>

    <span class="markdown">
        {{ $reply->body }}
    </span>

    <span style="display:none;" class="_author_name">{{ $reply->author->name }}</span>
    <span style="display:none;" class="_quote_body">{{ $reply->resource->body }}</span>

    @if(Auth::check())
        <div class="admin-bar">
            @if($reply->isOwnedBy(Auth::user()))
                <li><a href="{{ action('ForumRepliesController@getEditReply', [$reply->id]) }}">Edit</a></li>
                <li><a href="{{ action('ForumRepliesController@getDelete', [$reply->id]) }}">Delete</a></li>
            @endif

            <a href="#" class="quote _quote_forum_post">Quote</a>
        </div>
    @endif
</div>
