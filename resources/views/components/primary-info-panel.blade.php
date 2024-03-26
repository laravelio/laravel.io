@props([
    'icon',
])

<div class="mb-4 flex rounded bg-lio-500 px-4 py-3 text-xs text-white shadow sm:text-sm">
    @svg($icon, 'mr-1 inline-block h-4 w-4 self-center')
    <span>{{ $slot }}</span>
</div>
