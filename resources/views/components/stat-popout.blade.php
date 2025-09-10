@props([
    'user'
])

<div {{ $attributes->merge(['class' => 'member w-64 shadow-xl rounded-sm']) }}>
    <div class="flex flex-col bg-gray-100 p-3 text-sm rounded-b">
        <span>{{ $user->username() }}</span>

        <span class="text-gray-500">Active since: {{ $user->createdAt()->format('F Y') }}</span>
    </div>
</div>