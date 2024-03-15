@props(['icon'])

<div class="mb-4 flex rounded bg-lio-500 px-4 py-3 text-xs text-white shadow sm:text-sm">
    @svg($icon, 'h-4 w-4 inline-block self-center mr-1')
    <span>{{ $slot }}</span>
</div>
