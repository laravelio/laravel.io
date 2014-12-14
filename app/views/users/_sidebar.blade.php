<div class="user-sidebar">
    @if (! Route::currentRouteNamed('user'))
        <a href="{{ route('user', $user->name) }}">{{ $user->imageMedium }}</a>
    @else
        {{ $user->imageMedium }}
    @endif
    <h1>{{ $user->name }}</h1>
    <p><a class="button" target="_blank" href="{{ $user->github_url }}">Visit GitHub Profile</a></p>

    @if (Auth::check() && Auth::user()->email === $user->email)
        <p><a class="button" href="{{ route('user.settings', $user->name) }}">Edit Account Settings</a></p>
    @endif
</div>