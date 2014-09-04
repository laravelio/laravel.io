<div class="thread-summary {{ $thread->isQuestion() ? 'question' : '' }} {{ $thread->isSolved() ? 'solved' : '' }}">
    {{ $thread->author->thumbnail }}

    <div class="info">
        <h3><a href="{{ $thread->url }}">{{{ $thread->subject }}}</a></h3>

        <div class="post-info">
            @if ($thread->isSolved())
                <a class="solution accepted mini" href="{{ $thread->acceptedSolutionUrl }}"><i class="fa fa-check-square"></i></a>
                <a class="solution accepted" href="{{ $thread->acceptedSolutionUrl }}"><i class="fa fa-check-square"></i> solved</a>
            @endif

            <a href="{{ $thread->latestReplyUrl }}" class="comment-count">{{ $thread->reply_count }}</a>
        </div>

        <ul class="meta">
            <li>posted by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
            @if ($thread->mostRecentReply)
            <li> - latest reply {{ $thread->updated_ago }} by <a href="{{ $thread->mostRecentReplierProfileUrl }}">{{ $thread->mostRecentReplier }}</a></li>
            @endif
        </ul>
    </div>

    <div class="post-info">
        <a href="{{ $thread->latestReplyUrl() }}" class="comment-count">{{ $thread->reply_count }}</a>
        @if ($thread->isSolved())
        <a class="solution accepted" href="{{ $thread->acceptedSolutionUrl }}"><i class="fa fa-check-square"></i> solved</a>
        @endif
    </div>
</div>
