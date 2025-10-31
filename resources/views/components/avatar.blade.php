@props([
    'user',
    'unlinked' => false,
    'showRefresh' => false,
])

<?php
$src = $user->githubId() && ! $user->hasGitHubIdenticon()
    ? sprintf('https://avatars.githubusercontent.com/u/%s', $user->githubId())
    : asset('https://laravel.io/images/laravelio-icon-gray.svg');
?>

<div class="relative inline-block">
    @unless ($unlinked)
        <a href="{{ route('profile', $user->username()) }}">
            @endunless

            <flux:avatar
                circle
                loading="lazy"
                src="{{ $src }}"
                alt="{{ $user->name() }}"
                {{ $attributes->merge(['class' => 'bg-gray-50']) }} />

            @unless ($unlinked)
        </a>
    @endunless

    @if ($showRefresh && $user->hasConnectedGitHubAccount())
        <form method="POST" action="{{ route('avatar.refresh') }}" class="absolute bottom-[-1px] right-0">
            @csrf
            <button
                type="submit"
                class="flex items-center justify-center w-10 h-10 bg-white border-2 border-gray-300 rounded-full shadow-sm hover:bg-gray-50 hover:border-lio-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lio-500 transition-colors"
                title="Refresh avatar from GitHub">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </form>
    @endif
</div>