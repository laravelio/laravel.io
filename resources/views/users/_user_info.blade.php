<div class="profile-user-info">
    @can('admin', App\User::class)
        <a href="{{ route('admin.users.show', $user->username()) }}">
            <img class="img-circle" src="{{ $user->gratavarUrl($avatarSize ?? 150) }}">
        </a>
    @else
        <img class="img-circle" src="{{ $user->gratavarUrl($avatarSize ?? 150) }}">
    @endcan

    <h1>{{ $user->name() }}</h1>

    @if ($user->isAdmin())
        <p><span class="label label-primary">Admin</span></p>
    @elseif ($user->isModerator())
        <p><span class="label label-primary">Moderator</span></p>
    @endif

    <div class="profile-social-icons">
        @if ($user->githubUsername())
            <a href="https://github.com/{{ $user->githubUsername() }}">
                <i class="fa fa-github"></i>
            </a>
        @endif
    </div>
</div>
