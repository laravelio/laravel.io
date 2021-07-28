@props(['moderators'])

<div class="bg-white shadow rounded-md">
    <h3 class="text-xl font-semibold px-5 pt-5">Moderators</h3>
    <ul>
        @foreach ($moderators as $moderator)
            <li class="{{ ! $loop->last ? 'border-b ' : '' }}flex items-center gap-x-5 pb-3 pt-5 px-5">
                <a href="{{ route('profile', $moderator->username()) }}" class="hover:underline">
                    <x-avatar :user="$moderator" class="w-10 h-10" />
                </a>

                <span class="flex flex-col">
                    <a href="{{ route('profile', $moderator->username()) }}" class="hover:underline">
                        <span class="text-gray-900 font-medium">
                            {{ $moderator->name() }}
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