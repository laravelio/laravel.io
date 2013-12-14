<article>
    <div class="title-tags">
        <h3><a href="{{ $thread->forumThreadUrl }}">{{ $thread->title }}</a></h3>
        <div class="tags">Tags:  {{ $thread->tags->getTagList() }}</div>
    </div>

    <ul class="meta">
        <li><i class="icon-time"></i> {{ $thread->updated_ago }}</li>
        <li><i class="icon-user"></i> <a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></li>
        <li><i class="icon-comments"></i> {{ $thread->child_count_label }}</li>
    </ul>
</article>