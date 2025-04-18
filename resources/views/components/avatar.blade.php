@props([
    'user',
    'unlinked' => false,
])

@unless ($unlinked)
    <a href="{{ route('profile', $user->username()) }}">
@endunless

@if ($user->githubUsername())
    <flux:avatar
        circle
        src="{{ sprintf('https://unavatar.io/github/%s?%s', $user->githubUsername(), http_build_query([
            'fallback' => asset('https://laravel.io/images/laravelio-icon-gray.svg'),
        ])) }}"
        {{ $attributes->merge(['class' => 'bg-gray-50']) }}
    />
@else
    <img loading="lazy"
        src="{{ asset('https://laravel.io/images/laravelio-icon-gray.svg') }}"
        alt="{{ $user->name() }}"
        {{ $attributes->merge(['class' => 'bg-gray-50 rounded-full']) }}
    />
@endif

@unless ($unlinked)
    </a>
@endunless
