<div class="panel-footer">
    Posted {{ $thread->createdAt()->diffForHumans() }} ago by
    <a href="{{ route('profile', $thread->author()->username()) }}">{{ $thread->author()->name() }}</a>

    <div class="pull-right">
        <a href="{{ route('forum.topic', $thread->topic()->slug()) }}">
            <span class="label label-primary">{{ $thread->topic()->name() }}</span>
        </a>

        @foreach ($thread->tags() as $tag)
            <a href="{{ route('tag', $tag->slug()) }}">
                <span class="label label-default">{{ $tag->name() }}</span>
            </a>
        @endforeach
    </div>
</div>
