@props([
    'moderators',
])

<div class="rounded-md bg-white p-5 pb-3 shadow">
    <h3 class="text-xl font-semibold">Moderators</h3>

    <ul>
        @foreach ($moderators as $moderator)
            <li
                class="{{ ! $loop->last ? 'border-b ' : '' }}flex items-center gap-x-5 pb-3 pt-5"
            >
                <x-avatar :user="$moderator" class="h-10 w-10" />

                <span class="flex flex-col">
                    <a
                        href="{{ route('profile', $moderator->username()) }}"
                        class="hover:underline"
                    >
                        <span class="font-medium text-gray-900">
                            {{ $moderator->username() }}
                        </span>
                    </a>

                    <span class="text-gray-700">
                        Joined {{ $moderator->createdAt()->format('j M Y') }}
                    </span>
                </span>
            </li>
        @endforeach
    </ul>
</div>
