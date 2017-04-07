@if (count($threads))
    @foreach ($threads as $thread)
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div class="media-left">
                        <a href="{{ route('profile', $thread->author()->username()) }}">
                            <img class="media-object img-circle" src="{{ $thread->author()->gratavarUrl(45) }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="{{ route('thread', $thread->slug()) }}">
                            <span class="badge pull-right">{{ count($thread->replies()) }}</span>
                            <h4 class="media-heading">{{ $thread->subject() }}</h4>
                            <p>{{ $thread->excerpt() }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <a href="{{ route('forum.topic', $thread->topic()->slug()) }}">
                    <span class="label label-primary">{{ $thread->topic()->name() }}</span>
                </a>
                | Posted {{ $thread->createdAt()->diffForHumans() }} ago by
                <a href="{{ route('profile', $thread->author()->username()) }}">{{ $thread->author()->name() }}</a>

                @if (count($tags = $thread->tags()))
                    <div class="pull-right">
                        @foreach ($thread->tags() as $tag)
                            <a href="{{ route('tag', $tag->slug()) }}">
                                <span class="label label-default">{{ $tag->name() }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="text-center">
        {!! $threads->render() !!}
    </div>
@else
    <div class="alert alert-info text-center">
        No threads were found! <a href="{{ route('threads.create') }}" class="alert-link">Create a new one.</a>
    </div>
@endif
