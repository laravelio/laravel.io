<div class="user-sidebar">
    @if (! Route::currentRouteNamed('user'))
        <a href="{{ route('user', $user->name) }}">{{ $user->imageMedium }}</a>
    @else
        {{ $user->imageMedium }}
    @endif
    <h1>{{ $user->name }}</h1>
    <a class="button" target="_blank" href="{{ $user->github_url }}">Visit GitHub Profile</a>
</div>