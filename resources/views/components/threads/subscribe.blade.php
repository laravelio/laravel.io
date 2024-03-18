@props(['thread'])

<div class="rounded-md bg-white shadow">
    <div class="flex flex-col p-5">
        <h3 class="text-xl font-semibold">Notifications</h3>

        @can(App\Policies\ThreadPolicy::UNSUBSCRIBE, $thread)
            <x-buttons.secondary-cta
                action="{{ route('threads.unsubscribe', $thread->slug()) }}"
                class="mt-3 w-full"
            >
                <span class="flex items-center justify-center gap-x-2">
                    <x-heroicon-o-speaker-x-mark class="h-6 w-6" />
                    Unsubscribe
                </span>
            </x-buttons.secondary-cta>

            <p class="mt-4 text-gray-600">
                You are currently receiving notifications of updates from this
                thread.
            </p>
        @elsecan(App\Policies\ThreadPolicy::SUBSCRIBE, $thread)
            <x-buttons.secondary-cta
                action="{{ route('threads.subscribe', $thread->slug()) }}"
                class="mt-3 w-full"
            >
                <span class="flex items-center justify-center gap-x-2">
                    <x-heroicon-o-speaker-wave class="h-6 w-6" />
                    Subscribe
                </span>
            </x-buttons.secondary-cta>

            <p class="mt-4 text-gray-600">
                You are not currently receiving notifications of updates from
                this thread.
            </p>
        @endcan
    </div>
</div>
