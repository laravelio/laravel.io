@title('Members Directory')

@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1 members-list">
            @if($members->count())
            @foreach($members as $member)

                    <div class="member-item">
                        <img class="avatar" src="{{ $member->gravatarUrl(48) }}">
                        <div class="flex member">
                            <a href="{{ route('profile', $member->username()) }}" class="username">
                                <span>{{ $member->username }}</span>
                            </a>
                            <small>Member since {{ $member->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="social_links">
                            @if ($member->githubUsername())
                                <a href="https://github.com/{{ $member->githubUsername() }}">
                                    <i class="fa fa-github"></i>
                                </a>
                            @endif

                            @if ($member->twitterUsername())
                                <a href="https://twitter.com/{{ $member->twitterUsername() }}">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            @endif
                        </div>
                    </div>


            @endforeach
            @else
                <div class="col-md-10 col-md-offset-1 text-center">
                <h3>No members are listed</h3>
                </div>
            @endif
        </div>
    </div>


@endsection