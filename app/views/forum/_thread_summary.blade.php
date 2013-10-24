<article>
    <h3><a href="{{ $thread->forumThreadUrl }}">{{ $thread->title }}</a></h3>
    <ul class="meta">
        <li><i class="icon-time"></i> {{ $thread->created_ago }}</li>
        <li><i class="icon-user"></i> {{ $thread->author->name }}</li>
        <li><i class="icon-comments"></i> {{ $thread->child_count_label }}</li>
    </ul>
</article>