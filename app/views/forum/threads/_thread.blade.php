<div class="thread">
    <h2>{{ $thread->subject }}</h2>
    {{ $thread->body }}
    <div class="user">
        {{ $thread->author->thumbnail }}
        <div class="info">
            <h6><a href="{{ $thread->author->profileUrl }}">{{ $thread->author->name }}</a></h6>
            <ul class="meta">
        <li>{{ $thread->created_ago }}</li>
            </ul>
        </div>
    </div>

    @if($thread->isOwnedBy(Auth::user()))
        <div class="admin-bar">
            <li><a class="button" href="{{ action('ForumThreadsController@getEditThread', [$thread->id]) }}">Edit</a></li>
            <li><a class="button" href="{{ action('ForumThreadsController@getDelete', [$thread->id]) }}">Delete</a></li>
        </div>
    @endif
</div>