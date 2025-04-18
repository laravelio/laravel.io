@props(['fullWidth' => false])

<span class="{{ $fullWidth ? 'flex' : 'inline-flex' }} rounded-md shadow-xs">
    @if ($attributes->has('href'))
        <a {{ $attributes->merge(['class' => ($fullWidth ? 'w-full ' : '') . 'bg-lio-500 border border-transparent rounded-sm py-2 px-4 inline-flex justify-center text-base text-white hover:bg-lio-600 font-medium']) }}>
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->merge(['class' => ($fullWidth ? 'w-full ' : '') . 'bg-lio-500 border border-transparent rounded-sm py-2 px-4 inline-flex justify-center text-base text-white hover:bg-lio-600 font-medium']) }}>
            {{ $slot }}
        </button>
    @endif
</span>