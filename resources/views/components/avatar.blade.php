@props(['user'])

<x-buk-avatar
    :search="$user->githubUsername()"
    provider="github"
    :fallback="asset('/images/user.svg')"
    :alt="$user->name()"
    {{ $attributes->merge(['class' => 'rounded-full text-gray-500']) }}
/>
