@if ($attributes->has('href'))
    <a
        {{ $attributes->merge(['class' => 'flex items-center text-base text-gray-300']) }}
    >
        <span class="mr-1 text-gray-700 hover:text-gray-500">{{ $slot }}</span>
        <x-heroicon-s-arrow-right class="h-4 w-4 fill-current" />
    </a>
@else
    <button
        {{ $attributes->merge(['class' => 'flex items-center text-base text-gray-300']) }}
    >
        <span class="mr-1 text-gray-700 hover:text-gray-500">{{ $slot }}</span>
        <x-heroicon-s-arrow-right class="h-4 w-4 fill-current" />
    </button>
@endif
