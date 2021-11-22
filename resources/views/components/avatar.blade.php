@props([
    'user',
    'unlinked' => false,
])

@unless ($unlinked)
    <a href="{{ route('profile', $user->username()) }}">
@endunless

@if ($user->githubUsername())
    <x-buk-avatar
        :search="$user->githubUsername()"
        provider="github"
        :fallback="asset('/images/user.svg')"
        :alt="$user->name()"
        {{ $attributes->merge(['class' => 'rounded-full text-gray-500']) }}
    />
@else
    <div {{ $attributes->merge(['class' => 'bg-gray-50 rounded-full text-gray-500 relative flex items-center justify-center']) }}>
        <img
            src="{{ asset('images/laravelio-icon.svg') }}"
            alt="{{ $user->name() }}"
            class="filter grayscale"
        />
    </div>
@endif

@unless ($unlinked)
    </a>
@endunless
