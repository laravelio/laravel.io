@title($user->name())

@extends('layouts.default')

@section('content')
    <div id="profile">
        <div class="profile-user-info">
            <img class="img-circle" src="{{ $user->gratavarUrl(150) }}">
            <h1>{{ $title }}</h1>

            <div class="profile-social-icons">
                @if ($user->githubUsername())
                    <a href="https://github.com/{{ $user->githubUsername() }}">
                        <i class="fa fa-github"></i>
                    </a>
                @endif
            </div>
        </div>

        <hr>

        <div class="profile-latest-threads">
            <h2>Latest Threads</h2>

            @forelse ($user->latestThreads() as $thread)
                <div class="profile-user-thread">
                    <h3><a href="{{ route('thread', $thread->slug()) }}">{{ $thread->subject() }}</a></h3>
                    <p>{{ $thread->excerpt() }}</p>
                </div>
            @empty
                <p>This user has not posted any threads yet.</p>
            @endforelse
        </div>

        <hr>

        <div class="profile-latest-replies">
            <h2>Latest Replies</h2>

            @forelse ($user->latestReplies() as $reply)
                <div class="profile-user-reply">
                    <h3><a href="{{ route_to_reply_able($reply->replyAble()) }}">{{ $reply->replyAble()->replySubject() }}</a></h3>
                    <p>{{ $reply->replyAble()->replyExcerpt() }}</p>
                </div>
            @empty
                <p>This user has not posted any replies yet.</p>
            @endforelse
        </div>
    </div>
@endsection
