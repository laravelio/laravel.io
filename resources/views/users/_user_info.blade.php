@can(App\Policies\UserPolicy::ADMIN, App\User::class)
    <a href="{{ route('admin.users.show', $user->username()) }}">
        <img class="rounded-full" src="{{ $user->gravatarUrl($avatarSize ?? 150) }}">
    </a>
@else
    <a href="{{ route('profile', $user->username()) }}">
        <img class="rounded-full" src="{{ $user->gravatarUrl($avatarSize ?? 150) }}">
    </a>
@endcan

<h2 class="text-2xl text-gray-900">{{ $user->name() }}</h2>

@if ($bio = $user->bio())
    <p class="text-gray-600">
        {{ $bio }}
    </p>
@endif

@if ($user->isAdmin())
    <p><span class="label label-primary">Admin</span></p>
@elseif ($user->isModerator())
    <p><span class="label">Moderator</span></p>
@endif

<div>
    @if ($user->githubUsername())
        <a href="https://github.com/{{ $user->githubUsername() }}" class="text-green-darker text-3xl block">
            <i class="fa fa-github"></i>
        </a>
    @endif
</div>
