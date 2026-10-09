@props([
    'user',
    'unlinked' => false,
    'showRefresh' => false,
])

<div class="relative inline-block">
    @unless ($unlinked)
        <a href="{{ route('profile', $user->username()) }}">
            @endunless

            <flux:avatar
                circle
                loading="lazy"
                src="{{ $user->avatarUrl() }}"
                alt="{{ $user->name() }}"
                {{ $attributes->merge(['class' => 'bg-gray-50']) }} />

            @unless ($unlinked)
        </a>
    @endunless

    @if ($showRefresh && $user->hasConnectedGitHubAccount() && ! $user->hasProfilePicture())
        <div class="absolute bottom-0 right-0 transform translate-x-1 translate-y-1">
            <livewire:refresh-avatar :user="$user" />
        </div>
    @endif
</div>