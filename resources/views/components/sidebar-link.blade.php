@props([
    'active' => false,
    'icon',
])

<a {{ $attributes }} class="group rounded-md px-3 py-2 flex items-center text-sm font-medium {{ $active ? 'bg-gray-50 text-orange-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50' }}">
    @svg($icon, 'flex-shrink-0 -ml-1 mr-3 h-6 w-6' . ($active ? ' text-lio-500' : ' text-gray-400 group-hover:text-gray-500'))
    <span class="truncate">
        {{ $slot }}
    </span>
</a>

