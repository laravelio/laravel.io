<div class="thread-summary {{ $thread->isQuestion() ? 'question' : '' }} {{ $thread->isSolved() ? 'solved' : '' }}">
    {{ $thread->author->thumbnail }}
    <div class="info">
        <h3><a href="{{ $thread->url }}">{{ $thread->subject }}</a></h3>
        <ul class="meta">
            <li>posted by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
            <li>{{ $thread->LatestReplyMeta }}</li>
        </ul>
    </div>
    <a href="{{ $thread->latestReplyUrl() }}" class="comment-count {{ $thread->isNewerThan($last_visited_timestamp) ? 'new' : '' }}">{{ $thread->reply_count }}</a>
</div>
