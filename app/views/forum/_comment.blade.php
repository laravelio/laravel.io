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
                <li><i class="icon-link"></i>&nbsp;<a href="{{ $comment->forumThreadUrl }}">Link</a></li>
            @else
                <li><i class="icon-link"></i>&nbsp;<a href="{{ $comment->commentUrl }}">Link</a></li>
            @endif

            @if(Auth::user() && $comment->id == $thread->id && $comment->author_id == Auth::user()->id)
                <li><i class="icon-link"></i>&nbsp;<a href="{{ action('ForumController@getEditThread', [$comment->id]) }}">Edit</a></li>
                {{-- this code is so awful... --}}
            @elseif(Auth::user() && $comment->author_id == Auth::user()->id)
                <li><i class="icon-link"></i>&nbsp;<a href="{{ action('ForumController@getEditComment', [$comment->id]) }}">Edit</a></li>
            @else
                {{-- “That ain't me, that ain't my face. It wasn't even me when I was trying to be that face. I wasn't even really me them; I was just being the way I looked, the way people wanted.”  --}}
            @endif
        </ul>
    </div>
</div>