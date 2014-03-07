<div class="thread-summary">
    {{ $thread->author->thumbnail }}
    <div class="info">
        <h3><a href="{{ $thread->url }}">{{ $thread->title }}</a></h3>
        <ul class="meta">
            <li>posted by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
            <li>updated {{ $thread->updated_ago }}</li>
        </ul>
    </div>
    <div class="comment-count">{{ $thread->reply_count }}</div>
</div>
