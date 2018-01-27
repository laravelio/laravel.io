<div class="profile-user-info">
    @can(App\Policies\UserPolicy::ADMIN, App\User::class)
        <a href="{{ route('admin.users.show', $user->username()) }}">
            <img class="img-circle" src="{{ $user->gravatarUrl($avatarSize ?? 150) }}">
        </a>
    @else
        <a href="{{ route('profile', $user->username()) }}">
            <img class="img-circle" src="{{ $user->gravatarUrl($avatarSize ?? 150) }}">
        </a>
    @endcan

    <h2>{{ $user->name() }}</h2>

    @if ($bio = $user->bio())
        <p class="profile-user-bio">
            {{ $bio }}
        </p>
    @endif

    @auth
            @if ($user->isAdmin())
                <p><span class="label label-primary">Admin</span></p>
            @elseif ($user->isModerator())
                <p><span class="label label-primary">Moderator</span></p>
            @endif

    @endauth


    <div class="profile-social-icons">
        @if ($user->githubUsername())
            <a href="https://github.com/{{ $user->githubUsername() }}">
                <i class="fa fa-github"></i>
            </a>
        @endif

            @if ($user->twitterUsername())
                <a href="https://twitter.com/{{ $user->twitterUsername() }}">
                    <i class="fa fa-twitter"></i>
                </a>
            @endif
    </div>
</div>
