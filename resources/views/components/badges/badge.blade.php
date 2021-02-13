@props([
    'hasDot' => false,
])

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800']) }}>
    @if ($hasDot)
    <svg class="-ml-1 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    @endif

    {{ $slot }}
</span>
