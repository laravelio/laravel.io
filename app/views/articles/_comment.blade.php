<div class="comment" id="comment-{{ $comment->id }}">
    <div class="user">
        <a href="{{ $comment->author->profileUrl }}">{{ $comment->author->thumbnail }}</a>
        <p><a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></p>
    </div>
    <div class="content">
        @if($comment->title)
            <h1>{{ $comment->title }}</h1>
        @endif

        {{ $comment->body }}

        <ul class="meta">
            <li><i class="icon-time"></i>&nbsp;{{ $comment->created_ago }}</li>
            <li><i class="icon-user"></i>&nbsp;<a href="{{ $comment->author->profileUrl }}">{{ $comment->author->name }}</a></li>
        </ul>
    </div>
</div>