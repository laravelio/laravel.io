<div class="thread {{ $thread->isQuestion() ? 'question' : '' }} {{ $thread->isSolved() ? 'solved' : '' }} _post">
    <h1>{{ $thread->subject }}</h1>

    <span class="markdown">
        {{ $thread->body }}
    </span>

    <div class="user">
        {{ $thread->author->thumbnail }}
        <div class="info">
            <h6><a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></h6>
            <ul class="meta">
        <li>{{ $thread->created_ago }}</li>
            </ul>
        </div>
    </div>

    <span style="display:none;" class="_author_name">{{ $thread->author->name }}</span>
    <span style="display:none;" class="_quote_body">{{ $thread->resource->body }}</span>

    <div class="admin-bar">
        @if($thread->isManageableBy($currentUser))
            <li><a href="{{ $thread->editUrl }}">Edit</a></li>
            <li><a href="{{ $thread->deleteUrl }}">Delete</a></li>

            @if($thread->isQuestion() && $thread->isSolved())
                <li><a href="{{ $thread->markAsUnsolvedUrl }}">Mark Unsolved</a></li>
            @endif
        @endif
        <a href="#" class="quote _quote_forum_post">Quote</a>
    </div>
</div>
