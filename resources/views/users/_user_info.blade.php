<div class="flex flex-col mb-4 w-full @if(isset($centered) && $centered) items-center @endif">

    <div class="mb-4">
        @can(App\Policies\UserPolicy::ADMIN, App\User::class)
            <a href="{{ route('admin.users.show', $user->username()) }}">
                <img src="{{ $user->gravatarUrl($avatarSize ?? 250) }}" class="w-full">
            </a>
        @else
            <a href="{{ route('profile', $user->username()) }}">
                <img src="{{ $user->gravatarUrl($avatarSize ?? 250) }}" class="w-full">
            </a>
        @endcan
    </div>

    <h2 class="text-2xl text-gray-900 mb-4">{{ $user->name() }}</h2>

    @if(Auth::id() === $user->id)
        <a class="button mb-4" href="{{ route('settings.profile') }}">
            Edit profile
        </a>
    @endif

    @if ($bio = $user->bio())
        <p class="text-gray-900 mb-1">
            {{ $bio }}
        </p>
    @endif

    <p class="text-gray-600 text-sm mb-4">
        Joined {{ $user->created_at->format('j M Y') }} ({{ $user->created_at->diffForHumans() }})
    </p>

    @if ($user->isAdmin())
        <p class="mb-2"><span class="px-2 py-1 rounded text-xs uppercase bg-green-primary text-white px-2 py-1">Admin</span></p>
    @elseif ($user->isModerator())
        <p class="mb-2"><span class="label">Moderator</span></p>
    @endif

    <div>
        @if ($user->githubUsername())
            <a href="https://github.com/{{ $user->githubUsername() }}" class="text-green-darker text-3xl block flex items-center">
                <i class="fa fa-github mr-2"></i>
                <span class="text-base">
                    {{ '@' . $user->githubUsername() }}
                </span>
            </a>
        @endif
    </div>

</div>
