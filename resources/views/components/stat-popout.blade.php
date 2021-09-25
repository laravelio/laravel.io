@props([
    'user'
])

<div {{ $attributes->merge(['class' => 'member w-64 shadow-xl rounded']) }}>
    <div class="flex justify-between border-b p-3 bg-white rounded-t">
        <div class="flex flex-col items-center text-lio-500 text-center">
            <span class="flex min-w-8 h-8 px-2 bg-lio-100 font-bold rounded items-center justify-center mb-1.5">
                {{ $user->solutions_count }}
            </span>

            <span class="text-sm">Solutions</span>
        </div>

        <div class="flex flex-col items-center text-lio-500 text-center">
            <span class="flex min-w-8 h-8 px-2 bg-lio-100 font-bold rounded items-center justify-center mb-1.5">
                {{ $user->threads_count }}
            </span>

            <span class="text-sm">Threads</span>
        </div>

        <div class="flex flex-col items-center text-lio-500 text-center">
            <span class="flex min-w-8 h-8 px-2 bg-lio-100 font-bold rounded items-center justify-center mb-1.5">
                {{ $user->replies_count }}
            </span>

            <span class="text-sm">Replies</span>
        </div>
    </div>

    <div class="flex flex-col bg-gray-100 p-3 text-sm rounded-b">
        <span>{{ $user->username() }}</span>

        <span class="text-gray-500">Active since: {{ $user->createdAt()->format('F Y') }}</span>
    </div>
</div>