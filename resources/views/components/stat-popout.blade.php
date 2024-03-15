@props(['user'])

<div {{ $attributes->merge(['class' => 'member w-64 shadow-xl rounded']) }}>
    <div class="flex justify-between rounded-t border-b bg-white p-3">
        <div class="flex flex-col items-center text-center text-lio-500">
            <span class="mb-1.5 flex h-8 min-w-8 items-center justify-center rounded bg-lio-100 px-2 font-bold">
                {{ $user->solutions_count }}
            </span>

            <span class="text-sm">Solutions</span>
        </div>

        <div class="flex flex-col items-center text-center text-lio-500">
            <span class="mb-1.5 flex h-8 min-w-8 items-center justify-center rounded bg-lio-100 px-2 font-bold">
                {{ $user->threads_count }}
            </span>

            <span class="text-sm">Threads</span>
        </div>

        <div class="flex flex-col items-center text-center text-lio-500">
            <span class="mb-1.5 flex h-8 min-w-8 items-center justify-center rounded bg-lio-100 px-2 font-bold">
                {{ $user->replies_count }}
            </span>

            <span class="text-sm">Replies</span>
        </div>
    </div>

    <div class="flex flex-col rounded-b bg-gray-100 p-3 text-sm">
        <span>{{ $user->username() }}</span>

        <span class="text-gray-500">Active since: {{ $user->createdAt()->format('F Y') }}</span>
    </div>
</div>
