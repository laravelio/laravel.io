<div class="comment" id="comment-{{ $comment->id }}">
    <div class="user">
        <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->thumbnail }}</a>
    </div>
    <div class="content">
        @if($comment->title)
            <h1>{{ $comment->title }}</h1>
        @endif
        @if($comment->id == $thread->id)
            <div class="tags">Tags:  {{ $comment->tags->getTagList() }}</div>
        @endif

        {{ $comment->body }}
        
        <ul class="meta">
            <li><i class="icon-time"></i>&nbsp;{{ $comment->created_ago }}</li>
            <li><i class="icon-user"></i>&nbsp;<a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
            @if($comment->id == $thread->id)
                <li><i class="icon-link"></i>&nbsp;<a href="{{ $comment->forumThreadUrl }}">Thread Link</a></li>
            @else
                <li><i class="icon-link"></i>&nbsp;<a href="{{ $comment->commentUrl }}">Reply Link</a></li>
            @endif

            @if(Auth::user() && $comment->id == $thread->id && $comment->author_id == Auth::user()->id)
                <li><i class="icon-link"></i>&nbsp;<a href="{{ action('ForumController@getEditThread', [$comment->id]) }}">Edit</a></li>
            @endif
        </ul>
    </div>
</div>