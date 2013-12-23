<div class="thread-summary">
    {{ $thread->author->thumbnail }}
    <div class="info">
        <h3><a href="{{ $thread->forumThreadUrl }}">{{ $thread->laravel_version ? $thread->laravel_version . ' ' : '' }}{{ $thread->title }}</a></h3>
        <ul class="meta">
            <li>posted by <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
            <li>updated {{ $thread->updated_ago }}</li>
        </ul>
    </div>
    <div class="comment-count {{ $thread->isNewerThan($last_visited_timestamp) ? 'new' : '' }}">{{ $thread->child_count }}</div>
</div>