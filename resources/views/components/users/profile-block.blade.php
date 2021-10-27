@props(['user'])

<div class="flex flex-col rounded-md shadow mt-6">
    <div class="bg-gray-900 rounded-t-md h-28" style="background-image: url('{{ asset('images/profile-background.svg') }}')"></div>

    <div class="flex flex-col items-center justify-center bg-white rounded-b-md pb-8">
        <x-avatar :user="$user" class="w-32 h-32 rounded-full -mt-16 mb-6" />

        <a href="{{ route('profile', $user->username()) }}" class="flex flex-col text-center text-xl font-medium mb-4 hover:underline">
            {{ $user->name() }}
            <span class="text-lg text-gray-600">{{ $user->username() }}</span>
        </a>

        <span class="text-gray-600 mb-4">
            Joined {{ $user->createdAt()->format('j M Y') }}
        </span>

        <div class="flex items-center gap-x-3">
            @if ($user->githubUsername())
                <a href="https://github.com/{{ $user->githubUsername() }}">
                    <x-icon-github class="w-6 h-6" />
                </a>
            @endif

            @if ($user->hasTwitterAccount())
                <a href="https://twitter.com/{{ $user->twitter() }}" class="text-twitter">
                    <x-icon-twitter class="w-6 h-6" />
                </a>
            @endif
        </div>
    </div>

</div>
