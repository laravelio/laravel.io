<div class="panel-footer">
    @if (count($thread->replies()))
        @php($lastReply = $thread->replies()->last())
        Latest reply posted {{ $lastReply->createdAt()->diffForHumans() }} ago by
        <a href="{{ route('profile', $lastReply->author()->username()) }}">{{ $lastReply->author()->name() }}</a>
    @else
        Posted {{ $thread->createdAt()->diffForHumans() }} ago by
        <a href="{{ route('profile', $thread->author()->username()) }}">{{ $thread->author()->name() }}</a>
    @endif

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
