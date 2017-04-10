<div class="panel-footer">
    Posted {{ $thread->createdAt()->diffForHumans() }} ago by
    <a href="{{ route('profile', $thread->author()->username()) }}">{{ $thread->author()->name() }}</a>

    @if (count($thread->tags()))
        <div class="pull-right">
            @foreach ($thread->tags() as $tag)
                <a href="{{ route('tag', $tag->slug()) }}">
                    <span class="label label-default">{{ $tag->name() }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>
