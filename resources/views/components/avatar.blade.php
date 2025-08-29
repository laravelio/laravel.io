@props([
    'user',
    'unlinked' => false,
])

<?php
$src = $user->githubUsername()
    ? sprintf('https://unavatar.io/github/%s?%s', $user->githubUsername(), http_build_query([
        'fallback' => asset('https://laravel.io/images/laravelio-icon-gray.svg'),
    ]))
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
