@props([
    'icon',
])

<div class="bg-lio-500 shadow rounded px-4 py-3 mb-4 text-white text-xs sm:text-sm flex">
    @svg($icon, 'h-4 w-4 inline-block self-center mr-1')
    <span>{{ $slot }}</span>
</div>