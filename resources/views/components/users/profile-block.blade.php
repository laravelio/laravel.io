@props(['user'])

<div class="mt-6 flex flex-col rounded-md shadow">
    <div class="h-28 rounded-t-md bg-gray-800" style="background-image: url('{{ asset('images/default-background.svg') }}')"></div>

    <div class="flex flex-col items-center justify-center rounded-b-md bg-white pb-8">
        <x-avatar :user="$user" class="-mt-16 mb-6 h-32 w-32 rounded-full" />

        <a href="{{ route('profile', $user->username()) }}" class="mb-4 flex flex-col text-center text-xl font-medium hover:underline">
            {{ $user->name() }}
            <span class="text-lg text-gray-600">{{ $user->username() }}</span>
        </a>

        <span class="mb-4 text-gray-600"> Joined {{ $user->createdAt()->format('j M Y') }} </span>

        <div class="flex items-center gap-x-3">
            @if ($user->githubUsername())
                <a href="https://github.com/{{ $user->githubUsername() }}">
                    <x-icon-github class="h-6 w-6" />
                </a>
            @endif

            @if ($user->hasTwitterAccount())
                <a href="https://twitter.com/{{ $user->twitter() }}" class="text-twitter">
                    <x-si-x class="h-6 w-6" />
                </a>
            @endif

            @if ($user->hasWebsite())
                <a href="{{ $user->website() }}">
                    <x-heroicon-o-globe-alt class="h-6 w-6" />
                </a>
            @endif
        </div>
    </div>
</div>
