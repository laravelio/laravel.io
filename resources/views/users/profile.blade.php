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

        <div class="row profile-latest-items">
            <div class="col-md-6">
                <h3>Latest Threads</h3>

                @forelse ($user->latestThreads() as $thread)
                    <div class="list-group">
                        <a href="{{ route('thread', $thread->slug()) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $thread->subject() }}</h4>
                            <p class="list-group-item-text">{{ $thread->excerpt() }}</p>
                        </a>
                    </div>
                @empty
                    <p class="text-center">This user has not posted any threads yet.</p>
                @endforelse
            </div>
            <div class="col-md-6">
                <h3>Latest Replies</h3>

                @forelse ($user->latestReplies() as $reply)
                    <div class="list-group">
                        <a href="{{ route_to_reply_able($reply->replyAble()) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $reply->replyAble()->replySubject() }}</h4>
                            <p class="list-group-item-text">{{ $reply->replyAble()->replyExcerpt() }}</p>
                        </a>
                    </div>
                @empty
                    <p class="text-center">This user has not posted any replies yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
