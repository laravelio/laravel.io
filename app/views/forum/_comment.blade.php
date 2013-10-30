<div class="comment" id="comment-{{ $comment->id }}">
    <div class="user">
        <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->thumbnail }}</a>
    </div>
    <div class="content">
        @if($comment->id == $thread->id)
            <h1>{{ $comment->title }}</h1>
            <div class="tags">Tags:  {{ $comment->tags->getTagList() }}</div>
            {{ $comment->body }}
            <ul class="meta">
                <li><i class="icon-time"></i> {{ $comment->created_ago }}</li>
                <li><i class="icon-user"></i><a href="{{ $comment->author->profileUrl }}"> {{ $comment->author->name }}</a></li>
            </ul>
        @else
            {{ $comment->body }}
              <ul class="meta">
                <li><i class="icon-time"></i>&nbsp;{{ $comment->created_ago }}</li>
                <li><i class="icon-user"></i>&nbsp;<a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
                <li><i class="icon-link"></i>&nbsp;<a href="{{ $comment->commentUrl }}">Share</a></li>
            </ul>
        @endif
    </div>
</div>