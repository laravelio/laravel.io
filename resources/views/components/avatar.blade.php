@props([
    'user',
    'unlinked' => false,
])

<?php
$src = $user->githubId() && !$user->hasIdenticon()
    ? sprintf('https://avatars.githubusercontent.com/u/%s', $user->githubId())
    : asset('https://laravel.io/images/laravelio-icon-gray.svg');
?>

@unless ($unlinked)
    <a href="{{ route('profile', $user->username()) }}">
@endunless

<flux:avatar
    circle
    loading="lazy"
    src="{{ $src }}"
    alt="{{ $user->name() }}"
    {{ $attributes->merge(['class' => 'bg-gray-50']) }}
/>

@unless ($unlinked)
    </a>
@endunless
