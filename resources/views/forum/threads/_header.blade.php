<h1>{{ $title }}</h1>
<div class="thread-info">
    <div class="thread-info-avatar">
        @if (count($thread->replies()))
            @php($lastReply = $thread->replies()->last())
            <img class="img-circle" src="{{ $lastReply->author()->gratavarUrl(25) }}">
        @else
            <img class="img-circle" src="{{ $thread->author()->gratavarUrl(25) }}">
        @endif
    </div>

    <div class="thread-info-content">
        @if (count($thread->replies()))
            @php($lastReply = $thread->replies()->last())
            <a href="{{ route('profile', $lastReply->author()->username()) }}" class="thread-info-link">{{ $lastReply->author()->name() }}</a>
            added the last reply {{ $lastReply->createdAt()->diffForHumans() }}

        @else
            <a href="{{ route('profile', $thread->author()->username()) }}" class="thread-info-link">{{ $thread->author()->name() }}</a>
            posted {{ $thread->createdAt()->diffForHumans() }}
        @endif
    </div>

    @if (count($thread->tags()))
        <div class="thread-info-right">
            @foreach ($thread->tags() as $tag)
                <a href="{{ route('forum.tag', $tag->slug()) }}">
                    <span class="label label-default">{{ $tag->name() }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>