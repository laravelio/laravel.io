<div class="comment" id="comment-{{ $comment->id }}">
        {{ $comment->body }}

        <div class="user">
            {{ $comment->author->thumbnail }}
            <div class="info">
                <h6><a href="{{ $comment->forumThreadUrl }}">{{ $comment->author->name }}</a></h6>
                <ul class="meta">
                    <li>{{ $comment->created_ago }}</li>
                </ul>
            </div>
        </div>
</div>