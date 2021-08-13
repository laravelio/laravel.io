<div class="flex flex-col mb-4 w-full @if (isset($centered) && $centered) items-center @endif">
    <div class="mb-4">
        <a href="{{ route('profile', $user->username()) }}">
            <x-avatar :user="$user" class="w-56 h-56" />
        </a>
    </div>

    <h2 class="flex flex-col text-2xl text-gray-900 mb-4">
        {{ $user->name() }}
        <span class="text-xl text-gray-600">{{ $user->username() }}</span>
    </h2>

    @if ($user->isLoggedInUser())
        <a class="button mb-4" href="{{ route('settings.profile') }}">
            Edit profile
        </a>
    @endif

    @can(App\Policies\UserPolicy::BAN, $user)
        @if ($user->isBanned())
            <button type="button" class="button button-primary w-full mb-4" @click.prevent="activeModal = 'unbanUser'">Unban User</button>
        @else
            <button type="button" class="button button-danger w-full mb-4" @click.prevent="activeModal = 'banUser'">Ban User</button>
        @endif
    @endcan

    @if (Auth::check() && Auth::user()->isAdmin())
        @can(App\Policies\UserPolicy::DELETE, $user)
            <button type="button" class="button button-danger w-full mb-4" @click.prevent="activeModal = 'deleteUser'">Delete User</button>
        @endcan
    @endif

    @if ($bio = $user->bio())
        <p class="text-gray-900 mb-1">
            {{ $bio }}
        </p>
    @endif

    <p class="text-gray-600 text-sm mb-4">
        Joined {{ $user->created_at->format('j M Y') }}
    </p>

    @if ($user->isAdmin())
        <p class="mb-2">
            <span class="px-2 py-1 rounded text-xs uppercase bg-lio-500 text-white px-2 py-1">
                Admin
            </span>
        </p>
    @elseif ($user->isModerator())
        <p class="mb-2">
            <span class="label">Moderator</span>
        </p>
    @endif

    <div class="flex items-center gap-x-3">
        @if ($user->githubUsername())
            <a href="https://github.com/{{ $user->githubUsername() }}" class="text-lio-700 text-3xl block flex items-center">
                <span class="flex items-center justify-center mb-1">
                    <x-icon-github class="h-5 w-5 mr-2" />
                </span>
            </a>
        @endif

        @if ($user->twitter())
            <a href="https://twitter.com/{{ $user->twitter() }}" class="text-lio-700 text-3xl block flex items-center">
                <span class="flex items-center justify-center mb-1">
                    <x-icon-twitter class="h-5 w-5 mr-2" />
                </span>
            </a>
        @endif
    </div>
</div>

{{-- The reason why we put the modals here is because otherwise UI gets broken --}}
@can(App\Policies\UserPolicy::BAN, $user)
    @if ($user->isBanned())
        @include('_partials._update_modal', [
            'identifier' => 'unbanUser',
            'route' => ['admin.users.unban', $user->username()],
            'title' => "Unban {$user->username()}",
            'body' => '<p>Unbanning this user will allow them to login again and post content.</p>',
        ])
    @else
        @include('_partials._update_modal', [
            'identifier' => 'banUser',
            'route' => ['admin.users.ban', $user->username()],
            'title' => "Ban {$user->username()}",
            'body' => '<p>Banning this user will prevent them from logging in, posting threads and replying to threads.</p>',
        ])
    @endif
@endcan

@can(App\Policies\UserPolicy::DELETE, $user)
    @include('_partials._delete_modal', [
        'identifier' => 'deleteUser',
        'route' => ['admin.users.delete', $user->username()],
        'title' => "Delete {$user->username()}",
        'body' => '<p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>',
    ])
@endcan
