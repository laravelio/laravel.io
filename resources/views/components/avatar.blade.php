@props([
    'user',
    'unlinked' => false,
])

@unless ($unlinked)
    <a href="{{ route('profile', $user->username()) }}">
@endunless

<x-buk-avatar
    :search="$user->githubUsername()"
    provider="github"
    :fallback="asset('/images/user.svg')"
    :alt="$user->name()"
    {{ $attributes->merge(['class' => 'rounded-full text-gray-500']) }}
/>

@unless ($unlinked)
    </a>
@endunless
