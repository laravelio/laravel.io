<div class="thread-info-avatar">
    <a href="{{ route('profile', $user->username()) }}">
        <img class="img-circle rounded-full mr-3" src="{{ $user->gravatarUrl($size ?? 25) }}">
    </a>
</div>
